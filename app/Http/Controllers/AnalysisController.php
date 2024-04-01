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

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        // FIRST ROW
        
        // Retrieve the count of applicants for each appointment type
        $appointmentCounts = Applicant::rightJoin('appointments', 'applicants.appointment_id', '=', 'appointments.id')
            ->select('appointments.appointment', \DB::raw('COUNT(applicants.id) as count'))
            ->groupBy('appointments.appointment')
            ->get();

        // Retrieve all distinct appointment types
        $allAppointmentTypes = Appointment::pluck('appointment')->toArray();

        // Retrieve the count of applicants for each status
        $statusCounts = Applicant::rightJoin('statuses', 'applicants.status_id', '=', 'statuses.id')
            ->select('statuses.applicant_role_status', \DB::raw('COUNT(applicants.id) as count'))
            ->groupBy('statuses.applicant_role_status')
            ->get();

        // Retrieve all distinct status types
        $allStatusTypes = Statuses::pluck('applicant_role_status')->toArray();

        // Retrieve the count of vehicles for each registration status
        $vehicleStatusCounts = Vehicle::select('registration_status', \DB::raw('COUNT(*) as count'))
            ->groupBy('registration_status')
            ->get();

        // Retrieve the count of users for each role
        $roleCounts = Role::leftJoin('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('roles.name as role', \DB::raw('COUNT(model_has_roles.role_id) as count'))
            ->groupBy('roles.name')
            ->get();

        // SECOND ROW

        // WEEKLY TIME COUNT 
        // Get the start and end dates from the request query parameters or default to the current week
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfWeek();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfWeek();
    
        // Format the start and end dates
        $formattedStartDate = $startDate->format('F d, Y');
        $formattedEndDate = $endDate->format('F d, Y');
    
        // Initialize arrays to store time in and time out counts for each day of the week
        $timeInCounts = [];
        $timeOutCounts = [];
        $daysOfWeek = [];
    
        // Loop through each day of the week
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Get the abbreviated day name (Mon, Tue, Wed, etc.)
            $formattedDate = $date->format('D');
            $daysOfWeek[] = $formattedDate;
    
            // Query the time records for the current date and count time in and time out separately
            $timeInCounts[] = Time::whereDate('created_at', $date)->whereNotNull('time_in')->count();
            $timeOutCounts[] = Time::whereDate('created_at', $date)->whereNotNull('time_out')->count();
        }

        // MONTHLY TIME COUNT
        // Get the current year
        $currentYear = Carbon::now()->year;
        // Get the start and end dates for the entire year
        $year = $request->year ?? date('Y');
        $startDate = Carbon::create($year, 1, 1)->startOfMonth();
        $endDate = Carbon::create($year, 12, 31)->endOfMonth();

        // Initialize arrays to store time in and time out counts for each month
        $monthlyTimeInCounts = [];
        $monthlyTimeOutCounts = [];
        $months = [];

        // Loop through each month of the year
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create($year, $month, 1)->startOfMonth();

            // Get the month name abbreviation
            $formattedMonth = $date->format('M');
            $months[] = $formattedMonth;

            // Query the time records for the current month and count time in and time out separately
            $monthlyTimeInCounts[] = Time::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->whereNotNull('time_in')
                ->count();

            $monthlyTimeOutCounts[] = Time::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->whereNotNull('time_out')
                ->count();
        }

        //HOURLY TIME RECORD
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
    
        //WEEKLY PEAK HOURS
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

        return view('analytics.index', compact('third_startDate', 'third_endDate', 'third_weeklyProcessedData', 'third_date', 'third_processedData', 'currentYear', 'year', 'monthlyTimeInCounts', 'monthlyTimeOutCounts', 'months', 'formattedStartDate', 'formattedEndDate', 'timeInCounts', 'timeOutCounts', 'daysOfWeek', 'roleCounts', 'vehicleStatusCounts', 'appointmentCounts', 'allAppointmentTypes', 'statusCounts', 'allStatusTypes'));
    }
}
