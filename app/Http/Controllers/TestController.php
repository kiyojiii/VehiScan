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
        $third_date = $request->input('date', Carbon::today()->format('Y-m-d'));

    // Query to get the count of time_in and time_out per hour for the specified date
    $third_timeData = Time::select(
        DB::raw('HOUR(time_in) as hour'),
        DB::raw('COUNT(time_in) as time_in_count'),
        DB::raw('NULL as time_out_count') // Placeholder for time_out count
    )
    ->whereDate('time_in', $third_date)
    ->groupBy('hour')
    ->union(
        Time::select(
            DB::raw('HOUR(time_out) as hour'),
            DB::raw('NULL as time_in_count'), // Placeholder for time_in count
            DB::raw('COUNT(time_out) as time_out_count')
        )
        ->whereDate('time_out', $third_date)
        ->groupBy('hour')
    )
    ->orderBy('hour') // Order by hour
    ->get();

    // Prepare the data for display
    $third_processedData = [];
    foreach ($third_timeData as $record) {
        $hour = $record->hour;
        $timeInCount = $record->time_in_count ?: 0; // Set time_in count to 0 if NULL
        $timeOutCount = $record->time_out_count ?: 0; // Set time_out count to 0 if NULL

        // Store the counts for each hour
        if (!isset($third_processedData[$hour])) {
            $third_processedData[$hour] = [
                'time_in_count' => $timeInCount,
                'time_out_count' => $timeOutCount,
            ];
        } else {
            // Update counts if the hour already exists
            $third_processedData[$hour]['time_in_count'] += $timeInCount;
            $third_processedData[$hour]['time_out_count'] += $timeOutCount;
        }
    }

    //WEEKLY
    $third_startDate = $request->input('start_date', Carbon::today()->startOfWeek()->format('Y-m-d'));
    $third_endDate = $request->input('end_date', Carbon::today()->endOfWeek()->format('Y-m-d'));

    $third_weeklyProcessedData = [];

    // Loop through each day of the week
    $currentDate = Carbon::parse($third_startDate);
    while ($currentDate->lte($third_endDate)) {
        // Query to find the hour with the maximum time_in count for the current date
        $maxTimeInHour = Time::select(
            DB::raw('HOUR(time_in) as hour'),
            DB::raw('COUNT(time_in) as time_in_count')
        )
        ->whereDate('time_in', $currentDate)
        ->groupBy('hour')
        ->orderByDesc('time_in_count')
        ->limit(1)
        ->first();

        // Query to find the hour with the maximum time_out count for the current date
        $maxTimeOutHour = Time::select(
            DB::raw('HOUR(time_out) as hour'),
            DB::raw('COUNT(time_out) as time_out_count')
        )
        ->whereDate('time_out', $currentDate)
        ->groupBy('hour')
        ->orderByDesc('time_out_count')
        ->limit(1)
        ->first();

        // Store the processed data for the current date
        $third_weeklyProcessedData[$currentDate->format('Y-m-d')] = [
            'date' => $currentDate->format('Y-m-d'),
            'max_time_in_hour' => $maxTimeInHour ? $maxTimeInHour->hour : null,
            'max_time_out_hour' => $maxTimeOutHour ? $maxTimeOutHour->hour : null,
            'max_time_in_count' => $maxTimeInHour ? $maxTimeInHour->time_in_count : 0,
            'max_time_out_count' => $maxTimeOutHour ? $maxTimeOutHour->time_out_count : 0,
        ];

        // Move to the next day
        $currentDate->addDay();
    }
    
        // Pass the processed data to the view for display
        return view('test', compact('third_startDate', 'third_endDate', 'third_weeklyProcessedData', 'third_date', 'third_processedData'));
    }
}
