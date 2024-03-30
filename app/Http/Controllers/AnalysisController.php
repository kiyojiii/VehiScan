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
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfWeek()->subDay(); // Adjust to start from Sunday
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfWeek()->subDay(); // Adjust to end on Saturday

        // Format the start and end dates
        $formattedStartDate = $startDate->format('F d, Y');
        $formattedEndDate = $endDate->format('F d, Y');

        // Initialize arrays to store time in and time out counts for each day of the week
        $timeInCounts = [];
        $timeOutCounts = [];
        $daysOfWeek = [];

        // Loop through each day of the week
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
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
        return view('analytics.index', compact('currentYear', 'year', 'monthlyTimeInCounts', 'monthlyTimeOutCounts', 'months', 'formattedStartDate', 'formattedEndDate', 'timeInCounts', 'timeOutCounts', 'daysOfWeek', 'roleCounts', 'vehicleStatusCounts', 'appointmentCounts', 'allAppointmentTypes', 'statusCounts', 'allStatusTypes'));
    }
}
