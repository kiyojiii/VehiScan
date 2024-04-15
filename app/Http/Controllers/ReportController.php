<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Time;
use App\Models\Vehicle;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $totalvehiclespreviousmonth = Carbon::now()->subMonth()->format('F');
        $totalvehiclespreviousmonthcount = Time::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereNotNull('time_in')
            ->count();

        $totalvehiclespreviousday = Carbon::yesterday()->toDateString();
        $totalvehiclespreviousdayformat = Carbon::yesterday()->format('F, d, Y');
        $totalvehiclespreviousdaycount = Time::whereDate('time_in', $totalvehiclespreviousday)->whereNotNull('time_in')->count();

        $totalvehiclestoday = Carbon::now();
        $totalvehiclestodayformat = Carbon::now()->format('F, d, Y');
        $totalvehiclestodaycount = Time::whereDate('time_in', $totalvehiclestoday)->whereNotNull('time_in')->count();

        // Get the current month in 'YYYY-MM' format
        $currentMonth = Carbon::now()->format('Y-m');

        // Count how many vehicles timed in within the current month
        $totalvehiclesthismonthcount = Time::whereNotNull('time_in')
            ->whereYear('time_in', Carbon::now()->year)
            ->whereMonth('time_in', Carbon::now()->month)
            ->count();

        $currentMonthFormat = Carbon::now()->format('F');

        return view('reports.index', compact('currentMonthFormat', 'totalvehiclestodayformat', 'totalvehiclespreviousdayformat', 'totalvehiclesthismonthcount', 'currentMonth', 'totalvehiclestodaycount', 'totalvehiclestoday', 'totalvehiclespreviousdaycount', 'totalvehiclespreviousday', 'totalvehiclespreviousmonthcount', 'totalvehiclespreviousmonth'));
    }

    public function fetchMonthlyVehicle(Request $request)
    {
        $query = Time::query();

        // Apply date filter if provided
        if ($request->filled('monthly_date')) {
            // Parse the selected month and year
            $selectedMonth = Carbon::createFromFormat('m/Y', $request->monthly_date)->startOfMonth();

            // Filter records for the selected month
            $query->whereYear('time_in', $selectedMonth->year)
                ->whereMonth('time_in', $selectedMonth->month);
        }

        $time = $query->get();

        if ($time->isEmpty()) {
            return '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }

        $row = 1; // Initialize the row counter
        $output = '<table id="monthly_table" class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Vehicle</th>
                            <th class="text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($time as $rs) {
            // Find the vehicle associated with the owner
            $vehicle = Vehicle::find($rs->vehicle_id);

            // Get the plate number or set it to 'N/A' if not found
            $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';

            $output .= '<tr>
                            <td class="text-center">' . $row++ . '</td> <!-- Increment row counter -->
                            <td class="text-center">' . $vehiclePlate . '</td>
                            <td class="text-center">' . date('F d, Y \a\t h:i A', strtotime($rs->time_in)) . '</td>
                        </tr>';
        }

        $output .= '</tbody></table>';

        return $output;
    }

    public function fetchTodayVehicle(Request $request)
    {
        // Get the selected date from the request
        $selectedDate = $request->input('day_date');
    
        // If no date is selected, use the current date
        if (empty($selectedDate)) {
            $selectedDate = Carbon::now()->format('Y-m-d');
        } else {
            // Convert the selected date to the format 'Y-m-d'
            $selectedDate = Carbon::createFromFormat('d/m/Y', $selectedDate)->format('Y-m-d');
        }
    
        // Query the database for vehicles with the selected date
        $time = Time::whereDate('time_in', $selectedDate)->get();
    
        if ($time->isEmpty()) {
            return '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }
    
        $row = 1; // Initialize the row counter
        $output = '<table id="today_table" class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Vehicle</th>
                                <th class="text-center">Date</th>
                            </tr>
                        </thead>
                        <tbody>';
    
        foreach ($time as $rs) {
            // Find the vehicle associated with the owner
            $vehicle = Vehicle::find($rs->vehicle_id);
    
            // Get the plate number or set it to 'N/A' if not found
            $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';
    
            $output .= '<tr>
                            <td class="text-center">' . $row++ . '</td> <!-- Increment row counter -->
                            <td class="text-center">' . $vehiclePlate . '</td>
                            <td class="text-center">' . date('F d, Y \a\t h:i A', strtotime($rs->time_in)) . '</td>
                        </tr>';
        }
    
        $output .= '</tbody></table>';
    
        return $output;
    }
}
