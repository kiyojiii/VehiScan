<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Vehicle;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Appointment;
use App\Models\Applicant;
use App\Models\Driver;
use App\Models\Time;
use App\Models\Violation;
use App\Models\Vehicle_Record;
use App\Models\Statuses;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use DB;

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

        // Check if the user has the "applicant" role
        if ($user->hasRole('Applicant')) {
            return redirect()->route('applicant_users.applicant_home');
        }

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

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user->id)->get();

        // Find the owners associated with the authenticated user
        $applicants = Applicant::where('user_id', $user_id)->get();

        // Extract appointment IDs from the retrieved applicants
        $appointmentIds = $applicants->pluck('appointment_id');

        $appointment = Appointment::where('id', $appointmentIds)->get();


        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        // Pass the owners data to the view
        return view('applicant_users.user_profile', compact('appointment', 'user', 'owners'), [
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    public function user_index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user_id)->get();

        // Query the Vehicles
        $owner_first = $owners->first();
        $owner_id = $owner_first->id;
        $vehicles = Vehicle::where('owner_id', $owner_id)->orderBy('created_at', 'desc')->paginate(4);

        // Check if the owner has at least one active vehicle
        $hasActiveVehicle = Vehicle::where('owner_id', $owner_id)
            ->where(function ($query) {
                $query->where('registration_status', 'Active')
                    ->orWhere('registration_status', 'Pending');
            })
            ->exists();

        // Count the total number of vehicles associated with the owner
        $totalVehicles = Vehicle::where('owner_id', $owner_id)->count();

        $all_vehicles = Vehicle::where('owner_id', $owner_id)->orderBy('created_at', 'desc')->get();

        // Retrieve the vehicle IDs associated with the owner
        $vehicleIds = $all_vehicles->pluck('id');

        // Query violations where the vehicle_id and owner_id match
        $totalViolations = Violation::whereIn('vehicle_id', $vehicleIds)->count();

        $active_vehicle = Vehicle::where('owner_id', $owner_id)
            ->where('registration_status', 'Active')
            ->first();

        // Extract vehicle IDs
        $vehicle_ids = $all_vehicles->pluck('id');

        // Calculate the total time in for all vehicles associated with the owner
        $totalTimeIn = Time::whereIn('vehicle_id', $vehicle_ids)->whereNotNull('time_in')->count();

        // Calculate the total time out for all vehicles associated with the owner
        $totalTimeOut = Time::whereIn('vehicle_id', $vehicle_ids)->whereNotNull('time_out')->count();

        $allRemarks = Vehicle_Record::whereIn('vehicle_id', $vehicle_ids)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get(['remarks', 'created_at']);


        // Fetch all vehicles associated with the owner
        $chart_vehicles = Vehicle::whereIn('id', $vehicle_ids)->get();


        // Define arrays to store the time data
        $dates = [];
        $timeInData = [];
        $timeOutData = [];

        // Loop through each vehicle
        foreach ($chart_vehicles as $vehicle) {
            // Retrieve the times associated with the vehicle
            $times = Time::select(
                DB::raw('DATE_FORMAT(time_in, "%a") as formatted_date'),
                DB::raw('COUNT(time_in) as count_time_in'),
                DB::raw('COUNT(time_out) as count_time_out')
            )
                ->where('vehicle_id', $vehicle->id)
                ->groupBy('formatted_date')
                ->get();

            // Iterate through each time entry and store data
            foreach ($times as $time) {
                $dates[] = $time->formatted_date;
                $timeInData[] = $time->count_time_in;
                $timeOutData[] = $time->count_time_out;
            }
        }

        // Remove duplicate dates
        $dates = array_unique($dates);


        // Pass the owners data to the view
        return view('applicant_users.applicant_home', compact('vehicleIds', 'active_vehicle', 'allRemarks', 'dates', 'timeInData', 'timeOutData', 'hasActiveVehicle', 'totalViolations', 'totalTimeOut', 'totalVehicles', 'totalTimeIn', 'owners', 'vehicles'));
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

    public function fetchAllApplicantViolation()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owner (applicant) associated with the authenticated user
        $owner = Applicant::where('user_id', $user_id)->first();

        // Retrieve the owner's ID
        $owner_id = $owner->id;

        // Query the vehicles owned by the owner
        $vehicles = Vehicle::where('owner_id', $owner_id)->pluck('id');

        // Query the violations associated with the vehicles owned by the owner
        $violation = Violation::whereIn('vehicle_id', $vehicles)->get();
        $output = '';
        $row = 1; // Initialize the row counter
        if ($violation->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Vehicle</th>
                <th class="text-center">Violation</th>
                <th class="text-center">Date</th>
              </tr>
            </thead>
            <tbody>';

            foreach ($violation as $rs) {
                // Find the vehicle associated with the violation
                $vehicle = Vehicle::find($rs->vehicle_id);

                // Get the plate number or set it to 'N/A' if not found
                $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';

                $output .= '<tr>
                    <td class="text-center">' . $row++ . '</td>
                    <td class="text-center">' . $vehiclePlate . '</td>
                    <td class="text-center">' . $rs->violation . '</td>
                    <td class="text-center">' . date('F d, Y \a\t h:i A', strtotime($rs->created_at)) . '</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-success my-5"><i class="bx bx-badge-check"></i> Congratulations, You have no Violations</h1>';
        }
    }

    public function user_violation()
    {
        return view('applicant_users.violation.index');
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
                        <td class="text-center">';
                // Check if approval status is 'Approved'
                if ($owner->approval_status === 'Approved') {
                    // If approval status is 'Approved', disable the edit button
                    $output .= '<span class="text-muted mx-1"><i class="bi-pencil-square h4"></i></span>';
                } else {
                    // If approval status is not 'Approved', enable the edit button
                    $output .= '<a href="#" id="' . $owner->id . '" class="text-success mx-1 editIconOwner" onClick="editOwner()"><i class="bi-pencil-square h4"></i></a>';
                }

                if ($owner->vehicle) {
                    $output .= '<tr>
                        <td class="text-center">Vehicle</td>
                        <td class="text-center">' . $owner->vehicle->plate_number . '</td>
                        <td class="text-center">' . ($owner->vehicle->reason ?? 'N/A') . '</td>
                        <td class="text-center">' . ($owner->vehicle->approval_status ?? 'N/A') . '</td>
                        <td class="text-center">';
                    // Check if approval status is 'Approved'
                    if ($owner->vehicle->approval_status === 'Approved') {
                        // If approval status is 'Approved', disable the edit button
                        $output .= '<span class="text-muted mx-1"><i class="bi-pencil-square h4"></i></span>';
                    } else {
                        // If approval status is not 'Approved', enable the edit button
                        $output .= '<a href="#" id="' . $owner->vehicle->id . '" class="text-success mx-1 editIconVehicle" onClick="editVehicle()"><i class="bi-pencil-square h4"></i></a>';
                    }
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
                        <td class="text-center">';
                    // Check if approval status is 'Approved'
                    if ($owner->vehicle->driver->approval_status  === 'Approved') {
                        // If approval status is 'Approved', disable the edit button
                        $output .= '<span class="text-muted mx-1"><i class="bi-pencil-square h4"></i></span>';
                    } else {
                        // If approval status is not 'Approved', enable the edit button
                        $output .= '<a href="#" id="' . $owner->vehicle->driver->id . '" class="text-success mx-1 editIconDriver" onClick="editDriver()"><i class="bi-pencil-square h4"></i></a>';
                    }
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

        return view('applicant_users.vehicle_information.index', compact('qrCodeBase64', 'vehicles'));
    }

    // insert a new vehicle ajax request
    public function applicant_add_vehicle(Request $request)
    {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'owner_id' => '|string|max:255',
                'driver_id' => '|string|max:255',
                'owner_address' => 'required|string|max:2048',
                'plate_number' => 'required|string|max:255|unique:vehicles,plate_number',
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
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Check if any of the owner's vehicles have a registration status of "Active"
            $hasActiveVehicle = Vehicle::where('owner_id', $request->owner_id)
                ->where('registration_status', 'Active')
                ->exists();

            // If an active vehicle exists, prevent the creation of a new vehicle
            if ($hasActiveVehicle) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Cannot add a new vehicle because the owner already has an active vehicle.'
                ], 400);
            }

            // Get the currently authenticated user's ID
            $user_id = auth()->id();

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

            // Generate QR CODE
            $number = mt_rand(1000000000, 9999999999);

            if ($this->vehicleCodeExists($number)) {
                $number = mt_rand(1000000000, 999999999);
            }

            // Set Approval and Reason Default Value
            $add_approval_status = $request->input('approval_status', 'Pending');
            $add_reason = $request->input('reason', 'For Approval');

            // Create new vehicle data with user_id and unique file names
            $vehicleData = [
                'user_id' => $user_id,
                'owner_id' => $request->owner_id,
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
                'approval_status' => $add_approval_status,
                'reason' => $add_reason,
                'registration_status' => $request->registration_status,
                'vehicle_code' => $number,
            ];

            // Create the vehicle record
            Vehicle::create($vehicleData);

            return response()->json([
                'status' => 200,
                'message' => 'Vehicle created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // APPLICANT VEHICLES
    public function user_vehicles()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user_id)->get();

        // Query the Vehicles
        $owner_first = $owners->first();
        $owner_id = $owner_first->id;

        $vehicles = Vehicle::where('owner_id', $owner_id)->first();

        // Count Vehicles
        $totalVehicles = Vehicle::where('owner_id', $owner_id)->count();
        // Retrieve the active vehicle
        $activeVehicle = Vehicle::where('registration_status', 'Active')
            ->where('owner_id', $owner_id)
            ->first();

        // Check if an active vehicle exists
        if ($activeVehicle) {
            $plateNumber = $activeVehicle->plate_number;
            $vehicleMake = $activeVehicle->vehicle_make;
        } else {
            // If no active vehicle exists, set the values to null or any other default value
            $plateNumber = null;
            $vehicleMake = null;
        }

        return view('applicant_users.vehicles.index', compact('activeVehicle', 'totalVehicles', 'vehicles'));
    }

    // FETCH APPLICANT VEHICLES
    public function fetchAllApplicantVehicle()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user_id)->get();

        // Query the Vehicles
        $owner_first = $owners->first();
        $owner_id = $owner_first->id;

        $vehicles = Vehicle::where('owner_id', $owner_id)->orderBy('created_at', 'desc')->get();
        $output = '';

        if ($vehicles->isNotEmpty()) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Date Applied</th>
                    <th>Plate Number</th>
                    <th>Vehicle Make</th>
                    <th class="text-center">Vehicle Code</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">QR</th>
                </tr>
            </thead>
            <tbody>';

            foreach ($vehicles as $vehicle) {
                $driverName = Driver::find($vehicle->driver_id)->driver_name ?? 'N/A';
                // Variable to keep track of the count
                $count = 1;
                $output .= '<tr>
                <td>' . \Carbon\Carbon::parse($vehicle->created_at)->format('M, d, Y') . '</td>
                <td>' . $vehicle->plate_number . '</td>
                <td>' . $vehicle->vehicle_make . '</td>
                <td class="text-center">' . $vehicle->vehicle_code . ' </td>
                <td>' . $vehicle->registration_status . '</td>
                <td class="text-center">
                    <!-- For example: -->
                    <a href="#" id="' . $vehicle->id . '" class="text-primary mx-1 viewVehicle" onClick="viewVehicle()"><i class="bi bi-eye h4"></i></a>
                    <a href="#" id="' . $vehicle->id . '" class="text-success mx-1 editVehicle" onClick="editVehicle()"><i class="bi-pencil-square h4"></i></a>
                    <a href="#" id="' . $vehicle->id . '" class="text-danger mx-1 deleteVehicle"><i class="bi-trash h4"></i></a>
                    </td>  
                    <td class="text-center">
                    <!-- Button to trigger QR code download -->
                    <button class="btn btn-primary download-btn" data-qrcode="' . $vehicle->vehicle_code . '"><i class="fas fa-download"></i></button>
                </td>
            </tr>';
            }

            $output .= '</tbody></table>';
        } else {
            $output = '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }

        return $output;
    }

    public function applicant_vehicle_edit(Request $request)
    {
        $id = $request->id;
        $vehicle = Vehicle::find($id);
        return response()->json($vehicle);
    }

    public function applicant_vehicle_update(Request $request)
    {
        try {
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
            $approval_status = $request->input('approval_status', 'Pending');
            $reason = $request->input('reason', 'Vehicle Update Request');
            $registration_status = $request->input('registration_status', 'Pending');

            // Update vehicle data
            $vehicle->update([
                'driver_id' => $request->driver_id,
                'owner_address' => $request->owner_address,
                'plate_number' => $request->plate_number,
                'vehicle_make' => $request->vehicle_make,
                'year_model' => $request->year_model,
                'color' => $request->color,
                'body_type' => $request->body_type,
                'approval_status' => $approval_status,
                'reason' => $reason,
                'registration_status' => $registration_status,
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

    public function applicant_vehicle_delete(Request $request)
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

    public function applicant_vehicle_view(Request $request)
    {
        $id = $request->id;
        $vehicle = Vehicle::find($id);
        return response()->json($vehicle);
    }

    # APPLICANT ANALYTICS
    public function applicant_analytics(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user_id)->get();

        // Query the Vehicles
        $owner_first = $owners->first();
        $owner_id = $owner_first->id;
        $vehicles = Vehicle::where('owner_id', $owner_id)->orderBy('created_at', 'desc')->get();

        // Initialize arrays to store the counts
        $timeCounts = [];
        $combinedCounts = [];

        // Loop through each vehicle
        foreach ($vehicles as $vehicle) {
            // Query the time_in and time_out counts per month for the current vehicle
            $timeCounts[$vehicle->id] = Time::selectRaw('MONTH(created_at) as month, COUNT(time_in) as time_in_count, COUNT(time_out) as time_out_count')
                ->where('vehicle_id', $vehicle->id)
                ->groupByRaw('MONTH(created_at)')
                ->get();

            // Combine the counts for each month
            foreach ($timeCounts[$vehicle->id] as $time) {
                $month = \Carbon\Carbon::createFromDate(null, $time->month, 1)->format('F');
                if (!isset($combinedCounts[$month])) {
                    $combinedCounts[$month] = (object)['time_in_count' => 0, 'time_out_count' => 0];
                }
                $combinedCounts[$month]->time_in_count += $time->time_in_count;
                $combinedCounts[$month]->time_out_count += $time->time_out_count;
            }
        }

        // Prepare data for JavaScript chart
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $timeInCounts = array_fill(0, 12, 0);
        $timeOutCounts = array_fill(0, 12, 0);

        foreach ($combinedCounts as $month => $count) {
            $index = array_search($month, $months);
            if ($index !== false) {
                $timeInCounts[$index] += $count->time_in_count;
                $timeOutCounts[$index] += $count->time_out_count;
            }
        }

        $timeInData = implode(', ', $timeInCounts);
        $timeOutData = implode(', ', $timeOutCounts);

        // Initialize array to store time differences
        $timeDifferences = [];

        // Loop through each vehicle
        foreach ($vehicles as $vehicle) {
            // Query the time_in and time_out for the current vehicle
            $times = Time::where('vehicle_id', $vehicle->id)
                ->orderBy('created_at')
                ->get();

            // Initialize variables to track time for each day
            $currentDate = null;
            $totalDifference = 0;

            foreach ($times as $time) {
                // Calculate time difference in hours if both time_in and time_out are available
                if ($time->time_in && $time->time_out) {
                    $timeIn = Carbon::parse($time->time_in);
                    $timeOut = Carbon::parse($time->time_out);
                    $difference = $timeOut->diffInHours($timeIn);

                    // If it's a new day, store the total difference for the previous day (if any)
                    if ($time->created_at->format('Y-m-d') !== $currentDate) {
                        if ($currentDate) {
                            $timeDifferences[] = [
                                'date' => Carbon::parse($currentDate)->format('F d, Y'),
                                'difference' => $totalDifference,
                            ];
                        }
                        // Reset for the new day
                        $currentDate = $time->created_at->format('Y-m-d');
                        $totalDifference = 0;
                    }

                    // Add the difference to the total for the current day
                    $totalDifference += $difference;
                }
            }

            // Store the total difference for the last day (if any)
            if ($currentDate) {
                $timeDifferences[] = [
                    'date' => Carbon::parse($currentDate)->format('F d, Y'),
                    'difference' => $totalDifference,
                ];
            }
        }

        // Sort the time differences by date
        usort($timeDifferences, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        // Limit the time differences to the most recent 7 dates
        $timeDifferences = array_slice($timeDifferences, -7);

        // Extract dates and differences for the chart
        $dates = [];
        $differences = [];
        foreach ($timeDifferences as $entry) {
            $dates[] = $entry['date'];
            $differences[] = $entry['difference'];
        }

        // Initialize an array to store formatted dates
        $formattedDates = [];

        // Loop through each date and format it
        foreach ($dates as $date) {
            // Use Carbon to parse the date and format it as desired
            $formattedDate = \Carbon\Carbon::parse($date)->isoFormat('MMM D');

            // Add the formatted date to the array
            $formattedDates[] = $formattedDate;
        }


        return view('applicant_users.analytics.index', compact('formattedDates', 'dates', 'differences', 'vehicles', 'timeInData', 'timeOutData'));
    }

    public function fetchAllApplicantTime()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owner (applicant) associated with the authenticated user
        $owner = Applicant::where('user_id', $user_id)->first();

        // Retrieve the owner's ID
        $owner_id = $owner->id;

        // Query the vehicles owned by the owner
        $vehicles = Vehicle::where('owner_id', $owner_id)->pluck('id');

        // Query the violations associated with the vehicles owned by the owner
        $times = Time::whereIn('vehicle_id', $vehicles)->get();
        $output = '';
        $row = 1; // Initialize the row counter
        if ($times->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Vehicle</th>
                <th class="text-center">Time In</th>
                <th class="text-center">Time Out</th>
                <th class="text-center">Time Difference</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($times as $time) {
                // Find the vehicle associated with the owner
                $vehicle = Vehicle::find($time->vehicle_id);

                // Get the plate number or set it to 'N/A' if not found
                $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';

                $current_time_out = $time->time_out ? date('F d, Y \a\t h:i A', strtotime($time->time_out)) : 'Not Yet Out';

                // Convert time_in and time_out to Unix timestamps
                $time_out = $time->time_out ? date('F d, Y \a\t h:i A', strtotime($time->time_out)) : 'Not Yet Out';
                $time_in = strtotime($time->time_in);
                $time_out = $time->time_out ? strtotime($time->time_out) : time(); // If time_out is null, use current time

                // Calculate the time difference in seconds
                $time_difference = $time_out - $time_in;

                // Convert time difference to days, hours, and minutes
                $days = floor($time_difference / (60 * 60 * 24));
                $hours = floor(($time_difference % (60 * 60 * 24)) / (60 * 60));
                $minutes = floor(($time_difference % (60 * 60)) / 60);

                $output .= '<tr>
                    <td class="text-center">' . $row++ . '</td> <!-- Increment row counter -->
                    <td class="text-center">' . $time->vehicle_id . '</td>
                    <td class="text-center">' . date('F d, Y \a\t h:i A', strtotime($time->time_in)) . '</td>
                    <td class="text-center">' . $current_time_out . '</td>
                    <td class="text-center">' . $days . ' days, ' . $hours . ' hours, ' . $minutes . ' minutes</td>
                </tr>';
            }
            $output .= '</tbody></table>';
        } else {
            $output .= '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }

        return $output;
    }
}
