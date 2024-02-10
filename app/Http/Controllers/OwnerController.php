<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Applicant;
use App\Models\Appointment;
use App\Models\Statuses;


class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $role_status = Statuses::all();
        $appointments = Appointment::all();
        return view('owners.index', compact('role_status', 'appointments'));
    }

    public function fetchAll()
    {
        $owner = Applicant::all();
        $output = '';
        if ($owner->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Department</th>
                <th>Position</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($owner as $rs) {
                $output .= '<tr>
                <td>' . $rs->id . '</td>
                <td>' . $rs->first_name . ' ' . $rs->middle_initial . '. ' . $rs->last_name . '</td>
                <td>' . $rs->contact_number . '</td>
                <td>' . $rs->office_department_agency . '</td>
                <td>' . $rs->position_designation . '</td>
                <td>' . $rs->approval_status . '</td>
                <td>
                <a href="' . route('owners.show', $rs->id) . '" class="text-primary mx-1"><i class="bi bi-eye h4"></i></a>
                <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" onClick="edit()"><i class="bi-pencil-square h4"></i></a>
                <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
        }
    }

       // insert a new owner ajax request
       public function store(Request $request) {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'fname' => 'required|string|max:255',
                'mi' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'paddress' => 'required|string|max:255',
                'email' => 'required|email',
                'contact' => 'required|string|max:255',
                'appointment' => 'required|string|max:255', 
                'role_status' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'approval' => 'required|string|max:255',
                'reason' => 'nullable|string|max:255',
                'scan_or_photo_of_id' => 'required|image|max:2048', // Assuming it's an image file
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }
            

            // Get the currently authenticated user's ID
            $user_id = auth()->id();
    
            // Process file upload
            if ($request->hasFile('scan_or_photo_of_id')) {
                $file = $request->file('scan_or_photo_of_id');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName); //php artisan storage:link
            } else {
                throw new \Exception('Photo file is required.');
            }
    
            // Create new applicant data with user_id
            $ownerData = [
                'user_id' => $user_id,
                'first_name' => $request->fname, 
                'middle_initial' => $request->mi,
                'last_name' => $request->lname, 
                'present_address' => $request->paddress,
                'email_address' => $request->email,
                'contact_number' => $request->contact,
                'appointment_id' => $request->appointment,
                'status_id' => $request->role_status,
                'office_department_agency' => $request->department,
                'position_designation' => $request->position,
                'approval_status' => $request->approval,
                'reason' => $request->reason,
                'scan_or_photo_of_id' => $fileName,
            ];
    
            // Create the applicant record
            Applicant::create($ownerData);
    
            return response()->json([
                'status' => 200,
                'message' => 'Applicant created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request){
        $id = $request->id;
        $owner = Applicant::find($id);
        return response()->json($owner);
    }

    public function update(Request $request) {
        $fileName = '';
        $owner = Applicant::find($request->owner_id);
        if ($request->hasFile('scan_or_photo_of_id')) {
            $file = $request->file('scan_or_photo_of_id');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            if ($owner->scan_or_photo_of_id) {
                Storage::delete('public/images/' . $owner->scan_or_photo_of_id);
            }
        } else {
            $fileName = $request->owner_photo;
        }

        $ownerData = [
            'first_name' => $request->fname, 
            'middle_initial' => $request->mi,
            'last_name' => $request->lname, 
            'present_address' => $request->paddress,
            'email_address' => $request->email,
            'contact_number' => $request->contact,
            'appointment_id' => $request->appointment,
            'status_id' => $request->role_status,
            'office_department_agency' => $request->department,
            'position_designation' => $request->position,
            'approval_status' => $request->approval,
            'scan_or_photo_of_id' => $fileName,
        ];

        $owner->update($ownerData);
        return response()->json([
            'status' => 200,
        ]);

    }

    // delete an owner ajax request
    public function delete(Request $request){
        $id = $request->id;
        $owner = Applicant::find($id);
        if (!$owner) {
            return response()->json([
                'status' => 'error',
                'message' => 'Owner not found'
            ], 404);
        }
        if (Storage::delete('public/images/applicants/' . $owner->scan_or_photo_of_id)) {
            $owner->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Owner deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete owner'
            ], 500);
        }
    }
    
    public function show($id){
        $owners = Applicant::find($id);
        return view('owners.show', compact('owners'));
    }
}
