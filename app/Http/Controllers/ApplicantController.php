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
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $applicantcount = Applicant::count();
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('applicants.index', compact('applicantcount', 'drivers', 'vehicles', 'role_status', 'appointments'));
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
                        <a href="' . route('applicants.show', $rs->id) . '" class="text-primary mx-1"><i class="bi bi-eye h4"></i></a>
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

    public function manage()
    {
        $applicantcount = Applicant::count();
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('applicants.manage', compact('applicantcount', 'drivers', 'vehicles', 'role_status', 'appointments'));
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
                    <a href="' . route('applicants.show', $rs->id) . '" class="text-primary mx-1"><i class="bi bi-eye h4"></i></a>
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

    public function vehicleCodeExists($number)
    {
        return Vehicle::whereVehicleCode($number)->exists();
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
                'serial_number' => 'required|string|max:255',
                'id_number' => 'required|string|max:255',
                // Vehicle Details
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

            // Set Approval and Reason Default Value
            $approval_status = $request->input('approval_status', 'Approved');
            $reason = $request->input('reason', 'None / Approved');

            // Generate QR CODE
            $number = mt_rand(1000000000, 9999999999);

            if ($this->vehicleCodeExists($number)) {
                $number = mt_rand(1000000000, 999999999);
            }

            // Create new applicant data with user_id
            $ownerData = [
                'user_id' => $user_id,
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
                'approval_status' => $approval_status, // Default
                'reason' => $reason, // Default
                'serial_number' => $request->serial_number,
                'id_number' => $request->id_number,
                'scan_or_photo_of_id' => $fileName,
            ];

            // Create new vehicle data with user_id and unique file names
            $vehicleData = [
                'user_id' => $user_id,
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
                'approval_status' => $approval_status, // Default
                'reason' => $reason, // Default
                'registration_status' => $request->registration_status,
                'vehicle_code' => $number
            ];

            // Create new applicant data with user_id and unique file names
            $driverData = [
                'user_id' => $user_id,
                'driver_name' => $request->dname,
                'driver_license_image' => $dlfileName,
                'authorized_driver_license_image' => $adlfileName,
                'authorized_driver_name' => $request->adname,
                'authorized_driver_address' => $request->adaddress,
                'approval_status' => $approval_status, // Default
                'reason' => $reason, // Default
            ];

            // Create the applicant record
            $applicant = Applicant::create($ownerData);
            // Create the vehicle record
            $vehicle = Vehicle::create($vehicleData);
            // Update the vehicle data with the retrieved owner_id
            $vehicle->update(['owner_id' => $applicant->id]);
            // Update the owner data with the retrieved vehicle_id
            $ownerData['vehicle_id'] = $vehicle->id;
            // Update the applicant record with the retrieved vehicle_id
            $applicant->update(['vehicle_id' => $vehicle->id]);
            // Create the driver record
            $driver = Driver::create($driverData);
            // Update the vehicle data with the retrieved driver_id
            $vehicle->update(['driver_id' => $driver->id]);
            // Update the owner data with the retrieved driver_id
            $ownerData['driver_id'] = $driver->id;
            // Update the applicant record with the retrieved driver_id
            $applicant->update(['driver_id' => $driver->id]);

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

    // public function edit($id)
    // {
    //     $role_status = Statuses::all();
    //     $appointments = Appointment::all();
    //     $vehicles = Vehicle::find($id);
    //     $owners = Applicant::find($id);
    //     $drivers = Driver::find($id);
    //     return view('applicants.edit', compact('appointments', 'role_status', 'drivers', 'vehicles', 'owners'));
    // }

    // EDIT OWNER
    public function edit(Request $request)
    {
        $id = $request->id;
        $owner = Applicant::find($id);
        return response()->json($owner);
    }

    // UPDATE OWNER
    public function update(Request $request)
    {
        try {
            // Before validating the request, modify the reason field if approval is "Approved"
            $request->merge([
                'reason' => $request->approval === 'Approved' ? 'None / Approved' : $request->reason,
            ]);
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                // Applicant
                'fname' => 'string|max:255',
                'mi' => 'string|size:1',
                'lname' => 'string|max:255',
                'paddress' => 'string|max:255',
                'email' => 'email|unique:applicants,email_address,' . $request->applicant_id, // Use ignore rule to exclude the current record
                'contact' => 'string|numeric|digits_between:1,11',
                'appointment' => 'string|max:255',
                'role_status' => 'string|max:255',
                'department' => 'string|max:255',
                'position' => 'string|max:255',
                'scan_or_photo_of_id' => 'nullable|image|max:2048', // Assuming it's an image file
                'serial_number' => 'string|max:255',
                'id_number' => 'string|max:255',
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            $fileName = '';

            // APPLICANT

            // Retrieve the owner record
            $owner = Applicant::find($request->applicant_id);

            // Process file upload
            if ($request->hasFile('scan_or_photo_of_id')) {
                $file = $request->file('scan_or_photo_of_id');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                // Delete the old file if it exists
                if ($owner->scan_or_photo_of_id) {
                    Storage::delete('public/images/' . $owner->scan_or_photo_of_id);
                }
            } else {
                $fileName = $request->applicant_photo;
            }

            $approvalStatus = $request->approval;
            $reason = $request->filled('reason') ? $request->reason : null;

            // If approval status is 'Approved', set reason to 'None / Approved'
            if ($approvalStatus == 'Approved') {
                $reason = 'None / Approved';
            }

            // Update owner data
            $ownerData = [
                'vehicle_id' => $request->vehicle_details,
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
                'approval_status' => $approvalStatus, // Default
                'reason' => $reason, // Default
                'serial_number' => $request->serial_number,
                'id_number' => $request->id_number,
                'scan_or_photo_of_id' => $fileName,
            ];

            $owner->update($ownerData);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Owner updated successfully.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // EDIT VEHICLE
    public function edit_vehicle(Request $request)
    {
        $id = $request->id;
        $vehicle = Vehicle::find($id);
        return response()->json($vehicle);
    }


    // UPDATE VEHICLE
    public function update_vehicle(Request $request)
    {
        try {

            // Before validating the request, modify the reason field if approval is "Approved"
            $request->merge([
                'reason' => $request->vehicle_approval_status === 'Approved' ? 'None / Approved' : $request->vehicle_reason,
            ]);

            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'driver_details' => 'string|max:255',
                'owner_address' => 'string|max:2048',
                'plate_number' => 'string|max:255',
                'vehicle_make' => 'string|max:255',
                'year_model' => 'string|max:255',
                'color' => 'string|max:255',
                'body_type' => 'string|max:255',
                'official_receipt_image' => 'image|max:2048',
                'certificate_of_registration_image' => 'image|max:2048',
                'deed_of_sale_image' => 'image|max:2048',
                'authorization_letter_image' => 'image|max:2048',
                'front_photo' => 'image|max:2048',
                'side_photo' => 'image|max:2048',
                'vehicle_approval_status' => 'string|max:255',
                'vehicle_reason' => 'nullable|string|max:255',
                'registration_status' => 'required|string|max:255',
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Retrieve the vehicle record
            $vehicle = Vehicle::find($request->vehicle_id);

            // Process file uploads and update filenames
            $fileFields = [
                'front_photo',
                'side_photo',
            ];

            $fileFieldDoc = [
                'official_receipt_image',
                'certificate_of_registration_image',
                'deed_of_sale_image',
                'authorization_letter_image',
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/images/vehicles', $fileName);
                    // Delete the old file if it exists
                    if ($vehicle->$field) {
                        Storage::delete('public/images/vehicles/' . $vehicle->$field);
                    }
                    $vehicle->$field = $fileName;
                }
            }

            foreach ($fileFieldDoc as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/images/vehicles/documents', $fileName);
                    // Delete the old file if it exists
                    if ($vehicle->$field) {
                        Storage::delete('public/images/vehicles/documents/' . $vehicle->$field);
                    }
                    $vehicle->$field = $fileName;
                }
            }

            $approvalStatus = $request->vehicle_approval_status;
            $reason = $request->filled('vehicle_reason') ? $request->vehicle_reason : null;

            // If approval status is 'Approved', set reason to 'None / Approved'
            if ($approvalStatus == 'Approved') {
                $reason = 'None / Approved';
            }

            // Update vehicle data
            $vehicle->update([
                'driver_id' => $request->driver_details,
                'owner_address' => $request->owner_address,
                'plate_number' => $request->plate_number,
                'vehicle_make' => $request->vehicle_make,
                'year_model' => $request->year_model,
                'color' => $request->color,
                'body_type' => $request->body_type,
                'approval_status' => $approvalStatus,
                'reason' => $reason,
                'registration_status' => $request->registration_status,
            ]);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Vehicle updated successfully.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit_driver(Request $request)
    {
        $id = $request->id;
        $driver = Driver::find($id);
        return response()->json($driver);
    }

    public function update_driver(Request $request)
    {
        try {

            // Before validating the request, modify the reason field if approval is "Approved"
            $request->merge([
                'reason' => $request->approval === 'Approved' ? 'None / Approved' : $request->reason,
            ]);
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'dname' => 'required|string|max:255',
                'driver_license_image' => 'image|max:2048', // Assuming it's an image file
                'adname' => 'string|max:255',
                'adaddress' => 'string|max:255',
                'authorized_driver_license_image' => 'image|max:2048', // Assuming it's an image file
                'driver_approval_status' => 'required|string|max:255',
                'driver_reason' => 'nullable|string|max:255',
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Retrieve the driver record
            $driver = Driver::find($request->driver_id);

            // Process file upload for driver's license image
            if ($request->hasFile('driver_license_image')) {
                $dlfile = $request->file('driver_license_image');
                $dlfileName = Str::uuid() . '.' . $dlfile->getClientOriginalExtension();
                $dlfile->storeAs('public/images/drivers', $dlfileName); //php artisan storage:link
                // Delete the old file if it exists
                if ($driver->driver_license_image) {
                    Storage::delete('public/images/drivers/' . $driver->driver_license_image);
                }
            } else {
                $dlfileName = $driver->driver_license_image;
            }

            // Process file upload for authorized driver's license image
            if ($request->hasFile('authorized_driver_license_image')) {
                $adlfile = $request->file('authorized_driver_license_image');
                $adlfileName = Str::uuid() . '.' . $adlfile->getClientOriginalExtension();
                $adlfile->storeAs('public/images/drivers', $adlfileName); //php artisan storage:link
                // Delete the old file if it exists
                if ($driver->authorized_driver_license_image) {
                    Storage::delete('public/images/drivers/' . $driver->authorized_driver_license_image);
                }
            } else {
                $adlfileName = $driver->authorized_driver_license_image;
            }

            $approvalStatus = $request->driver_approval_status;
            $reason = $request->filled('driver_reason') ? $request->driver_reason : null;

            // If approval status is 'Approved', set reason to 'None / Approved'
            if ($approvalStatus == 'Approved') {
                $reason = 'None / Approved';
            }

            // Update driver data
            $driverData = [
                'driver_name' => $request->dname,
                'authorized_driver_name' => $request->adname,
                'authorized_driver_address' => $request->adaddress,
                'approval_status' => $approvalStatus,
                'reason' => $reason,
                'driver_license_image' => $dlfileName,
                'authorized_driver_license_image' => $adlfileName,
            ];

            $driver->update($driverData);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Driver updated successfully.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $drivers = Driver::all();
        $vehicles = Vehicle::all();
        $owners = Applicant::findOrFail($id);

        // Retrieve the vehicle associated with the owner
        $vehicle = $owners->vehicle;

        // Generate QR code based on the vehicle's code
        $qrCode = QrCode::format('png')
            ->size(50)
            ->errorCorrection('H')
            ->generate($vehicle->vehicle_code);

        // Convert the binary data to base64
        $qrCodeBase64 = base64_encode($qrCode);

        return view('applicants.show', compact('vehicle', 'qrCodeBase64', 'appointments', 'role_status', 'drivers', 'vehicles', 'owners'));
    }

    public function form()
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('forms.applicant', compact('drivers', 'vehicles', 'role_status', 'appointments'));
    }

    public function approve_applicant(Request $request)
    {
        $id = $request->id;
        $applicant = Applicant::find($id);
        if (!$applicant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Applicant not found'
            ], 404);
        }

        // Change Approval Status
        $applicant->approval_status = 'Approved';
        $applicant->reason = 'None / Approved';
        $applicant->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Applicant Approved'
        ]);
    }


    public function approve_vehicle(Request $request)
    {
        $id = $request->id;
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found'
            ], 404);
        }

        // Change Approval Status
        $vehicle->registration_status = 'Active';
        $vehicle->approval_status = 'Approved';
        $vehicle->reason = 'None / Approved';
        $vehicle->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle Approved'
        ]);
    }

    public function approve_driver(Request $request)
    {
        $id = $request->id;
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver not found'
            ], 404);
        }

        // Change Approval Status
        $driver->approval_status = 'Approved';
        $driver->reason = 'None / Approved';
        $driver->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Driver Approved'
        ]);
    }

    public function reject_applicant(Request $request)
    {
        $id = $request->id;
        $reason = $request->reason; // Get the reason from the request

        // Find the vehicle
        $applicant = Applicant::find($id);
        if (!$applicant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Applicant not found'
            ], 404);
        }

        // Change registration_status to Inactive
        $applicant->approval_status = 'Rejected';
        $applicant->reason = $reason; // Assign the provided reason
        $applicant->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Applicant Has Been Rejected'
        ]);
    }

    public function reject_vehicle(Request $request)
    {
        $id = $request->id;
        $reason = $request->reason; // Get the reason from the request

        // Find the vehicle
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found'
            ], 404);
        }

        // Change registration_status to Inactive
        $vehicle->approval_status = 'Inactive';
        $vehicle->approval_status = 'Rejected';
        $vehicle->reason = $reason; // Assign the provided reason
        $vehicle->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle Has Been Rejected'
        ]);
    }

    public function reject_driver(Request $request)
    {
        $id = $request->id;
        $reason = $request->reason; // Get the reason from the request

        // Find the Driver
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver not found'
            ], 404);
        }

        // Change registration_status to Inactive
        $driver->approval_status = 'Rejected';
        $driver->reason = $reason; // Assign the provided reason
        $driver->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Driver Has Been Rejected'
        ]);
    }

    public function approve_all(Request $request)
    {
        $ownerId = $request->owner_id;
        $vehicleId = $request->vehicle_id;
        $driverId = $request->driver_id;

        $owner = Applicant::find($ownerId);
        $vehicle = Vehicle::find($vehicleId);
        $driver = Driver::find($driverId);
        if (!$owner) {
            return response()->json([
                'status' => 'error',
                'message' => 'Applicant not found'
            ], 404);
        }

        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found'
            ], 404);
        }

        if (!$driver) {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver not found'
            ], 404);
        }

        // Owner Approval Status
        $owner->approval_status = 'Approved';
        $owner->reason = 'None / Approved';
        $owner->save();
        // Vehicle Approval Status
        $vehicle->registration_status = 'Active';
        $vehicle->approval_status = 'Approved';
        $vehicle->reason = 'None / Approved';
        $vehicle->save();
        // Driver Approval Status
        $driver->approval_status = 'Approved';
        $driver->reason = 'None / Approved';
        $driver->save();

        return response()->json([
            'status' => 'success',
            'message' => 'All Approved'
        ]);
    }
}
