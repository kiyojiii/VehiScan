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

        // Total vehicles with time_in not null and active registration status
        $totalVehicleIn = Time::join('vehicles', 'times.vehicle_id', '=', 'vehicles.id')
            ->whereNull('time_out')
            ->where('vehicles.registration_status', 'active')
            ->distinct('times.vehicle_id')
            ->count('times.vehicle_id');

        // Total vehicles with time_in not null (either time_out is null or not null) and active registration status
        $totalVehicleOut = Time::join('vehicles', 'times.vehicle_id', '=', 'vehicles.id')
            ->whereNotNull('time_in')
            ->where('vehicles.registration_status', 'active')
            ->where(function ($query) {
                // Subquery to check if vehicle has no new time record with time_in and null time_out
                $query->whereNotExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                        ->from('times as t2')
                        ->whereRaw('t2.vehicle_id = vehicles.id')
                        ->whereNotNull('t2.time_in')
                        ->whereNull('t2.time_out');
                });
            })
            ->distinct('times.vehicle_id')
            ->count('times.vehicle_id');


        $totalActiveVehicles = Vehicle::where('registration_status', 'Active')->count();
        $totalInactiveVehicles = Vehicle::where('registration_status', 'Inactive')->count();
        $totalPendingVehicles = Vehicle::where('registration_status', 'Pending')->count();
        $totalActiveApprovedVehicles = Vehicle::where('registration_status', 'Active')
            ->where('approval_status', 'Approved')
            ->count();

        // Get the date 7 days ago from the current date
        $sevenDaysAgo = Carbon::now()->subDays(7);

        // Query vehicles created in the past 7 days
        $recentVehicles = Vehicle::where('created_at', '>=', $sevenDaysAgo)->where('registration_status', 'Active')->count();

        // Calculate the VehicleInPercentage
        if ($totalActiveVehicles > 0) {
            $vehicleInPercentage = ($totalVehicleIn / $totalActiveVehicles) * 100;
        } else {
            $vehicleInPercentage = 0; // Handle division by zero error
        }

        // Format the percentage to display up to two decimal places
        $VehicleInPercentage = number_format($vehicleInPercentage, 2);

        // Calculate the VehicleOutPercentage
        if ($totalActiveVehicles > 0) {
            $vehicleOutPercentage = ($totalVehicleOut / $totalActiveVehicles) * 100;
        } else {
            $vehicleOutPercentage = 0; // Handle division by zero error
        }

        // Format the percentage to display up to two decimal places
        $VehicleOutPercentage = number_format($vehicleOutPercentage, 2);

        // CHARTS QUERY
        $applicants = Applicant::all();
        // Query all appointments with the count of related applicants
        $appointments = Appointment::withCount('applicants')->get();

        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');

        // Get records from the last 7 days
        $startDate = now()->subDays(7)->startOfDay();
        $endDate = now()->endOfDay();

        $totalTimePerDay = Time::selectRaw('DATE(created_at) as date, COUNT(time_in) as total_time_in, COUNT(time_out) as total_time_out')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->take(7)
            ->get();

        // Get the current month and previous month
        $currentMonth = date('Y-m');
        $previousMonth = date('Y-m', strtotime('-1 month'));

        // Get the current year and month
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Query the time records for the current month and count Time_in and Time_out separately
        $totalTimeInCurrentMonth = Time::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->whereNotNull('time_in')
            ->count();

        $totalTimeOutCurrentMonth = Time::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->whereNotNull('time_out')
            ->count();

        // Calculate the total time for the current month
        $totalTimeCurrentMonth = $totalTimeInCurrentMonth + $totalTimeOutCurrentMonth;

        // Get the current year and month
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Calculate the previous month
        $previousYear = Carbon::now()->subMonth()->year;
        $previousMonth = Carbon::now()->subMonth()->month;

        // Query the time records for the previous month and count Time_in and Time_out separately
        $totalTimeInPreviousMonth = Time::whereYear('created_at', $previousYear)
            ->whereMonth('created_at', $previousMonth)
            ->whereNotNull('time_in')
            ->count();

        $totalTimeOutPreviousMonth = Time::whereYear('created_at', $previousYear)
            ->whereMonth('created_at', $previousMonth)
            ->whereNotNull('time_out')
            ->count();

        // Calculate the total time for the previous month
        $totalTimePreviousMonth = $totalTimeInPreviousMonth + $totalTimeOutPreviousMonth;

        // Get the counts of vehicles, owners, and drivers for the series
        $series = [
            $totalVehicles,
            $totalOwners,
            $totalDrivers,
        ];

        $pendingApplicants = Applicant::where('approval_status', 'Pending')->count();
        $pendingVehicles = Vehicle::where('registration_status', 'Pending')->orWhere('approval_status', 'Pending')->count();
        $pendingDrivers = Driver::where('approval_status', 'Pending')->count();

        $livecurrentMonth = Carbon::now()->format('F');

        // Get the current month
        $currentMonth = Carbon::now()->month;

        // Get the vehicle ID with the most records for the current month
        $vehicleWithMostRecords = Time::select('vehicle_id', DB::raw('COUNT(*) as total'))
            ->whereMonth('time_in', $currentMonth)
            ->orWhereMonth('time_out', $currentMonth)
            ->groupBy('vehicle_id')
            ->orderByDesc('total')
            ->first();

        $plateNumber = null;
        $totalVisits = 0;
        $percentage = 0;

        if ($vehicleWithMostRecords) {
            $vehicle = Vehicle::find($vehicleWithMostRecords->vehicle_id);
            if ($vehicle) {
                $plateNumber = $vehicle->plate_number;
            }
            $totalVisits = $vehicleWithMostRecords->total;

            // Calculate percentage
            // Query the time records for the current month and count Time_in and Time_out separately
            $totalvisittotalTimeInCurrentMonth = Time::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->whereNotNull('time_in')
                ->count() ?? null;

            $totaltotalTimeOutCurrentMonth = Time::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->whereNotNull('time_out')
                ->count() ?? null;

            $totalRecords = $totalvisittotalTimeInCurrentMonth + $totaltotalTimeOutCurrentMonth ?? null;
            $percentage = $totalRecords ? ($totalVisits / $totalRecords) * 100 : null;
        } else {
            // Set variables to null when there's no data
            $plateNumber = null;
            $totalVisits = null;
            $totalRecords = null;
            $percentage = null;
        }


        // Get the total count of time_in for the current month
        $mostTimeInCount = Time::whereMonth('time_in', $currentMonth)->where('vehicle_id', $vehicleWithMostRecords->vehicle_id)->count();

        // Get the total count of time_out for the current month
        $mostTimeOutCount = Time::whereMonth('time_out', $currentMonth)->where('vehicle_id', $vehicleWithMostRecords->vehicle_id)->count();

        // Calculate the total visits by adding time_in and time_out counts
        $mosttotalVisits = $mostTimeInCount + $mostTimeOutCount;


        // Query to find the vehicle with the most violation count
        $mostViolatedVehicle = Violation::select('vehicle_id', DB::raw('COUNT(*) as violation_count'))
            ->groupBy('vehicle_id')
            ->orderByDesc('violation_count')
            ->first();

        $vehiclePlateNumber = null;
        $violationCount = 0;

        if ($mostViolatedVehicle) {
            $vehicle = Vehicle::find($mostViolatedVehicle->vehicle_id);
            if ($vehicle) {
                $vehiclePlateNumber = $vehicle->plate_number;
            }
            $violationCount = $mostViolatedVehicle->violation_count;
        }

        // Query to find the applicant with the most vehicles associated
        $mostVehiclesApplicant = Applicant::select('applicants.id', 'applicants.first_name', 'applicants.last_name', DB::raw('COUNT(vehicles.id) as vehicle_count'))
            ->leftJoin('vehicles', 'applicants.id', '=', 'vehicles.owner_id')
            ->groupBy('applicants.id', 'applicants.first_name', 'applicants.last_name')
            ->orderByDesc('vehicle_count')
            ->first();

        $firstName = null;
        $lastName = null;
        $vehicleCount = 0;

        if ($mostVehiclesApplicant) {
            $firstName = $mostVehiclesApplicant->first_name;
            $lastName = $mostVehiclesApplicant->last_name;
            $vehicleCount = $mostVehiclesApplicant->vehicle_count;
        }

        // Query to find the vehicle with the longest total stay duration
        $recentLongestStayVehicle = Time::select('vehicles.plate_number', DB::raw('SUM(TIMESTAMPDIFF(MINUTE, time_in, time_out)) as total_stay_duration'))
            ->join('vehicles', 'times.vehicle_id', '=', 'vehicles.id')
            ->whereNotNull('time_out') // Ensure time_out is not null
            ->groupBy('vehicles.plate_number') // Group by plate number to aggregate stay durations for each vehicle
            ->orderByDesc('total_stay_duration') // Order by total stay duration in descending order
            ->first();

        $lsplateNumber = null;
        $stayDuration = 0;

        if ($recentLongestStayVehicle) {
            $lsplateNumber = $recentLongestStayVehicle->plate_number;
            $totalMinutes = $recentLongestStayVehicle->total_stay_duration;

            // Calculate hours and minutes
            $stayDurationHours = floor($totalMinutes / 60);
            $stayDurationMinutes = $totalMinutes % 60;

            // Format the duration based on hours and minutes
            if ($stayDurationHours > 0) {
                if ($stayDurationHours === 1) {
                    $stayDuration = $stayDurationHours . " hr";
                } else {
                    $stayDuration = $stayDurationHours . " hrs";
                }
            } else {
                if ($stayDurationMinutes === 1) {
                    $stayDuration = $stayDurationMinutes . " min"; // Display "min" if 1 minute
                } else {
                    $stayDuration = $stayDurationMinutes . " mins"; // Display "mins" if more than 1 minute
                }
            }
        }

        // Fetch the latest 10 records from the vehicle_record table
        $vehicleRecords = Vehicle_Record::latest()->take(10)->get();
        $latestVehicles = Vehicle::latest()->take(10)->get();

        // Query to find the hour with the most counts of time_in and time_out for the current month
        $hourWithMostCounts = Time::select(
            DB::raw('HOUR(time_in) as hour'),
            DB::raw('COUNT(time_in) as time_in_count')
        )
            ->whereMonth('time_in', $currentMonth)
            ->groupBy('hour')
            ->orderByDesc('time_in_count')
            ->first();

        if (!$hourWithMostCounts) {
            // If there's no data for time_in in the current month, try time_out
            $hourWithMostCounts = Time::select(
                DB::raw('HOUR(time_out) as hour'),
                DB::raw('COUNT(time_out) as time_out_count')
            )
                ->whereMonth('time_out', $currentMonth)
                ->groupBy('hour')
                ->orderByDesc('time_out_count')
                ->first();
        }

        $hour = null;
        $count = 0;

        if ($hourWithMostCounts) {
            $hour = Carbon::createFromFormat('H', $hourWithMostCounts->hour)->format('g A');
            $count = isset($hourWithMostCounts->time_in_count) ? $hourWithMostCounts->time_in_count : $hourWithMostCounts->time_out_count;
        }

        // Pass the user data to the view
        return view('home', compact('mostTimeInCount', 'mostTimeOutCount', 'mosttotalVisits', 'totalActiveApprovedVehicles', 'VehicleInPercentage', 'VehicleOutPercentage', 'recentVehicles', 'totalPendingVehicles', 'totalInactiveVehicles', 'totalActiveVehicles', 'stayDurationHours', 'recentLongestStayVehicle', 'hour', 'count', 'totalRecords', 'latestVehicles', 'vehicleRecords', 'lsplateNumber', 'stayDuration', 'vehicleCount', 'lastName', 'firstName', 'vehiclePlateNumber', 'violationCount', 'percentage', 'totalVisits', 'plateNumber', 'livecurrentMonth', 'pendingDrivers', 'pendingVehicles', 'pendingApplicants', 'series', 'totalTimeCurrentMonth', 'totalTimePreviousMonth', 'totalTimePerDay', 'applicants', 'appointments', 'totalVehicleIn', 'totalVehicleOut', 'user', 'totalUsers', 'totalOwners', 'totalVehicles', 'totalDrivers'));
    }

    public function fetchHomeVehicleRecord()
    {
        $vehicleRecords = Vehicle_Record::latest()->take(10)->get();

        return response()->json($vehicleRecords);
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

        $appointment = Appointment::whereIn('id', $appointmentIds)->get();

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
        $driver = Driver::where('user_id', $user_id)->first();

        // Query the Vehicles
        $owner_first = $owners->first();
        $owner_id = $owner_first->id ?? 'N/A';
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


        $active_vehicle = Vehicle::where('owner_id', $owner_id)
            ->where('registration_status', 'Active')
            ->get();

        $current_active_vehicle = null; // Initialize the variable outside the if statement

        $active_vehicle = Vehicle::where('owner_id', $owner_id)
            ->where('registration_status', 'Active')
            ->first(); // Use first() to retrieve only the first matching record

        if ($active_vehicle) {
            $current_active_vehicle = $active_vehicle->id;
            // Now $current_active_vehicle contains the ID of the active vehicle
        } else {
            // Handle the case where no active vehicle is found
        }

        // Fetch all vehicles associated with the owner
        $chart_vehicles = Vehicle::where('id', $current_active_vehicle)->get();

        // Define arrays to store the time data
        $dates = [];
        $timeInData = [];
        $timeOutData = [];

        // Loop through each vehicle
        foreach ($chart_vehicles as $vehicle) {
            // Retrieve the times associated with the vehicle for the last 7 days
            $times = Time::select(
                DB::raw('DATE_FORMAT(time_in, "%a, %b %e") as formatted_date'),
                DB::raw('COUNT(time_in) as count_time_in'),
                DB::raw('COUNT(time_out) as count_time_out')
            )
                ->where('vehicle_id', $vehicle->id)
                ->whereDate('time_in', '>=', now()->subDays(7)->startOfDay())
                ->orderBy('created_at')
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

        $role_status = Statuses::all();
        $appointments = Appointment::all();

        // Check if there are any active vehicles
        $activeVehicles = Vehicle::where('owner_id', $owner_id)
            ->where('registration_status', 'Active')
            ->exists();

        $pendingVehicles = Vehicle::where('owner_id', $owner_id)
            ->where('registration_status', 'Pending')
            ->exists();

        // Define $no_active_vehicles based on the value of $activeVehicles
        $no_active_vehicles = !$activeVehicles;
        $has_pending_vehicle = $pendingVehicles;

        // Pass the owners data to the view
        return view('applicant_users.applicant_home', compact('has_pending_vehicle', 'no_active_vehicles', 'driver', 'appointments', 'role_status', 'vehicleIds', 'active_vehicle', 'allRemarks', 'dates', 'timeInData', 'timeOutData', 'hasActiveVehicle', 'totalViolations', 'totalTimeOut', 'totalVehicles', 'totalTimeIn', 'owners', 'vehicles'));
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

    public function user_violation()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user_id)->get();

        return view('applicant_users.violation.index', compact('owners'));
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

    public function fetchAllApplicantDetails()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user_id)->get();

        // Find the owner ID
        $owner_id = $owners->pluck('id')->first();

        // Find the vehicle associated with the owner in descending order
        $vehicle = Vehicle::where('owner_id', $owner_id)->latest()->first();

        // Find the driver associated with the user
        $driver = Driver::where('user_id', $user_id)->latest()->first();

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
                $output .= '</td>
                </tr>';
            }

            if ($vehicle) {
                $output .= '<tr>
                    <td class="text-center">Vehicle</td>
                    <td class="text-center">' . $vehicle->plate_number . '</td>
                    <td class="text-center">' . ($vehicle->reason ?? 'N/A') . '</td>
                    <td class="text-center">' . ($vehicle->approval_status ?? 'N/A') . '</td>
                    <td class="text-center">';
                // Check if approval status is 'Approved'
                if ($vehicle->approval_status === 'Approved') {
                    // If approval status is 'Approved', disable the edit button
                    $output .= '<span class="text-muted mx-1"><i class="bi-pencil-square h4"></i></span>';
                } else {
                    // If approval status is not 'Approved', enable the edit button
                    $output .= '<a href="#" id="' . $vehicle->id . '" class="text-success mx-1 editIconVehicle" onClick="editVehicle()"><i class="bi-pencil-square h4"></i></a>';
                }
                $output .= '</td>
                </tr>';
            }

            if ($driver) {
                $output .= '<tr>
                    <td class="text-center">Driver</td>
                    <td class="text-center">' . $driver->driver_name . '</td>
                    <td class="text-center">' . ($driver->reason ?? 'N/A') . '</td>
                    <td class="text-center">' . ($driver->approval_status ?? 'N/A') . '</td>
                    <td class="text-center">';
                // Check if approval status is 'Approved'
                if ($driver->approval_status  === 'Approved') {
                    // If approval status is 'Approved', disable the edit button
                    $output .= '<span class="text-muted mx-1"><i class="bi-pencil-square h4"></i></span>';
                } else {
                    // If approval status is not 'Approved', enable the edit button
                    $output .= '<a href="#" id="' . $driver->id . '" class="text-success mx-1 editIconDriver" onClick="editDriver()"><i class="bi-pencil-square h4"></i></a>';
                }
                $output .= '</td>
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
                'serial_number' => 'required|string|unique:applicants,serial_number,' . $request->owner_id,
                'id_number' => 'required|string|unique:applicants,id_number,' . $request->owner_id,
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
                // Vehicle Details
                'owner_name' => 'required|string|unique:vehicles,owner_name,' . $request->vehicle_id,
                'owner_address' => 'required|string|max:2048',
                'plate_number' => 'required|string|max:255|unique:vehicles,plate_number,' .  $request->vehicle_id, // Use ignore rule to exclude the current record
                'vehicle_make' => 'required|string|max:255',
                'vehicle_category' => 'required|string|max:255',
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
                'adname' => 'nullable|string|max:255',
                'adaddress' => 'nullable|string|max:255',
                'authorized_driver_license_image' => 'nullable|image|max:2048',
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
            // Generate unique filenames using UUID
            $dlfileName = $request->hasFile('driver_license_image') ? Str::uuid() . '.' . $request->file('driver_license_image')->getClientOriginalExtension() : null;
            $adlfileName = $request->hasFile('authorized_driver_license_image') ? Str::uuid() . '.' . $request->file('authorized_driver_license_image')->getClientOriginalExtension() : null;

            // Store driver license image if exists
            if ($dlfileName) {
                $request->file('driver_license_image')->storeAs('public/images/drivers', $dlfileName);
            }

            // Store authorized driver license image if exists
            if ($adlfileName) {
                $request->file('authorized_driver_license_image')->storeAs('public/images/drivers', $adlfileName);
            }

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
                'owner_name' => $request->owner_name,
                'owner_address' => $request->owner_address,
                'plate_number' => $request->plate_number,
                'vehicle_make' => $request->vehicle_make,
                'vehicle_category' => $request->vehicle_category,
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
                'authorized_driver_license_image' => $adlfileName ?: 'N/A',
                'authorized_driver_name' => $request->adname ?: 'N/A',
                'authorized_driver_address' => $request->adaddress ?: 'N/A',
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

            // After creating the vehicle record
            $qrCodeFileName = 'qr_' . $vehicle->vehicle_code . '.png'; // Generate a unique filename for the QR code image
            $qrCodeFilePath = 'public/images/qrcodes/' . $qrCodeFileName; // Define the file path where the QR code image will be saved

            // Generate QR code based on the vehicle's code
            $qrCode = QrCode::format('png')
                ->size(300) // Adjust the size as needed
                ->errorCorrection('H')
                ->generate($vehicle->vehicle_code);

            // Save the QR code image to the file path
            Storage::put($qrCodeFilePath, $qrCode);

            // Update the vehicle record with the QR code image path and name
            $vehicle->update([
                'qr_image' => $qrCodeFileName,
            ]);

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
                'serial_number' => 'string|unique:applicants,serial_number,' . $request->applicant_id,
                'id_number' => 'string|unique:applicants,id_number,' . $request->applicant_id,
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
                'owner_name' => 'string|max:2048',
                'owner_address' => 'string|max:2048',
                'plate_number' => 'string|max:255|unique:vehicles,plate_number,' .  $request->vehicle_id, // Use ignore rule to exclude the current record
                'vehicle_make' => 'string|max:255',
                'vehicle_category' => 'string|max:255',
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
                'owner_name' => $request->owner_name,
                'owner_address' => $request->owner_address,
                'plate_number' => $request->plate_number,
                'vehicle_make' => $request->vehicle_make,
                'vehicle_category' => $request->vehicle_category,
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
                'real_owner_name' => '|string|max:255',
                'owner_address' => 'required|string|max:2048',
                'plate_number' => 'required|string|max:255|unique:vehicles,plate_number',
                'vehicle_make' => 'required|string|max:255',
                'vehicle_category' => 'required|string|max:255',
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
                'owner_name' => $request->real_owner_name,
                'owner_address' => $request->owner_address,
                'plate_number' => $request->plate_number,
                'vehicle_make' => $request->vehicle_make,
                'vehicle_category' => $request->vehicle_category,
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
            $vehicle = Vehicle::create($vehicleData);

            // After creating the vehicle record
            $qrCodeFileName = 'qr_' . $vehicle->vehicle_code . '.png'; // Generate a unique filename for the QR code image
            $qrCodeFilePath = 'public/images/qrcodes/' . $qrCodeFileName; // Define the file path where the QR code image will be saved

            // Generate QR code based on the vehicle's code
            $qrCode = QrCode::format('png')
                ->size(300) // Adjust the size as needed
                ->errorCorrection('H')
                ->generate($vehicle->vehicle_code);

            // Save the QR code image to the file path
            Storage::put($qrCodeFilePath, $qrCode);

            // Update the vehicle record with the QR code image path and name
            $vehicle->update([
                'qr_image' => $qrCodeFileName,
            ]);

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
        $owner_id = $owner_first->id ?? 'N/A';

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

        return view('applicant_users.vehicles.index', compact('owners', 'activeVehicle', 'totalVehicles', 'vehicles'));
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
                $output .= '<tr>
                    <td>' . \Carbon\Carbon::parse($vehicle->created_at)->format('M, d, Y') . '</td>
                    <td>' . $vehicle->plate_number . '</td>
                    <td>' . $vehicle->vehicle_make . '</td>
                    <td class="text-center">' . $vehicle->vehicle_code . ' </td>
                    <td>' . $vehicle->registration_status . '</td>
                    <td class="text-center">
                        <!-- View button -->
                        <a href="#" id="' . $vehicle->id . '" class="text-primary mx-1 viewVehicle" onClick="viewVehicle()"><i class="bi bi-eye h4"></i></a>';

                $output .= '<a href="#" id="' . $vehicle->id . '" class="text-success mx-1 editVehicle" onClick="editVehicle()"><i class="bi-pencil-square h4"></i></a>';

                // Check registration status to determine if delete button should be displayed
                if ($vehicle->registration_status == 'Active') {
                    $output .= '<a href="#" id="' . $vehicle->id . '" class="text-danger mx-1 deleteVehicle"><i class="bi-trash h4"></i></a>';
                }
                $output .= '</td>';

                $output .= '<td class="text-center">';
                // Check registration status to determine if download button should be enabled
                if ($vehicle->registration_status == 'Active') {
                    $output .= '<button class="btn btn-primary download-btn" data-qrcode="' . $vehicle->vehicle_code . '"><i class="fas fa-download"></i></button>';
                } else {
                    $output .= '<button class="btn btn-primary download-btn disabled" data-qrcode="' . $vehicle->vehicle_code . '"><i class="fas fa-download"></i></button>';
                }
                $output .= '</td></tr>';
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
                'owner_name' => 'string|max:255',
                'owner_address' => 'string|max:255',
                'plate_number' => 'string|max:255',
                'vehicle_make' => 'string|max:255',
                'vehicle_category' => 'string|max:255',
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

            // Update vehicle data
            $vehicle->update([
                'driver_id' => $request->driver_id,
                'owner_name' => $request->owner_name,
                'owner_address' => $request->owner_address,
                'plate_number' => $request->plate_number,
                'vehicle_make' => $request->vehicle_make,
                'vehicle_category' => $request->vehicle_category,
                'year_model' => $request->year_model,
                'color' => $request->color,
                'body_type' => $request->body_type,
                'approval' => $request->approval_status,
                'reason' => $request->reason,
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
        $vehicle->approval_status = 'Approved';
        $vehicle->reason = 'Deactivated';
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
        $owner_id = $owner_first->id ?? 'N/A';
        $all_vehicles = Vehicle::where('owner_id', $owner_id)->orderBy('created_at', 'desc')->get();

        // Query vehicles belonging to the owner and having an active registration
        $vehicles = Vehicle::where('owner_id', $owner_id)
            ->where('registration_status', 'Active')
            ->orderBy('created_at', 'desc')
            ->get();

        // DAY CHART
        // Array to store time data for each vehicle
        $timeData = [];

        // Iterate through each vehicle
        foreach ($vehicles as $vehicle) {
            // Retrieve the vehicle ID
            $vehicleId = $vehicle->id;

            // Query time data for the current vehicle
            $timeEntries = Time::where('vehicle_id', $vehicleId)
                ->orderBy('time_in', 'asc') // Assuming you want to order by time_in
                ->get(['time_in', 'time_out']); // Retrieve only time_in and time_out fields

            // Format dates and extract hours
            $formattedTimeEntries = [];
            foreach ($timeEntries as $entry) {
                // Format date in "April 15, 2024" format
                $formattedDate = date('F d, Y', strtotime($entry->time_in));

                // Extract hour from time_in data and convert to 24-hour format
                $hour = date('H', strtotime($entry->time_in));

                // Add formatted date and hour to the array
                $formattedTimeEntries[] = ['date' => $formattedDate, 'hour' => $hour];
            }

            // Add time data to the array
            $timeData[$vehicleId] = $formattedTimeEntries;
        }


        // MONTHLY CHART
        // Retrieve all vehicles associated with the owner_id
        $all_vehicles = Vehicle::where('owner_id', $owner_id)->orderBy('created_at', 'desc')->get();

        // Initialize arrays to store monthly data
        $time_in_data = [];
        $time_out_data = [];
        $categories = [];

        // Iterate over each month
        for ($month = 1; $month <= 12; $month++) {
            // Get the month name
            $month_name = date('M', mktime(0, 0, 0, $month, 1));

            // Push the month name to the categories array
            $categories[] = $month_name;

            // Initialize variables to store counts for the current month
            $monthly_time_in_count = 0;
            $monthly_time_out_count = 0;

            // Iterate over each vehicle
            foreach ($all_vehicles as $vehicle) {
                // Retrieve the vehicle ID
                $vehicle_id = $vehicle->id;

                // Query the time_in and time_out counts for the current month and current vehicle
                $monthly_time_in_count += Time::where('vehicle_id', $vehicle_id)
                    ->whereMonth('time_in', $month)
                    ->count();
                $monthly_time_out_count += Time::where('vehicle_id', $vehicle_id)
                    ->whereMonth('time_out', $month)
                    ->count();
            }

            // Push the monthly counts to the respective arrays
            $time_in_data[] = $monthly_time_in_count;
            $time_out_data[] = $monthly_time_out_count;
        }

        return view('applicant_users.analytics.index', compact('categories', 'time_in_data', 'time_out_data', 'timeData', 'owners', 'vehicles'));
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
                    <td class="text-center">' . $vehiclePlate . '</td>
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

    public function applicant_edit_owner(Request $request)
    {
        $id = $request->id;
        $owner = Applicant::find($id);
        return response()->json($owner);
    }

    public function applicant_update_owner(Request $request)
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

            // Set Approval and Reason Default Value
            $approval_status = $request->input('approval_status', 'Approved');
            $reason = $request->input('reason', 'None / Approved');

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
                'approval_status' => $approval_status,
                'reason' => $reason,
                'serial_number' => $request->serial_number,
                'id_number' => $request->id_number,
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
    public function applicant_edit_driver(Request $request)
    {
        $id = $request->id;
        $driver = Driver::find($id);
        return response()->json($driver);
    }

    public function applicant_update_driver(Request $request)
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
            $approval_status = $request->input('approval_status', 'Approved');
            $reason = $request->input('reason', 'Driver Has Been Updated');

            // Update driver data
            $driverData = [
                'driver_name' => $request->dname,
                'authorized_driver_name' => $request->adname,
                'authorized_driver_address' => $request->adaddress,
                'approval_status' => $approval_status,
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

    #APPLICANT HISTORY
    public function user_history()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user->id)->get();

        return view('applicant_users.history.index', compact('owners'));
    }

    public function fetchApplicantAudit()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Query all three tables together
        $records = DB::table('applicants_record')
            ->select('pk', 'first_name', 'last_name', 'action', 'updated_at', DB::raw("'applicants_record' as `table`"))
            ->where('user_id', $user_id)
            ->orderBy('updated_at', 'desc') // Changed to descending order
            ->unionAll(
                DB::table('vehicles_record')
                    ->select('pk', 'plate_number', 'vehicle_make', 'action', 'updated_at', DB::raw("'vehicles_record' as `table`"))
                    ->where('user_id', $user_id)
                    ->orderBy('updated_at', 'desc') // Changed to descending order
            )
            ->unionAll(
                DB::table('drivers_record')
                    ->select('pk', 'driver_name', 'authorized_driver_name', 'action', 'updated_at', DB::raw("'drivers_record' as `table`"))
                    ->where('user_id', $user_id)
                    ->orderBy('updated_at', 'desc') // Changed to descending order
            )
            ->orderBy('updated_at', 'desc') // Order the unioned results by updated_at column in descending order
            ->get();

        $output = '';

        if ($records->isNotEmpty()) {
            $output .= '<table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Action</th>
                                <th class="text-center">Updated At</th>
                            </tr>
                        </thead>
                        <tbody>';
            $counter = count($records); // Initialize counter with total number of records
            foreach ($records as $record) {
                $type = '';
                switch ($record->table) {
                    case 'applicants_record':
                        $type = 'Applicant';
                        break;
                    case 'vehicles_record':
                        $type = 'Vehicle';
                        break;
                    case 'drivers_record':
                        $type = 'Driver';
                        break;
                }

                $output .= '<tr>
                                <td class="text-center">' . $counter-- . '</td>
                                <td class="text-center">' . $type . '</td>
                                <td class="text-center">' . $record->action . '</td>
                                <td class="text-center">' . \Carbon\Carbon::parse($record->updated_at)->format('M d, Y \a\t h:i A') . '</td>
                            </tr>';
            }
            $output .= '</tbody></table>';
        } else {
            $output = '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }

        return $output; // Return HTML response        
    }


    public function applicant_vehicle_activate(Request $request)
    {
        $id = $request->id;
        $vehicle = Vehicle::find($id);
        return response()->json($vehicle);
    }

    // UPDATE VEHICLE
    public function applicant_vehicle_activate_update(Request $request)
    {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'driver_id' => 'string|max:255',
                'owner_name' => 'string|max:255',
                'owner_address' => 'string|max:255',
                'plate_number' => 'string|max:255',
                'vehicle_make' => 'string|max:255',
                'vehicle_category' => 'string|max:255',
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
            $approvalStatus = $request->input('approval_status', 'Approved');
            $reason = $request->input('reason', 'Vehicle Activation');
            $registration_status = $request->input('registration_status', 'Pending');

            // Update vehicle data
            $vehicle->update([
                'driver_id' => $request->driver_id,
                'owner_name' => $request->owner_name,
                'owner_address' => $request->owner_address,
                'plate_number' => $request->plate_number,
                'vehicle_make' => $request->vehicle_make,
                'vehicle_category' => $request->vehicle_category,
                'year_model' => $request->year_model,
                'color' => $request->color,
                'body_type' => $request->body_type,
                'approval_status' => $approvalStatus,
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
}
