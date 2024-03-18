<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Appointment;
use App\Models\Statuses;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use App\Models\Time;
use App\Charts\AppointmentChart;
use Carbon;
use DB;

class TestController extends Controller
{
    public function index()
    {
        // Get the current month and previous month
        $currentMonth = date('Y-m');
        $previousMonth = date('Y-m', strtotime('-1 month'));
    
        // Query the total time count of the current month
        $totalTimeCurrentMonth = Time::whereYear('created_at', '=', date('Y'))
                                    ->whereMonth('created_at', '=', date('m'))
                                    ->count();
    
        // Query the total time count of the previous month
        $totalTimePreviousMonth = Time::whereYear('created_at', '=', date('Y', strtotime('-1 month')))
                                    ->whereMonth('created_at', '=', date('m', strtotime('-1 month')))
                                    ->count();
    
        // Rest of your existing code
        $applicants = Applicant::all();
        $appointments = Appointment::withCount('applicants')->get();
        $totalTimePerDay = Time::selectRaw('DATE(created_at) as date, COUNT(time_in) as total_time_in, COUNT(time_out) as total_time_out')
                                ->groupByRaw('DATE(created_at)')
                                ->orderByRaw('DATE(created_at)')
                                ->get();
    
        return view('test', compact('totalTimePerDay', 'applicants', 'appointments', 'totalTimeCurrentMonth', 'totalTimePreviousMonth'));
    }
    
}
