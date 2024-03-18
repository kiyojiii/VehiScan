<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Applicant;
use App\Models\Driver;
use App\Models\Time;
use App\Models\Statuses;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        // Count Specific Tables
        $totalVehicles = Vehicle::count();
        $totalOwners = Applicant::count();
        $totalUsers = User::count();
        $totalDrivers = Driver::count();
        $totalTimeIn = Time::whereNotNull('time_in')->count();
        $totalTimeOut = Time::whereNotNull('time_out')->count();

        // CHARTS QUERY
        $applicants = Applicant::all();
        // Query all appointments with the count of related applicants
        $appointments = Appointment::withCount('applicants')->get();

        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');

        $totalTimePerDay = Time::selectRaw('DATE(created_at) as date, COUNT(time_in) as total_time_in, COUNT(time_out) as total_time_out')
            ->whereMonth('created_at', '=', $currentMonth)
            ->whereYear('created_at', '=', $currentYear)
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();

        // Get the current month and previous month
        $currentMonth = date('Y-m');
        $previousMonth = date('Y-m', strtotime('-1 month'));

        // Query the total time count of the current month
        $totalTimeCurrentMonth = Time::whereYear('created_at', '=', date('Y'))
            ->whereMonth('created_at', '=', date('m'))
            ->count();

        // Query the total time count of the previous month
        $totalTimePreviousMonth = Time::whereYear('created_at', '=', date('Y', strtotime('-1 month')))
            ->whereMonth('created_at', '=', date('m', strtotime('-1 month')))
            ->count();

        // Get the counts of vehicles, owners, and drivers for the series
        $series = [
            $totalVehicles,
            $totalOwners,
            $totalDrivers,
        ];

        // Pass the user data to the view
        return view('home', compact('series', 'totalTimeCurrentMonth', 'totalTimePreviousMonth', 'totalTimePerDay', 'applicants', 'appointments', 'totalTimeOut', 'totalTimeIn', 'user', 'totalUsers', 'totalOwners', 'totalVehicles', 'totalDrivers'));
    }

    public function user_profile()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user->id)->get();

        // Pass the owners data to the view
        return view('applicant_users.user_profile', compact('user', 'owners'));
    }

    public function user_index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user_id)->get();

        // Pass the owners data to the view
        return view('applicant_users.applicant_home', compact('owners'));
    }

    public function user_apply()
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user_id)->get();

        return view('applicant_users.applicant_apply', compact('drivers', 'vehicles', 'role_status', 'appointments', 'owners'));
    }

    public function fetchAllApplicantDetails()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user_id)->get();
        $output = '';
        if ($owners->count() > 0) {
            $output .= '<table class="table table-nowrap">
                <thead>
                    <tr>
                        <th class="text-center">Application</th>
                        <th class="text-center">Application Name</th>
                        <th class="text-center">Reason (If Rejected)</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Edit</th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($owners as $owner) {
                $output .= '<tr>
                    <td class="text-center">Owner</td>
                    <td class="text-center">' . $owner->first_name . ' ' . $owner->last_name . '</td>
                    <td class="text-center">' . ($owner->reason ?? 'N/A') . '</td>
                    <td class="text-center">' . ($owner->approval_status ?? 'N/A') . '</td>
                    <td class="text-center">
                        <a href="#" id="' . $owner->id . '" class="text-success mx-1 editIconOwner" onClick="editOwner()"><i class="bi-pencil-square h4"></i></a>
                    </td>
                </tr>';

                if ($owner->vehicle) {
                    $output .= '<tr>
                        <td class="text-center">Vehicle</td>
                        <td class="text-center">' . $owner->vehicle->plate_number . '</td>
                        <td class="text-center">' . ($owner->vehicle->reason ?? 'N/A') . '</td>
                        <td class="text-center">' . ($owner->vehicle->approval_status ?? 'N/A') . '</td>
                        <td class="text-center">
                            <a href="#" id="' . $owner->vehicle->id . '" class="text-success mx-1 editIconVehicle" onClick="editVehicle()"><i class="bi-pencil-square h4"></i></a>
                        </td>
                    </tr>';
                } else {
                    $output .= '<tr>
                        <td class="text-center">Vehicle</td>
                        <td class="text-center">N/A</td>
                        <td class="text-center">N/A</td>
                        <td class="text-center">N/A</td>
                        <td class="text-center"></td>
                    </tr>';
                }

                if ($owner->vehicle && $owner->vehicle->driver) {
                    $output .= '<tr>
                        <td class="text-center">Driver</td>
                        <td class="text-center">' . $owner->vehicle->driver->driver_name . '</td>
                        <td class="text-center">' . ($owner->vehicle->driver->reason ?? 'N/A') . '</td>
                        <td class="text-center">' . ($owner->vehicle->driver->approval_status ?? 'N/A') . '</td>
                        <td class="text-center">
                            <a href="#" id="' . $owner->vehicle->driver->id . '" class="text-success mx-1 editIconDriver" onClick="editDriver()"><i class="bi-pencil-square h4"></i></a>
                        </td>
                    </tr>';
                } else {
                    $output .= '<tr>
                        <td class="text-center">Driver</td>
                        <td class="text-center">N/A</td>
                        <td class="text-center">N/A</td>
                        <td class="text-center">N/A</td>
                        <td class="text-center"></td>
                    </tr>';
                }
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
            $approval_status = $request->input('approval_status', 'Pending');
            $reason = $request->input('reason', 'For Verification');

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
                'message' => 'Application Submitted Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

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
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                // Applicant
                'vehicle_id' => 'string|max:255',
                'serial_number' => 'string|max:255',
                'id_number' => 'string|max:255',
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
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

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

            // Set Approval and Reason Default Value
            $approvalStatus = $request->input('approval_status', 'Pending');
            $reason = $request->input('reason', 'For Verification');

            // Update owner data
            $ownerData = [
                'vehicle_id' => $request->vehicle_id,
                'serial_number' => $request->serial_number,
                'id_number' => $request->id_number,
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
                'scan_or_photo_of_id' => $fileName,
            ];

            $owner->update($ownerData);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Owner Updated Successfully.'
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
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'driver_id' => 'string|max:255',
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

            // Set Approval and Reason Default Value
            $approvalStatus = $request->input('approval_status', 'Pending');
            $reason = $request->input('reason', 'For Verification');

            // Update vehicle data
            $vehicle->update([
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
                'message' => 'Vehicle Updated Successfully.'
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
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'dname' => 'required|string|max:255',
                'driver_license_image' => 'image|max:2048', // Assuming it's an image file
                'adname' => 'string|max:255',
                'adaddress' => 'string|max:255',
                'authorized_driver_license_image' => 'image|max:2048', // Assuming it's an image file
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

            // Set Approval and Reason Default Value
            $approvalStatus = $request->input('approval_status', 'Pending');
            $reason = $request->input('reason', 'For Verification');

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
                'message' => 'Driver Updated Successfully.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
