<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\Appointment;
use App\Models\Statuses;
use App\Models\Vehicle;
use App\Models\Driver;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('applicants.index', compact('drivers', 'vehicles', 'role_status', 'appointments'));
    }

    public function fetchPendingApplicant()
    {
        $applicant = Applicant::where('approval_status', 'Pending')->get();
        $output = '';
        if ($applicant->count() > 0) {
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
            foreach ($applicant as $rs) {
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

    // insert a new applicant ajax request
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                // Applicant Details
                'fname' => 'required|string|max:255',
                'mi' => 'required|string|size:1',
                'lname' => 'required|string|max:255',
                'paddress' => 'required|string|max:255',
                'email' => 'required|email|unique:applicants,email_address,' . $request->owner_id, // Use ignore rule to exclude the current record
                'contact' => 'required|string|numeric|digits_between:1,11',
                'appointment' => 'required|string|max:255',
                'role_status' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'applicant_approval' => 'nullable|string|max:255',
                'applicant_reason' => 'nullable|string|max:255',
                'scan_or_photo_of_id' => 'image|max:2048', // Assuming it's an image file
                'vehicle' => 'nullable|integer',
                'serial_number' => 'required|string|max:255',
                'id_number' => 'required|string|max:255',
                // Vehicle Details
                'driver_id' => 'required|string|max:255',
                'owner_address' => 'required|string|max:2048',
                'plate_number' => 'required|string|max:255',
                'vehicle_make' => 'required|string|max:255',
                'year_model' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'body_type' => 'required|string|max:255',
                'official_receipt_image' => 'required|image|max:2048',
                'certificate_of_registration_image' => 'required|image|max:2048',
                'deed_of_sale_image' => 'required|image|max:2048',
                'authorization_letter_image' => 'required|image|max:2048',
                'front_photo' => 'required|image|max:2048',
                'side_photo' => 'required|image|max:2048',
                'vehicle_approval' => 'nullable|string|max:255',
                'vehicle_reason' => 'nullable|string|max:255',
                'registration_status' => 'required|string|max:25',
                // Driver Details
                'dname' => 'required|string|max:255|unique:drivers,driver_name,' . $request->driver_id,
                'driver_license_image' => 'required|image|max:2048',
                'adname' => 'string|max:255|unique:drivers,authorized_driver_name,' . $request->driver_id,
                'adaddress' => 'string|max:255',
                'authorized_driver_license_image' => 'image|max:2048',
                'driver_approval' => 'nullable|string|max:255',
                'driver_reason' => 'nullable|string|max:255',

            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Get the currently authenticated user's ID
            $user_id = auth()->id();

            // Applicant Image
            if ($request->hasFile('scan_or_photo_of_id')) {
                $file = $request->file('scan_or_photo_of_id');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName); //php artisan storage:link
            } else {
                throw new \Exception('Photo file is required.');
            }

            // Vehicle Image
            // Generate unique file names using UUIDs
            $orifileName = Str::uuid() . '.' . $request->file('official_receipt_image')->getClientOriginalExtension();
            $crifileName = Str::uuid() . '.' . $request->file('certificate_of_registration_image')->getClientOriginalExtension();
            $dsifileName = Str::uuid() . '.' . $request->file('deed_of_sale_image')->getClientOriginalExtension();
            $alifileName = Str::uuid() . '.' . $request->file('authorization_letter_image')->getClientOriginalExtension();
            $fpfileName = Str::uuid() . '.' . $request->file('front_photo')->getClientOriginalExtension();
            $spfileName = Str::uuid() . '.' . $request->file('side_photo')->getClientOriginalExtension();

            // Store each file with unique file names
            $request->file('official_receipt_image')->storeAs('public/images/vehicles/documents', $orifileName);
            $request->file('certificate_of_registration_image')->storeAs('public/images/vehicles/documents', $crifileName);
            $request->file('deed_of_sale_image')->storeAs('public/images/vehicles/documents', $dsifileName);
            $request->file('authorization_letter_image')->storeAs('public/images/vehicles/documents', $alifileName);
            $request->file('front_photo')->storeAs('public/images/vehicles', $fpfileName);
            $request->file('side_photo')->storeAs('public/images/vehicles', $spfileName);

            // Driver Image
            // Generate unique file names using UUIDs
            $dlfileName = Str::uuid() . '.' . $request->file('driver_license_image')->getClientOriginalExtension();
            $adlfileName = Str::uuid() . '.' . $request->file('authorized_driver_license_image')->getClientOriginalExtension();
            // Store driver license image
            $request->file('driver_license_image')->storeAs('public/images/drivers', $dlfileName);
            // Store authorized driver license image
            $request->file('authorized_driver_license_image')->storeAs('public/images/drivers', $adlfileName);

            // Create new applicant data with user_id
            $ownerData = [
                'user_id' => $user_id,
                'vehicle_id' => $request->vehicle,
                'first_name' => $request->fname,
                'middle_initial' => $request->mi,
                'last_name' => $request->lname,
                'present_address' => $request->paddress,
                'email_address' => $request->email,
                'contact_number' => $request->contact,
                'appointment_id' => $request->appointment,
                'status_id' => $request->role_status,
                'office_department_agency' => $request->department,
                'position_designation' => $request->position,
                'approval_status' => $request->filled('applicant_approval') ? $request->approval_status : 'Approved', // Check if reason is empty
                'reason' => $request->filled('applicant_reason') ? $request->reason : 'None / Approved', // Check if reason is empty
                'serial_number' => $request->serial_number,
                'id_number' => $request->id_number,
                'scan_or_photo_of_id' => $fileName,
            ];

            // Create new vehicle data with user_id and unique file names
            $vehicleData = [
                'user_id' => $user_id,
                'driver_id' => $request->driver_id,
                'owner_address' => $request->owner_address,
                'plate_number' => $request->plate_number,
                'vehicle_make' => $request->vehicle_make,
                'year_model' => $request->year_model,
                'color' => $request->color,
                'body_type' => $request->body_type,
                'official_receipt_image' => $orifileName,
                'certificate_of_registration_image' => $crifileName,
                'deed_of_sale_image' => $dsifileName,
                'authorization_letter_image' => $alifileName,
                'front_photo' => $fpfileName,
                'side_photo' => $spfileName,
                'approval_status' => $request->filled('vehicle_approval') ? $request->approval_status : 'Approved', // Check if reason is empty
                'reason' => $request->filled('vehicle_reason') ? $request->reason : 'None / Approved', // Check if reason is empty
                'registration_status' => $request->registration_status,
            ];

            // Create new applicant data with user_id and unique file names
            $driverData = [
                'user_id' => $user_id,
                'driver_name' => $request->dname,
                'driver_license_image' => $dlfileName,
                'authorized_driver_license_image' => $adlfileName,
                'authorized_driver_name' => $request->adname,
                'authorized_driver_address' => $request->adaddress,
                'approval_status' => $request->filled('driver_approval') ? $request->approval_status : 'Approved', // Check if reason is empty
                'reason' => $request->filled('reason') ? $request->reason : 'None / Approved', // Check if reason is empty
            ];


            // Create the applicant record
            Applicant::create($ownerData);
            // Create the vehicle record
            Vehicle::create($vehicleData);
            // Create the applicant record
            Driver::create($driverData);

            return response()->json([
                'status' => 200,
                'message' => 'Applicant created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function manage()
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('applicants.manage', compact('drivers', 'vehicles', 'role_status', 'appointments'));
    }

    public function ManageApplicant()
    {
        // $applicant = Applicant::where('approval_status', 'Approved')->get();
        $applicant = Applicant::all();
        $output = '';
        if ($applicant->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Vehicle</th>
                <th>Office</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($applicant as $rs) {
                // Find the vehicle associated with the owner
                $vehicle = Vehicle::find($rs->vehicle_id);

                // Get the plate number or set it to 'N/A' if not found
                $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';

                $output .= '<tr>
                <td>' . $rs->id . '</td>
                <td>' . $rs->first_name . ' ' . $rs->middle_initial . '. ' . $rs->last_name . '</td>
                <td>' . $vehiclePlate . '</td>
                <td>' . $rs->office_department_agency . '</td>
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

    public function form()
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('forms.applicant', compact('drivers', 'vehicles', 'role_status', 'appointments'));
    }
}
