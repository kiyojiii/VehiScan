<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Applicant;
use App\Models\Appointment;
use App\Models\Statuses;
use App\Models\Vehicle;
use App\Models\Driver;

class ApplicantPartnerController extends Controller
{
    public function index()
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();

        $totalpartnersupplier = Applicant::join('appointments', 'applicants.appointment_id', '=', 'appointments.id')
            ->where('appointments.appointment', 'Partner/Supplier')
            ->count();

        return view('applicants.index-partner', compact('totalpartnersupplier', 'vehicles', 'role_status', 'appointments'));
    }

    public function fetchAllPartnerApplicant()
    {
        // Query applicants with associated appointments where the appointment is 'Partner/Supplier'
        $applicants = Applicant::whereHas('appointment', function ($query) {
            $query->where('appointment', 'Partner/Supplier');
        })->get();

        $output = '';

        if ($applicants->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Vehicle</th>
                <th>Position</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';

            foreach ($applicants as $rs) {
                // Find the vehicle associated with the owner
                $vehicle = Vehicle::find($rs->vehicle_id);

                // Get the plate number or set it to 'N/A' if not found
                $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';

                $output .= '<tr>
                    <td>' . $rs->id . '</td>
                    <td>' . $rs->first_name . ' ' . $rs->middle_initial . '. ' . $rs->last_name . '</td>
                    <td>' . $vehiclePlate . '</td>
                    <td>' . $rs->position_designation . '</td>
                    <td>' . $rs->approval_status . '</td>
                    <td>
                        <a href="' . route('applicants.show', $rs->id) . '" class="text-primary mx-1"><i class="bi bi-eye h4"></i></a>
                        <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteApplicant"><i class="bi-trash h4"></i></a>
                    </td>
                </tr>';
            }

            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }
    }

    public function rejected()
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        return view('applicants.rejected-partner', compact('vehicles', 'role_status', 'appointments'));
    }

    public function fetchAllRejectedPartnerApplicant()
    {
        // Query applicants with associated appointments where the appointment is 'Partner/Supplier'
        $applicants = Applicant::where('approval_status', 'Rejected')
            ->join('appointments', 'applicants.appointment_id', '=', 'appointments.id')
            ->where('appointments.appointment', 'Partner/Supplier')
            ->get();

        $output = '';
        if ($applicants->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Vehicle</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($applicants as $rs) {
                // Find the vehicle associated with the owner
                $vehicle = Vehicle::find($rs->vehicle_id);

                // Get the plate number or set it to 'N/A' if not found
                $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';

                $output .= '<tr>
                <td>' . $rs->id . '</td>
                <td>' . $rs->first_name . ' ' . $rs->middle_initial . '. ' . $rs->last_name . '</td>
                <td>' . $vehiclePlate . '</td>
                <td>' . $rs->approval_status . '</td>
                <td>' . substr($rs->reason, 0, 2) . '</td>
                <td>
                    <a href="' . route('owners.show', $rs->id) . '" class="text-primary mx-1"><i class="bi bi-eye h4"></i></a>
                    <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" onClick="edit()"><i class="bi-pencil-square h4"></i></a>
                    <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
            </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }
    }

    public function index_vehicles_partner_supplier()
    {
        $drivers = Driver::all();

        $owners = Applicant::whereHas('appointment', function ($query) {
            $query->where('appointment', 'Partner/Supplier');
        })->get();

        $vehicles = Vehicle::all();

        // Query applicants with associated appointments where the appointment is 'Partner/Supplier'
        $applicants = Applicant::whereHas('appointment', function ($query) {
            $query->where('appointment', 'Partner/Supplier');
        })->get();

        // Extract the IDs of the applicants
        $applicantIds = $applicants->pluck('id');

        // Query vehicles of the selected applicants
        $totalpartnervehicles = Vehicle::whereIn('owner_id', $applicantIds)->count();

        return view('partner_supplier.index_vehicles', compact('vehicles', 'totalpartnervehicles', 'owners', 'drivers'));
    }

    public function fetchAllPartnerVehicle()
    {
        // Query applicants with associated appointments where the appointment is 'Partner/Supplier'
        $applicants = Applicant::whereHas('appointment', function ($query) {
            $query->where('appointment', 'Partner/Supplier');
        })->get();

        // Extract the IDs of the applicants
        $applicantIds = $applicants->pluck('id');

        // Query vehicles of the selected applicants
        $vehicles = Vehicle::whereIn('owner_id', $applicantIds)->get();

        $output = '';
        if ($vehicles->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th class="text-center">Owner</th>
                            <th class="text-center">Plate Number</th>
                            <th class="text-center">Vehicle Make</th>
                            <th class="text-center">Vehicle Code</th>
                            <th class="text-center">Front Photo</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($vehicles as $vehicle) {
                $driverName = Driver::find($vehicle->driver_id)->driver_name ?? 'N/A';
                $owner_first = Applicant::find($vehicle->owner_id)->first_name ?? 'N/A';
                $first_letter = ucfirst(substr($owner_first, 0, 1)); // Capitalize the first letter
                $owner_last = ucfirst(Applicant::find($vehicle->owner_id)->last_name) ?? 'N/A';
                // Concatenate vehicle_code and color into the data string for QR code
                // $qrData = "Code: {$vehicle->vehicle_code}\nColor: {$vehicle->color}";
                // $qrData = "{$vehicle->vehicle_code}";
                // $barcode = new DNS2D();
                // $qrCodeHTML = $barcode->getBarcodeHTML($qrData, 'QRCODE', 4, 4);

                // Path to the image
                // $imagePath = asset('images/seal.jpg');

                // Concatenate QR code HTML with image HTML
                // Generate QR code with the same parameters as the download method
                // $qrCode = QrCode::format('png')
                //   ->size(50)
                //   ->errorCorrection('H')
                //   ->generate($vehicle->vehicle_code);

                // // Convert the binary data to base64
                // $qrCodeBase64 = base64_encode($qrCode);

                $output .= '<tr>
                <td>' . $vehicle->id . '</td>
                <td class="text-center">' . $first_letter . '. ' . $owner_last . '</td>
                <td class="text-center">' . $vehicle->plate_number . '</td>
                <td class="text-center">' . $vehicle->vehicle_make . '</td>
                <td class="text-center">' . $vehicle->vehicle_code . ' </td>
                <td class="text-center">
                    <img src="' . asset('storage/images/vehicles/' . $vehicle->front_photo) . '" alt="Side Photo" style="max-width: 50px; max-height: 50px;">
                </td>
                <td class="text-center">' . $vehicle->registration_status . '</td>
                <td class="text-center">
                    <a href="' . route('vehicles.show', $vehicle->id) . '" class="text-primary mx-1"><i class="bi bi-eye h4"></i></a>
                    <a href="#" id="' . $vehicle->id . '" class="text-success mx-1 editIcon" onClick="edit()"><i class="bi-pencil-square h4"></i></a>';

                $output .= '<style>.disabled-link { pointer-events: none; opacity: 0.5; }</style>';

                // Check vehicle registration status
                if ($vehicle->registration_status == 'Inactive') {
                    // If registration status is 'Inactive', disable the deactivate button
                    $output .= '<a href="#" id="' . $vehicle->id . '" class="text-danger mx-1 deactivateIcon disabled-link"><i class="bi-dash-circle h4"></i></a>';
                } else {
                    // Otherwise, display the deactivate button as a link
                    $output .= '<a href="#" id="' . $vehicle->id . '" class="text-danger mx-1 deactivateIcon"><i class="bi-dash-circle h4"></i></a>';
                }

                $output .= '<a href="#" id="' . $vehicle->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
            </tr>';
            }
            $output .= '</tbody></table>';
        } else {
            $output = '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }
        return $output;
    }
}
