<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;
use App\Models\Appointment;
use App\Models\Statuses;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle_Record;
use App\Models\Time;
use App\Charts\AppointmentChart;
use Carbon\Carbon;
use DB;

class TestController extends Controller
{
    public function index()
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
                // Check if both time_in and time_out are available
                if ($time->time_in && $time->time_out) {
                    // Calculate time difference in hours
                    $timeIn = Carbon::parse($time->time_in);
                    $timeOut = Carbon::parse($time->time_out);
                    $difference = $timeOut->diffInHours($timeIn);
                } elseif ($time->time_in && !$time->time_out) {
                    // If there is time_in but no time_out, mark it as "Not Yet Timed Out"
                    $difference = 'Not Yet Timed Out';
                } else {
                    // If both time_in and time_out are not available, continue to the next iteration
                    continue;
                }
    
                // If it's a new day, store the total difference for the previous day (if any)
                if ($time->created_at->format('Y-m-d') !== $currentDate) {
                    if ($currentDate) {
                        $timeDifferences[] = [
                            'date' => Carbon::parse($currentDate)->format('M d, Y'),
                            'difference' => $totalDifference . ' hours',
                        ];
                    }
                    // Reset for the new day
                    $currentDate = $time->created_at->format('Y-m-d');
                    $totalDifference = 0;
                }
    
                // Add the difference to the total for the current day
                if (is_numeric($difference)) {
                    $totalDifference += $difference;
                }
            }
    
            // Store the total difference for the last day (if any)
            if ($currentDate) {
                $timeDifferences[] = [
                    'date' => Carbon::parse($currentDate)->format('M d, Y'),
                    'difference' => $totalDifference . ' hours',
                ];
            }
        }
    
        // Order the time differences by date
        usort($timeDifferences, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
    
        return view('test', compact('timeDifferences'));
    }
    
}
