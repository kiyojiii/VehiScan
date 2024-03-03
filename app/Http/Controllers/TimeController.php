<?php

namespace App\Http\Controllers;

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

}
