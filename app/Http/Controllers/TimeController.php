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
        return view('time.test', compact('appointments', 'role_status', 'drivers', 'vehicles', 'owners'));
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

    
    public function checkTimeIn(Request $request)
    {
        // Check if there is an existing time in record for the provided vehicle that hasn't timed out
        $existingRecord = Time::where('vehicle_id', $request->vehicle_id)
            ->whereNull('time_out')
            ->exists();

        return response()->json(['allowTimeIn' => !$existingRecord]);
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

    public function search(Request $request)
    {
        if($request->ajax()){
            // Find the vehicle by vehicle code
            $vehicle = Vehicle::where('vehicle_code', $request->search)->first();
    
            // If vehicle found
            if($vehicle){
                // Check if there's a recent time_in record for the vehicle
                $recentTimeIn = Time::where('vehicle_id', $vehicle->id)
                                    ->whereNull('time_out')
                                    ->latest('time_in')
                                    ->first();
    
                // If no recent time_in record, create a new time_in record
                if(!$recentTimeIn){
                    Time::create([
                        'time_in' => now(),
                        'vehicle_id' => $vehicle->id
                    ]);
                    // Return success message with status
                    return response()->json(['status' => 'timed_in']);
                }
                // If there's a recent time_in record without time_out, update it to time_out
                else {
                    $recentTimeIn->update(['time_out' => now()]);
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
        $times = Time::all();
        $output = '';
        if ($times->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Plate Number</th>
                            <th>Vehicle Make</th>
                            <th>Color</th>
                            <th>Vehicle ID</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($times as $time) {
                // Fetch vehicle details based on vehicle ID
                $vehicle = Vehicle::find($time->vehicle_id);
                // Check if vehicle exists
                if ($vehicle) {
                    $output .= '<tr>
                        <td>' . $time->id . '</td>
                        <td>' . $vehicle->plate_number . '</td>
                        <td>' . $vehicle->vehicle_make . '</td>
                        <td>' . $vehicle->color . '</td>
                        <td>' . $time->vehicle_id . '</td>
                        <td>' . $time->time_in . '</td>
                        <td>' . $time->time_out . '</td>
                    </tr>';
                }
            }
            $output .= '</tbody></table>';
        } else {
            $output = '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }
        return $output;
    }

}
