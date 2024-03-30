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
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Charts\AppointmentChart;
use Carbon\Carbon;
use DB;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
    
        // Query to get the count of time_in and time_out per hour for the specified date
        $timeData = Time::select(
            DB::raw('HOUR(time_in) as hour'),
            DB::raw('COUNT(time_in) as time_in_count'),
            DB::raw('NULL as time_out_count') // Placeholder for time_out count
        )
        ->whereDate('time_in', $date)
        ->groupBy('hour')
        ->union(
            Time::select(
                DB::raw('HOUR(time_out) as hour'),
                DB::raw('NULL as time_in_count'), // Placeholder for time_in count
                DB::raw('COUNT(time_out) as time_out_count')
            )
            ->whereDate('time_out', $date)
            ->groupBy('hour')
        )
        ->orderBy('hour') // Order by hour
        ->get();
    
        // Prepare the data for display
        $processedData = [];
        foreach ($timeData as $record) {
            $hour = $record->hour;
            $timeInCount = $record->time_in_count ?: 0; // Set time_in count to 0 if NULL
            $timeOutCount = $record->time_out_count ?: 0; // Set time_out count to 0 if NULL
    
            // Store the counts for each hour
            if (!isset($processedData[$hour])) {
                $processedData[$hour] = [
                    'time_in_count' => $timeInCount,
                    'time_out_count' => $timeOutCount,
                ];
            } else {
                // Update counts if the hour already exists
                $processedData[$hour]['time_in_count'] += $timeInCount;
                $processedData[$hour]['time_out_count'] += $timeOutCount;
            }
        }
    
        // Pass the processed data to the view for display
        return view('test', compact('date', 'processedData'));
    }
    
}
