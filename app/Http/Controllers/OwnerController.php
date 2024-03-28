<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\Appointment;
use App\Models\Statuses;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Violation;
use App\Models\Vehicle_Record;
use App\Models\Time; // Make sure to import the Time model
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalowner = Applicant::count();
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        return view('owners.index', compact('totalowner', 'vehicles', 'role_status', 'appointments'));
    }

    public function fetchAllOwner()
    {
        $owner = Applicant::all();
        $output = '';
        if ($owner->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Vehicle</th>
                <th>Department</th>
                <th>Position</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($owner as $rs) {
                // Find the vehicle associated with the owner
                $vehicle = Vehicle::find($rs->vehicle_id);

                // Get the plate number or set it to 'N/A' if not found
                $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';

                $output .= '<tr>
                    <td>' . $rs->id . '</td>
                    <td>' . $rs->first_name . ' ' . $rs->middle_initial . '. ' . $rs->last_name . '</td>
                    <td>' . $vehiclePlate . '</td>
                    <td>' . $rs->office_department_agency . '</td>
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

    // insert a new owner ajax request
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
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
                'approval' => 'required|string|max:255',
                'reason' => 'nullable|string|max:255',
                'scan_or_photo_of_id' => 'image|max:2048', // Assuming it's an image file
                'vehicle' => 'nullable|integer',
                'serial_number' => 'required|string|max:255',
                'id_number' => 'required|string|max:255',
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

            // Process file upload
            if ($request->hasFile('scan_or_photo_of_id')) {
                $file = $request->file('scan_or_photo_of_id');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName); //php artisan storage:link
            } else {
                throw new \Exception('Photo file is required.');
            }

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
                'approval_status' => $request->approval,
                'reason' => $request->filled('reason') ? $request->reason : 'None / Approved', // Check if reason is empty
                'serial_number' => $request->serial_number,
                'id_number' => $request->id_number,
                'scan_or_photo_of_id' => $fileName,
            ];

            // Create the applicant record
            Applicant::create($ownerData);

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

    public function edit(Request $request)
    {
        $id = $request->id;
        $owner = Applicant::find($id);
        return response()->json($owner);
    }

    public function update(Request $request)
    {
        try {

            // Before validating the request, modify the reason field if approval is "Approved"
            $request->merge([
                'reason' => $request->approval === 'Approved' ? 'None / Approved' : $request->reason,
            ]);
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
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
                'approval' => 'required|string|max:255',
                'reason' => 'nullable|string|max:255',
                'serial_number' => 'required|string|max:255',
                'id_number' => 'required|string|max:255',
                'vehicle_details' => 'nullable|integer',
                'scan_or_photo_of_id' => 'nullable|image|max:2048', // Assuming it's an image file
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            $fileName = '';

            // Retrieve the owner record
            $owner = Applicant::find($request->owner_id);

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
                $fileName = $request->owner_photo;
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
                'approval_status' => $request->approval,
                'reason' => $request->reason,
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

    // delete an owner ajax request
    public function delete(Request $request)
    {
        $id = $request->id;
        $owner = Applicant::find($id);
        if (!$owner) {
            return response()->json([
                'status' => 'error',
                'message' => 'Owner not found'
            ], 404);
        }
        if (Storage::delete('public/images/' . $owner->scan_or_photo_of_id)) {
            $owner->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Owner deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete owner'
            ], 500);
        }
    }

    public function show($id)
    {
        $allowners = Applicant::all();
        $drivers = Driver::all();

        // Retrieve the owner details
        $owners = Applicant::findOrFail($id);

        // Retrieve the vehicles associated with the owner
        $vehicles = Vehicle::where('owner_id', $owners->id)->orderBy('created_at', 'desc')->paginate(4);

        // Count the total number of vehicles associated with the owner
        $totalVehicles = Vehicle::where('owner_id', $owners->id)->count();

        // Count the total number of violations associated with the owner
        $totalViolations = Violation::whereIn('vehicle_id', $vehicles->pluck('id'))->count();

        // Calculate the total time in for all vehicles associated with the owner
        $totalTimeIn = Time::whereIn('vehicle_id', $vehicles->pluck('id'))->count();
        $totalTimeOut = Time::whereIn('vehicle_id', $vehicles->pluck('id'))->count();

        // Retrieve the remarks from the vehicle_record table corresponding to the owner's vehicles
        $remarks = Vehicle_Record::whereIn('vehicle_id', $vehicles->pluck('id'))
            ->where('owner_id', $owners->id)
            ->orderBy('created_at', 'desc') // Order by the 'created_at' column in descending order
            ->pluck('remarks');

        // Pass the data to the view
        return view('owners.show', compact('drivers', 'allowners', 'remarks', 'totalTimeOut', 'totalVehicles', 'totalTimeIn', 'owners', 'vehicles', 'totalViolations'));
    }

    public function vehicle_information($id)
    {
        // Find the vehicle by its ID
        $vehicles = Vehicle::find($id);

        // Generate QR code based on the vehicle's code
        $qrCode = QrCode::format('png')
            ->size(50)
            ->errorCorrection('H')
            ->generate($vehicles->vehicle_code);

        // Convert the binary data to base64
        $qrCodeBase64 = base64_encode($qrCode);

        return view('owners.vehicle_information', compact('qrCodeBase64', 'vehicles'));
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
                'owner_id' => $request->owner_id,
                'driver_id' => $request->driver_id,
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

    public function delete_vehicle(Request $request)
    {
        $id = $request->id;
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found'
            ], 404);
        }
    
        // Change registration_status to Inactive
        $vehicle->registration_status = 'Inactive';
        $vehicle->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle registration status changed to Inactive'
        ]);
    }

    // public function fetchAllOwnerVehicle($id)
    // {
    //     // Retrieve the owner details
    //     $owners = Applicant::findOrFail($id);

    //     // Check if the ID is not empty
    //     if (!empty($id)) {
    //         // Retrieve vehicles associated with the specified owner ID (applicant ID)
    //         $vehicles = Vehicle::where('owner_id', $owners->id)->get();

    //         // Initialize the output variable
    //         $output = '';

    //         // Check if any vehicles were found
    //         if ($vehicles->count() > 0) {
    //             // Start building the HTML table
    //             $output .= '<table class="table table-striped align-middle">
    //                 <thead>
    //                     <tr>
    //                         <th class="text-center">No.</th>
    //                         <th class="text-center">Plate Number</th>
    //                         <th class="text-center">Vehicle Make</th>
    //                         <th class="text-center">Date</th>
    //                         <th class="text-center">Action</th>
    //                     </tr>
    //                 </thead>
    //                 <tbody>';

    //             // Loop through each vehicle and add its details to the table
    //             foreach ($vehicles as $index => $vehicle) {
    //                 $output .= '<tr>
    //                     <td class="text-center">' . ($index + 1) . '</td>
    //                     <td class="text-center">' . $vehicle->plate_number . '</td>
    //                     <td class="text-center">' . $vehicle->vehicle_make . '</td>
    //                     <td class="text-center">' . $vehicle->created_at->format('F d, Y \a\t h:i A') . '</td>
    //                 </tr>';
    //             }

    //             // Close the table body and table
    //             $output .= '</tbody></table>';
    //         } else {
    //             // If no vehicles were found, display a message
    //             $output = '<h1 class="text-center text-secondary my-5">No records found for this owner!</h1>';
    //         }
    //     } else {
    //         // If ID is empty, display a message indicating it
    //         $output = '<h1 class="text-center text-secondary my-5">No owner ID provided!</h1>';
    //     }

    //     // Return the generated output
    //     return $output;
    // }
}
