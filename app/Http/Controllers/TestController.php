<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Appointment;
use App\Models\Statuses;
use App\Models\Vehicle;
use App\Models\Driver;

class TestController extends Controller
{
    public function index()
    {
        // Retrieve all applicants
        $applicants = Applicant::all();
    
        // Initialize an array to hold vehicles associated with each applicant
        $applicantVehicles = [];
    
        // Loop through each applicant
        foreach ($applicants as $applicant) {
            // Retrieve vehicles associated with the current applicant
            $vehicles = Vehicle::where('owner_id', $applicant->id)->get();
            
            // Add the vehicles to the array, indexed by applicant ID
            $applicantVehicles[$applicant->id] = $vehicles;
        }
    
        // Retrieve all drivers (if needed)
        $drivers = Driver::all();
    
        // Pass the data to the view
        return view('test', compact('applicants', 'applicantVehicles', 'drivers'));
    }
    
}
