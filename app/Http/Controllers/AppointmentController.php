<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Appointment;
use Datatables;

class AppointmentController extends Controller
{
        /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-appointment', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-appointment', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-appointment', ['only' => ['destroy']]);
    }


    public function index()
    {
        $totalappointment = Appointment::count();
        return view('appointments.index', compact('totalappointment'));
    }

    public function fetchAllAppointment()
    {
        $role_status = Appointment::all();
        $output = '';
        $row = 1; // Initialize the row counter
        if ($role_status->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Appointment</th>
                <th class="text-center">Date</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($role_status as $rs) {
                $output .= '<tr>
                <td class="text-center">' . $row++ . '</td> <!-- Increment row counter -->
                <td class="text-center">' . $rs->appointment . '</td>
                <td class="text-center">' . date('F d, Y \a\t h:i A', strtotime($rs->created_at)) . '</td>
                <td class="text-center">';

                if (auth()->user()->can('edit-appointment')) {
                    $output .= '<a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" onClick="edit()"><i class="bi-pencil-square h4"></i></a>';
                }
                if (auth()->user()->can('delete-appointment')) {
                    $output .= '<a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>';
                }

                $output .= '</td>
            </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }
    }


    // insert a new appointment ajax request
    public function store(Request $request)
    {
        try {
            // Define custom error messages
            $customMessages = [
                'unique' => 'The Appointment ' . $request->appointment . ' already exists.',
            ];

            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'appointment' => 'required|string|max:255|unique:appointments,appointment', // Add unique rule
            ], $customMessages);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Create new applicant data with user_id
            $appointmentData = [
                'appointment' => $request->appointment,
            ];

            // Create the applicant record
            Appointment::create($appointmentData);

            return response()->json([
                'status' => 200,
                'message' => 'Appointment created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $appointment = Appointment::find($id);
        return response()->json($appointment);
    }

    public function update(Request $request)
    {
        try {
            // Define custom error messages
            $customMessages = [
                'unique' => 'The Appointment ' . $request->edit_appointment . ' already exists.',
            ];

            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'edit_appointment' => 'required|string|max:255|unique:appointments,appointment', // Add unique rule
            ], $customMessages);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Retrieve the appointment record
            $appointment = Appointment::find($request->appointment_id);

            // Update appointment data
            $appointmentData = [
                'appointment' => $request->edit_appointment,
            ];

            $appointment->update($appointmentData);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Appointment updated successfully.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // delete an appointment ajax request
    public function delete(Request $request)
    {
        $id = $request->id;
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Appointment not found'
            ], 404);
        }

        // Attempt to delete the appointment
        try {
            $appointment->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Appointment deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete appointment: ' . $e->getMessage()
            ], 500);
        }
    }
}
