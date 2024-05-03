<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Appointment;
use App\Models\Statuses;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Time;
use App\Models\Vehicle_Record;
use DateTime;

class PrintController extends Controller
{
    public function index($id)
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        $drivers = Driver::all();
        $vehicles = Vehicle::all();
        $owners = Applicant::findOrFail($id);

        // Retrieve the vehicle associated with the owner
        $vehicle = $owners->vehicle;

        return view('print.index', compact('vehicle', 'appointments', 'role_status', 'drivers', 'vehicles', 'owners'));
    }
}
