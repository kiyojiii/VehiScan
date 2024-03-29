<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Vehicle;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Appointment;
use App\Models\Applicant;
use App\Models\Driver;
use App\Models\Time;
use App\Models\Violation;
use App\Models\Vehicle_Record;
use App\Models\Statuses;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use DB;

class ProfileController extends Controller
{
    public function admin_profile()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the ID of the authenticated user
        $user_id = $user->id;

        // Find the owners associated with the authenticated user
        $owners = Applicant::where('user_id', $user->id)->get();

        // Find the owners associated with the authenticated user
        $applicants = Applicant::where('user_id', $user_id)->get();

        // Extract appointment IDs from the retrieved applicants
        $appointmentIds = $applicants->pluck('appointment_id');

        $appointment = Appointment::whereIn('id', $appointmentIds)->get();

        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        // Pass the owners data to the view
        return view('profile.index', compact('appointment'), [
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }
}
