<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Permission;

class PermissionController extends Controller
{  
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function fetchAllPermission()
    {
        $permission = Permission::all();
        $output = '';
        $row = 1; // Initialize the row counter
        if ($permission->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Permission Name</th>
                <th class="text-center">Date</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($permission as $p) {
                $output .= '<tr>
                    <td class="text-center">' . $row++ . '</td> <!-- Increment row counter -->
                    <td class="text-center">' . $p->name . '</td>
                    <td class="text-center">' . date('F d, Y \a\t h:i A', strtotime($p->created_at)) . '</td>
                    <td class="text-center">
                        <a href="#" id="' . $p->id . '" class="text-success mx-1 editIcon" onClick="edit()"><i class="bi-pencil-square h4"></i></a>
                        <a href="#" id="' . $p->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                    </td>
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
                'unique' => 'The Permission ' . $request->permission . ' already exists.',
            ];

            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'permission' => 'required|string|max:255|unique:permissions,name', // Add unique rule
            ], $customMessages);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Create new applicant data with user_id
            $permissionData = [
                'name' => $request->permission,
                'guard_name' => "web",
            ];            

            // Create the applicant record
            Permission::create($permissionData);

            return response()->json([
                'status' => 200,
                'message' => 'Permission created successfully.'
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
        $permission = Permission::find($id);
        return response()->json($permission);
    }

    public function update(Request $request)
    {
        try {
            // Define custom error messages
            $customMessages = [
                'unique' => 'The Permission ' . $request->edit_permission . ' already exists.',
            ];

            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'edit_permission' => 'required|string|max:255|unique:permissions,name', // Add unique rule
            ], $customMessages);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Retrieve the permissions record
            $permissions = Permission::find($request->permission_id);

            // Update permission data
            $permissionData = [
                'name' => $request->edit_permission,
            ];

            $permissions->update($permissionData);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Permission updated successfully.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

        // delete an permission ajax request
        public function delete(Request $request)
        {
            $id = $request->id;
            $permission = Permission::find($id);
    
            if (!$permission) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Permission not found'
                ], 404);
            }
    
            // Attempt to delete the permission
            try {
                $permission->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Permission deleted successfully'
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to delete permission: ' . $e->getMessage()
                ], 500);
            }
        }
}
