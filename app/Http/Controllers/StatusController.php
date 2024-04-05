<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Statuses;
use Datatables;

class StatusController extends Controller
{
        /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-status', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-status', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-status', ['only' => ['destroy']]);
    }


    public function index()
    {
        $rstotalcount = Statuses::count();
        return view('status.index', compact('rstotalcount'));
    }

    public function fetchAllRoleStatus()
    {
        $role_status = Statuses::all();
        $output = '';
        $row = 1; // Initialize the row counter
        if ($role_status->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Role Status</th>
                <th class="text-center">Date</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($role_status as $rs) {
                $output .= '<tr>
                    <td class="text-center">' . $row++ . '</td> <!-- Increment row counter -->
                    <td class="text-center">' . $rs->applicant_role_status . '</td>
                    <td class="text-center">' . date('F d, Y \a\t h:i A', strtotime($rs->created_at)) . '</td>
                    <td class="text-center">';
    
                // Check if the user has permission to edit status
                if (auth()->user()->can('edit-status')) {
                    $output .= '<a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" onClick="edit()"><i class="bi-pencil-square h4"></i></a>';
                }
    
                // Check if the user has permission to delete status
                if (auth()->user()->can('delete-status')) {
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

    // insert a new role status ajax request
    public function store(Request $request)
    {
        try {
            // Define custom error messages
            $customMessages = [
                'unique' => 'The Role Status ' . $request->applicant_role_status . ' already exists.',
            ];

            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'applicant_role_status' => 'required|string|max:255|unique:statuses,applicant_role_status', // Add unique rule
            ], $customMessages);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Create new applicant data with user_id
            $rolestatusData = [
                'applicant_role_status' => $request->applicant_role_status,
            ];

            // Create the applicant record
            Statuses::create($rolestatusData);

            return response()->json([
                'status' => 200,
                'message' => 'Status created successfully.'
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
        $role_status = Statuses::find($id);
        return response()->json($role_status);
    }

    public function update(Request $request)
    {
        try {
            // Define custom error messages
            $customMessages = [
                'unique' => 'The Role Status ' . $request->edit_applicant_role_status . ' already exists.',
            ];

            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'edit_applicant_role_status' => 'required|string|max:255|unique:statuses,applicant_role_status', // Add unique rule
            ], $customMessages);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Retrieve the rolestatus record
            $rolestatus = Statuses::find($request->rolestatus_id);

            // Update rolestatus data
            $rolestatusData = [
                'applicant_role_status' => $request->edit_applicant_role_status,
            ];

            $rolestatus->update($rolestatusData);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Role Status updated successfully.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // delete an rolestatus ajax request
    public function delete(Request $request)
    {
        $id = $request->id;
        $rolestatus = Statuses::find($id);

        if (!$rolestatus) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role Status not found'
            ], 404);
        }

        // Attempt to delete the role status
        try {
            $rolestatus->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Role Status deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete role status: ' . $e->getMessage()
            ], 500);
        }
    }
}
