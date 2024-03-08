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
use Carbon\Carbon;

class TimeController extends Controller
{
    public function test()
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $owners = Applicant::all();
        $vehicleRecords = Vehicle_Record::latest()->paginate(100);
        return view('time.test', compact('vehicleRecords', 'appointments', 'role_status', 'drivers', 'vehicles', 'owners'));
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

                    // Return success message with status
                    return response()->json(['status' => 'timed_in']);
                }
                // If there's a recent time_in record without time_out, update it to time_out
                else {
                    $recentTimeIn->update(['time_out' => now()]);
                    // Create vehicle record for time out
                    $this->createVehicleRecord($vehicle->id, false);

                    // Return success message with status
                    return response()->json(['status' => 'timed_out']);
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
        $vehicleRecords = Vehicle_Record::latest()->get();

        return response()->json($vehicleRecords);
    }
}
