<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Violation;
use App\Models\Vehicle;
use Datatables;

class ViolationController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        if (request()->ajax()) {
            return datatables()->of(Violation::select('*'))
                ->addColumn('action', 'violations.violation-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(True);
        }
        return view('violations.index', compact('vehicles'));
    }

    public function fetchAllViolation()
    {
        $violation = Violation::all();
        $output = '';
        if ($violation->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>No.</th>
                <th>Vehicle</th>
                <th>Violation</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($violation as $rs) {
                // Find the vehicle associated with the violation
                $vehicle = Vehicle::find($rs->vehicle_id);

                // Get the plate number or set it to 'N/A' if not found
                $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';

                $output .= '<tr>
                    <td>' . $rs->id . '</td>
                    <td>' . $vehiclePlate . '</td>
                    <td>' . $rs->violation . '</td>
                    <td>' . $rs->created_at . '</td>
                    <td>
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

    // insert a new violation ajax request
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'vehicle_id' => 'required|string|max:255',
                'violation' => 'required|string|max:255',
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }


            // Process file upload
            // if ($request->hasFile('scan_or_photo_of_id')) {
            //     $file = $request->file('scan_or_photo_of_id');
            //     $fileName = time() . '.' . $file->getClientOriginalExtension();
            //     $file->storeAs('public/images', $fileName); //php artisan storage:link
            // } else {
            //     throw new \Exception('Photo file is required.');
            // }

            // Create new applicant data with user_id
            $violationData = [
                'violation' => $request->violation,
                'vehicle_id' => $request->vehicle_id,
            ];

            // Create the applicant record
            Violation::create($violationData);

            return response()->json([
                'status' => 200,
                'message' => 'Violation created successfully.'
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
        $violation = Violation::find($id);
        return response()->json($violation);
    }

    // delete an violation ajax request
    public function delete(Request $request)
    {
        $id = $request->id;
        $violation = Violation::find($id);
        
        if (!$violation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Violation not found'
            ], 404);
        }
        
        // Attempt to delete the violation
        try {
            $violation->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Violation deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete violation: ' . $e->getMessage()
            ], 500);
        }
    }
    
}
