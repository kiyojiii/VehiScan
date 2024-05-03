<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Appointment;
use App\Models\Statuses;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Time;
use App\Models\Vehicle_Record;
use DateTime;
use Carbon\Carbon;

class TimeController extends Controller
{
    public function index()
    {
        $totaltime = Time::count();
        return view('time.index', compact('totaltime'));
    }

    public function fetchAllTime()
    {
        $times = Time::all();
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
                    <td>' . $vehiclePlate . '</td>
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

    public function record_vehicle()
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $owners = Applicant::all();
        $vehicleRecords = Vehicle_Record::latest()->paginate(100);
        return view('time.record_vehicles', compact('vehicleRecords', 'appointments', 'role_status', 'drivers', 'vehicles', 'owners'));
    }

    public function recordTimeIn(Request $request)
    {
        // Validate the request data, if needed
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id'
        ]);

        // Create a new Time record
        Time::create([
            'time_in' => now(), // current datetime
            'vehicle_id' => $request->vehicle_id
        ]);

        return response()->json(['message' => 'Time in recorded successfully']);
    }

    public function recordTimeOut(Request $request)
    {
        // Find the most recent time in record with a null time_out for the provided vehicle
        $timeInRecord = Time::where('vehicle_id', $request->vehicle_id)
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            ->orderByDesc('created_at')
            ->first();

        if ($timeInRecord) {
            // Update the time_out for the found record
            $timeInRecord->update([
                'time_out' => now()
            ]);

            return response()->json(['message' => 'Time out recorded successfully']);
        }

        return response()->json(['error' => 'No active time in record found for the provided vehicle'], 404);
    }

    private function createVehicleRecord($vehicleId, $isTimedIn)
    {
        // Retrieve the vehicle
        $vehicle = Vehicle::find($vehicleId);

        // Check if the vehicle exists
        if ($vehicle) {
            // Determine the current date and time
            $currentTime = Carbon::now()->format('F j, Y \a\t h:i A');

            // Determine the remarks based on whether the vehicle is timed in or timed out
            $remarks = $isTimedIn ? "{$vehicle->plate_number} Timed In at $currentTime" : "{$vehicle->plate_number} Timed Out at $currentTime";

            // Create a new Vehicle Record
            Vehicle_Record::create([
                'user_id' => auth()->id(), // Assuming you have user authentication
                'vehicle_id' => $vehicleId,
                'remarks' => $remarks
            ]);

            return true; // Indicate successful creation of the vehicle record
        } else {
            return false; // Indicate vehicle not found
        }
    }

    public function checkTimeIn(Request $request)
    {
        // Check if there is an existing time in record for the provided vehicle that hasn't timed out
        $existingRecord = Time::where('vehicle_id', $request->vehicle_id)
            ->whereNull('time_out')
            ->exists();

        return response()->json(['allowTimeIn' => !$existingRecord]);
    }

    public function record(Request $request)
    {
        if ($request->ajax()) {
            // Find the vehicle by vehicle code
            $vehicle = Vehicle::where('vehicle_code', $request->record)->first();
    
            // If vehicle found
            if ($vehicle) {
                // Check if approval_status is 'Inactive'
                if ($vehicle->approval_status === 'Inactive') {
                    // Approval status is Inactive, return specific error
                    return response()->json(['error' => 'Vehicle Approval is Inactive'], 400);
                }
    
                // Check if registration_status is 'Inactive'
                if ($vehicle->registration_status === 'Inactive') {
                    // Registration status is Inactive, return specific error
                    return response()->json(['error' => 'Vehicle Registration is Inactive'], 400);
                }
    
                // Check if both approval_status and registration_status are 'Pending'
                if ($vehicle->approval_status === 'Pending') {
                    // Both statuses are Pending, return specific error
                    return response()->json(['error' => 'Vehicle Approval is Still Pending'], 400);
                }
    
                // Check if both approval_status and registration_status are 'Pending'
                if ($vehicle->registration_status === 'Pending') {
                    // Both statuses are Pending, return specific error
                    return response()->json(['error' => 'Vehicle Registration is Still Pending'], 400);
                }
    
                // Check if there's a recent time_in record for the vehicle
                $recentTimeIn = Time::where('vehicle_id', $vehicle->id)
                    ->whereNull('time_out')
                    ->latest('time_in')
                    ->first();
    
                // If no recent time_in record, create a new time_in record
                if (!$recentTimeIn) {
                    Time::create([
                        'time_in' => now(),
                        'vehicle_id' => $vehicle->id
                    ]);
                    // Create vehicle record for time in
                    $this->createVehicleRecord($vehicle->id, true);
    
                    // Return success message with status and plate number
                    return response()->json([
                        'status' => 'timed_in',
                        'plate_number' => $vehicle->plate_number
                    ]);
                }
                // If there's a recent time_in record without time_out, update it to time_out
                else {
                    $recentTimeIn->update(['time_out' => now()]);
                    // Create vehicle record for time out
                    $this->createVehicleRecord($vehicle->id, false);
    
                    // Return success message with status and plate number
                    return response()->json([
                        'status' => 'timed_out',
                        'plate_number' => $vehicle->plate_number
                    ]);
                }
            }
            // If vehicle not found
            else {
                return response()->json(['error' => 'Vehicle not found'], 404);
            }
        }
    }


    // Fetch Vehicle Record Data
    public function fetchVehicleRecord()
    {
        $vehicleRecords = Vehicle_Record::latest()->take(15)->get();

        return response()->json($vehicleRecords);
    }

    // ACTIVITY FEED INDEX
    public function index_activity_feed()
    {
        $totalactivityfeed = Vehicle_Record::count();
        return view('time.activity_feed.index', compact('totalactivityfeed'));
    }

    // Fetch Activity Feed
    public function fetchActivityFeed()
    {
        $records = Vehicle_Record::all();
        $output = '';
        $row = 1; // Initialize the row counter
        if ($records->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Vehicle</th>
                <th class="text-center">Activity</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($records as $record) {
    
                // Find the vehicle associated with the owner
                $vehicle = Vehicle::find($record->vehicle_id);

                // Get the plate number or set it to 'N/A' if not found
                $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';
       
                $output .= '<tr>
                    <td class="text-center">' . $row++ . '</td> <!-- Increment row counter -->
                    <td class="text-center">' . $vehiclePlate . '</td>
                    <td class="text-center">' . $record->remarks . '</td>
                </tr>';

            }
            $output .= '</tbody></table>';
        } else {
            $output .= '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }

        return $output;
    }

    public function whosevehicle()
    {
        return view('findwhosevehicle');
    }
    public function getVehicleData(Request $request)
    {
        $vehicleCode = $request->input('vehicle_code');
    
        // Query the vehicle based on the provided code
        $vehicle = Vehicle::where('vehicle_code', $vehicleCode)->first();
        $applicantID = $vehicle->owner_id;
        $applicant = Applicant::find($applicantID);
    
        if ($vehicle && $applicant) {
            // Vehicle and applicant found, return their data
            return response()->json(['success' => true, 'vehicle' => $vehicle, 'applicant' => $applicant]);
        } else {
            // Vehicle or applicant not found
            return response()->json(['success' => false, 'message' => 'Vehicle or applicant not found'], 404);
        }
    }
}
