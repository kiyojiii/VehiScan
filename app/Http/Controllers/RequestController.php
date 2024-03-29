<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\Applicant;
use App\Models\Driver;


class RequestController extends Controller
{
    public function index()
    {
        $owners = Applicant::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        $totalrequests = Vehicle::where('registration_status', 'Pending')->count();
        return view('request.index', compact('owners', 'vehicles', 'drivers', 'totalrequests'));
    }

    public function fetchUserRequest()
    {
        $vehicles = Vehicle::where('registration_status', 'Pending')->get();
        $output = '';
        if ($vehicles->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th class="text-center">Owner</th>
                        <th class="text-center">Plate Number</th>
                        <th class="text-center">Vehicle Make</th>
                        <th class="text-center">Vehicle Code</th>
                        <th class="text-center">Side Photo</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($vehicles as $vehicle) {
                $driverName = Driver::find($vehicle->driver_id)->driver_name ?? 'N/A';
                $owner_first = Applicant::find($vehicle->owner_id)->first_name ?? 'N/A';
                $first_letter = ucfirst(substr($owner_first, 0, 1)); // Capitalize the first letter
                $owner_last = ucfirst(Applicant::find($vehicle->owner_id)->last_name) ?? 'N/A';

                $output .= '<tr>
                    <td>' . $vehicle->id . '</td>
                    <td class="text-center">' . $first_letter . '. ' . $owner_last . '</td>
                    <td class="text-center">' . $vehicle->plate_number . '</td>
                    <td class="text-center">' . $vehicle->vehicle_make . '</td>
                    <td class="text-center">' . $vehicle->vehicle_code . ' </td>
                    <td class="text-center">
                        <img src="' . asset('storage/images/vehicles/' . $vehicle->side_photo) . '" alt="Side Photo" style="max-width: 50px; max-height: 50px;">
                    </td>
                    <td class="text-center">' . $vehicle->registration_status . '</td>
                    <td class="text-center">
                        <!-- Your other action buttons -->
                        <!-- For example: -->
                        <a href="#" id="' . $vehicle->id . '" class="text-primary mx-1 viewVehicle" onClick="view()"><i class="bi bi-eye h4"></i></a>
                        <a href="#" id="' . $vehicle->id . '" class="text-success mx-1 editVehicle" onClick="edit()"><i class="bi-pencil-square h4"></i></a>
                        <a href="#" id="' . $vehicle->id . '" class="text-danger mx-1 deactivateIcon"><i class="bi-dash-circle h4"></i></a>
                        <a href="#" id="' . $vehicle->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                    </td>
                </tr>';
            }
            $output .= '</tbody></table>';
        } else {
            $output = '<h1 class="text-center text-success my-5"><i class="bx bx-check-circle"></i>No More User Requests</h1>';
        }
        return $output;
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $vehicle = Vehicle::find($id);
        return response()->json($vehicle);
    }

    //update vehicle
    public function update(Request $request)
    {
        try {

            // Before validating the request, modify the reason field if approval is "Approved"
            $request->merge([
                'reason' => $request->approval === 'Approved' ? 'None / Approved' : $request->reason,
            ]);

            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'driver_name' => 'string|max:255',
                'owner_address' => 'string|max:2048',
                'plate_number' => 'required|string|max:255|unique:vehicles,plate_number,' .  $request->vehicle_id, // Use ignore rule to exclude the current record
                'vehicle_make' => 'string|max:255',
                'year_model' => 'string|max:255',
                'color' => 'string|max:255',
                'body_type' => 'string|max:255',
                'official_receipt_image' => 'image|max:2048',
                'certificate_of_registration_image' => 'image|max:2048',
                'deed_of_sale_image' => 'image|max:2048',
                'authorization_letter_image' => 'image|max:2048',
                'front_photo' => 'image|max:2048',
                'side_photo' => 'image|max:2048',
                'approval' => 'string|max:255',
                'reason' => 'nullable|string|max:255',
                'registration_status' => 'required|string|max:255',
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Retrieve the vehicle record
            $vehicle = Vehicle::find($request->vehicle_id);

            // Process file uploads and update filenames
            $fileFields = [
                'front_photo',
                'side_photo',
            ];

            $fileFieldDoc = [
                'official_receipt_image',
                'certificate_of_registration_image',
                'deed_of_sale_image',
                'authorization_letter_image',
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/images/vehicles', $fileName);
                    // Delete the old file if it exists
                    if ($vehicle->$field) {
                        Storage::delete('public/images/vehicles/' . $vehicle->$field);
                    }
                    $vehicle->$field = $fileName;
                }
            }

            foreach ($fileFieldDoc as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/images/vehicles/documents', $fileName);
                    // Delete the old file if it exists
                    if ($vehicle->$field) {
                        Storage::delete('public/images/vehicles/documents/' . $vehicle->$field);
                    }
                    $vehicle->$field = $fileName;
                }
            }

            // Update vehicle data
            $vehicle->update([
                'driver_id' => $request->driver_name,
                'owner_address' => $request->owner_address,
                'plate_number' => $request->plate_number,
                'vehicle_make' => $request->vehicle_make,
                'year_model' => $request->year_model,
                'color' => $request->color,
                'body_type' => $request->body_type,
                'approval_status' => $request->approval,
                'reason' => $request->reason,
                'registration_status' => $request->registration_status,
            ]);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Vehicle updated successfully.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function view(Request $request)
    {
        $id = $request->id;
        $vehicle = Vehicle::find($id);
        return response()->json($vehicle);
    }
}
