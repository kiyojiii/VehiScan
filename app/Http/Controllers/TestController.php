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

        // Query the applicants_record table
        $applicants = DB::table('applicants_record')
            ->where('user_id', $user_id)
            ->orderBy('updated_at', 'desc')
            ->get();

        // Query the applicants_record table
        $vehicles = DB::table('vehicles_record')
            ->where('user_id', $user_id)
            ->orderBy('updated_at', 'desc')
            ->get();

        // Query the applicants_record table
        $drivers = DB::table('drivers_record')
            ->where('user_id', $user_id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('test', compact('applicants', 'vehicles', 'drivers'));
    }

    public function fetchTest()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
    
        // Retrieve the ID of the authenticated user
        $user_id = $user->id;
    
        // Query all three tables together
        $records = DB::table('applicants_record')
            ->select('pk', 'first_name', 'last_name', 'action', 'updated_at', DB::raw("'applicants_record' as `table`"))
            ->where('user_id', $user_id)
            ->orderBy('updated_at', 'desc')
            ->unionAll(
                DB::table('vehicles_record')
                    ->select('pk', 'plate_number', 'vehicle_make', 'action', 'updated_at', DB::raw("'vehicles_record' as `table`"))
                    ->where('user_id', $user_id)
                    ->orderBy('updated_at', 'desc')
            )
            ->unionAll(
                DB::table('drivers_record')
                    ->select('pk', 'driver_name', 'authorized_driver_name', 'action', 'updated_at', DB::raw("'drivers_record' as `table`"))
                    ->where('user_id', $user_id)
                    ->orderBy('updated_at', 'desc')
            )
            ->get();
    
        $output = '';
    
        if ($records->isNotEmpty()) {
            $output .= '<table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>PK</th>
                                <th>Action</th>
                                <th>Updated At</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>';
    
            foreach ($records as $record) {
                $type = '';
                switch ($record->table) {
                    case 'applicants_record':
                        $type = 'Applicant';
                        break;
                    case 'vehicles_record':
                        $type = 'Vehicle';
                        break;
                    case 'drivers_record':
                        $type = 'Driver';
                        break;
                }
                $output .= '<tr>
                                <td>' . $type . '</td>
                                <td>' . $record->pk . '</td>
                                <td>' . $record->action . '</td>
                                <td>' . $record->updated_at . '</td>
                                <td><button class="btn btn-primary view-button" data-pk="' . $record->pk . '">View</button></td>
                            </tr>';
            }
    
            $output .= '</tbody></table>';
        } else {
            $output = '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }
    
        return $output; // Return HTML response
    }
    
}
