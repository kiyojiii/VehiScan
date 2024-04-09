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
        $totalviolations = Violation::count();
        return view('violations.index', compact('totalviolations', 'vehicles'));
    }

    public function fetchAllViolation(Request $request)
    {
        $query = Violation::query();

        // Apply date filter if provided
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Apply plate number filter if provided
        if ($request->filled('plate_number')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('plate_number', $request->plate_number);
            });
        }

        $violations = $query->get();

        if ($violations->isEmpty()) {
            return '<h1 class="text-center text-secondary my-5">No records found!</h1>';
        }

        $output = '<table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Vehicle</th>
                                <th class="text-center">Violation</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

        foreach ($violations as $index => $violation) {
            $output .= '<tr>
                            <td class="text-center">' . ($index + 1) . '</td>
                            <td class="text-center">' . $violation->vehicle->plate_number . '</td>
                            <td class="text-center">' . $violation->violation . '</td>
                            <td class="text-center">' . date('F d, Y \a\t h:i A', strtotime($violation->created_at)) . '</td>
                            <td class="text-center">';
            if (auth()->user()->can('view-violation')) {
                $output .= '<a href="' . route('vehicles.show', $violation->vehicle->id) . '" class="text-primary mx-1"><i class="bi bi-eye h4"></i></a>';
            }
            if (auth()->user()->can('edit-violation')) {
                $output .= '<a href="#" id="' . $violation->id . '" class="text-success mx-1 editIcon" onClick="edit()"><i class="bi-pencil-square h4"></i></a>';
            }
            if (auth()->user()->can('delete-violation')) {
                $output .= '<a href="#" id="' . $violation->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>';
            }

            $output .= '</td></tr>';
        }

        $output .= '</tbody></table>';

        return $output;
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

    public function update(Request $request)
    {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'edit-vehicle_id' => 'string|max:255',
                'edit-violation' => 'string|max:255',
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Retrieve the violation record
            $violation = Violation::find($request->violation_id);

            // Update violation data
            $violationData = [
                'violation' => $request->edit_violation,
                'vehicle_id' => $request->edit_vehicle_id,
            ];

            $violation->update($violationData);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Violation updated successfully.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
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
