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
        return view('applicants.index-partner', compact('vehicles', 'role_status', 'appointments'));
    }

    public function fetchAllPartnerApplicant()
    {
        // Query applicants with associated appointments where the appointment is 'Partner/Supplier'
        $applicants = Applicant::where('approval_status', 'Pending')
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
}
