<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Vehicle;
use App\Models\Driver;

class VehicleController extends Controller
{
  public function index()
  {
    $drivers = Driver::all();
    return view('vehicles.index', compact('drivers'));
  }

  public function fetchAllVehicle()
  {
    $vehicles = Vehicle::all();
    $output = '';
    if ($vehicles->count() > 0) {
      $output .= '<table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Driver Name</th>
                    <th>Plate Number</th>
                    <th>Vehicle Make</th>
                    <th>Color</th>
                    <th>Side Photo</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';
      foreach ($vehicles as $vehicle) {
        $driverName = Driver::find($vehicle->driver_id)->driver_name ?? 'N/A';
        $output .= '<tr>
                    <td>' . $vehicle->id . '</td>
                    <td>' . $driverName . '</td>
                    <td>' . $vehicle->plate_number . '</td>
                    <td>' . $vehicle->vehicle_make . '</td>
                    <td>' . $vehicle->color . '</td>
                    <td class="text-center">
                      <img src="' . asset('storage/images/vehicles/' . $vehicle->side_photo) . '" alt="Side Photo" style="max-width: 50px; max-height: 50px;">
                    </td>
                    <td>' . $vehicle->approval_status . '</td>
                    <td>
                        <a href="' . route('vehicles.show', $vehicle->id) . '" class="text-primary mx-1"><i class="bi bi-eye h4"></i></a>
                        <a href="#" id="' . $vehicle->id . '" class="text-success mx-1 editIcon" onClick="edit()"><i class="bi-pencil-square h4"></i></a>
                        <a href="#" id="' . $vehicle->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                    </td>
                </tr>';
      }
      $output .= '</tbody></table>';
    } else {
      $output = '<h1 class="text-center text-secondary my-5">No record in the database!</h1>';
    }
    return $output;
  }

  // insert a new vehicle ajax request
  public function store(Request $request)
  {
    try {
      // Validate incoming request data
      $validator = Validator::make($request->all(), [
        'driver_id' => 'required|string|max:255',
        'owner_address' => 'required|string|max:2048',
        'plate_number' => 'required|string|max:255',
        'vehicle_make' => 'required|string|max:255',
        'year_model' => 'required|string|max:255',
        'color' => 'required|string|max:255',
        'body_type' => 'required|string|max:255',
        'official_receipt_image' => 'required|image|max:2048',
        'certificate_of_registration_image' => 'required|image|max:2048',
        'deed_of_sale_image' => 'required|image|max:2048',
        'authorization_letter_image' => 'required|image|max:2048',
        'front_photo' => 'required|image|max:2048',
        'side_photo' => 'required|image|max:2048',
        'approval' => 'required|string|max:255',
        'reason' => 'nullable|string|max:255',
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

      // Generate unique file names using UUIDs
      $orifileName = Str::uuid() . '.' . $request->file('official_receipt_image')->getClientOriginalExtension();
      $crifileName = Str::uuid() . '.' . $request->file('certificate_of_registration_image')->getClientOriginalExtension();
      $dsifileName = Str::uuid() . '.' . $request->file('deed_of_sale_image')->getClientOriginalExtension();
      $alifileName = Str::uuid() . '.' . $request->file('authorization_letter_image')->getClientOriginalExtension();
      $fpfileName = Str::uuid() . '.' . $request->file('front_photo')->getClientOriginalExtension();
      $spfileName = Str::uuid() . '.' . $request->file('side_photo')->getClientOriginalExtension();

      // Store each file with unique file names
      $request->file('official_receipt_image')->storeAs('public/images/vehicles/documents', $orifileName);
      $request->file('certificate_of_registration_image')->storeAs('public/images/vehicles/documents', $crifileName);
      $request->file('deed_of_sale_image')->storeAs('public/images/vehicles/documents', $dsifileName);
      $request->file('authorization_letter_image')->storeAs('public/images/vehicles/documents', $alifileName);
      $request->file('front_photo')->storeAs('public/images/vehicles', $fpfileName);
      $request->file('side_photo')->storeAs('public/images/vehicles', $spfileName);

      // Create new vehicle data with user_id and unique file names
      $vehicleData = [
        'user_id' => $user_id,
        'driver_id' => $request->driver_id,
        'owner_address' => $request->owner_address,
        'plate_number' => $request->plate_number,
        'vehicle_make' => $request->vehicle_make,
        'year_model' => $request->year_model,
        'color' => $request->color,
        'body_type' => $request->body_type,
        'official_receipt_image' => $orifileName,
        'certificate_of_registration_image' => $crifileName,
        'deed_of_sale_image' => $dsifileName,
        'authorization_letter_image' => $alifileName,
        'front_photo' => $fpfileName,
        'side_photo' => $spfileName,
        'approval_status' => $request->approval,
        'reason' => $request->filled('reason') ? $request->reason : 'None / Approved', // Check if reason is empty
      ];

      // Create the vehicle record
      Vehicle::create($vehicleData);

      return response()->json([
        'status' => 200,
        'message' => 'Vehicle created successfully.'
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
        'plate_number' => 'string|max:255',
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


  public function delete(Request $request)
  {
    $id = $request->id;
    $vehicle = Vehicle::find($id);
    if (!$vehicle) {
      return response()->json([
        'status' => 'error',
        'message' => 'Vehicle not found'
      ], 404);
    }

    // Delete vehicle license image
    if ($vehicle->official_receipt_image) {
      Storage::delete('public/images/vehicles/documents/' . $vehicle->official_receipt_image);
    }

    // Delete vehicle license image
    if ($vehicle->certificate_of_registration_image) {
      Storage::delete('public/images/vehicles/documents/' . $vehicle->certificate_of_registration_image);
    }


    // Delete vehicle license image
    if ($vehicle->deed_of_sale_image) {
      Storage::delete('public/images/vehicles/documents/' . $vehicle->deed_of_sale_image);
    }

    // Delete vehicle license image
    if ($vehicle->authorization_letter_image) {
      Storage::delete('public/images/vehicles/documents/' . $vehicle->authorization_letter_image);
    }

    // Delete vehicle license image
    if ($vehicle->front_photo) {
      Storage::delete('public/images/vehicles/' . $vehicle->front_photo);
    }

    // Delete vehicle license image
    if ($vehicle->side_photo) {
      Storage::delete('public/images/vehicles/' . $vehicle->side_photo);
    }


    // Now delete the vehicle record
    $vehicle->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Vehicle deleted successfully'
    ]);
  }

  public function show($id)
  {
      $vehicles = Vehicle::find($id);
      return view('vehicles.show', compact('vehicles'));
  }
}
