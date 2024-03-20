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
use App\Models\Time;
use App\Charts\AppointmentChart;
use Carbon;
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
        $vehicles = Vehicle::where('owner_id', $owner_id)->first();

        return view('test', compact('vehicles'));
    }
}
