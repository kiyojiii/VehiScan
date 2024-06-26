<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Driver;
use App\Models\Vehicle;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totaldriver = Driver::count();
        return view('drivers.index', compact('totaldriver'));
    }

    public function fetchAllDriver()
    {
        $drivers = Driver::all();
        $output = '';
        if ($drivers->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Vehicle</th>
                <th class="text-center">Driver Name</th>
                <th class="text-center">Authorized Driver</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($drivers as $rs) {
                // Find the vehicle associated with the driver
                $vehicle = Vehicle::where('driver_id', $rs->id)
                    ->where('registration_status', 'Active') // Add condition for active vehicles
                    ->first();

                // Get the plate number or set it to 'N/A' if not found
                $vehiclePlate = $vehicle ? $vehicle->plate_number : 'N/A';

                $output .= '<tr>
                <td class="text-center">' . $rs->id . '</td>
                <td class="text-center">' . $vehiclePlate . '</td>
                <td class="text-center">' . $rs->driver_name . '</td>            
                <td class="text-center">' . $rs->authorized_driver_name . '</td>
                <td class="text-center">' . $rs->approval_status . '</td>
                <td class="text-center">';

                if (auth()->user()->can('view-driver')) {
                    $output .= '<a href="' . route('drivers.show', $rs->id) . '" class="text-primary mx-1"><i class="bi bi-eye h4"></i></a>';
                }
                if (auth()->user()->can('edit-driver')) {
                    $output .= '<a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" onClick="edit()"><i class="bi-pencil-square h4"></i></a>';
                }
                if (auth()->user()->can('delete-driver')) {
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

    // insert a new driver ajax request
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'dname' => 'required|string|max:255|unique:drivers,driver_name,' . $request->driver_id,
                'driver_license_image' => 'required|image|max:2048',
                'adname' => 'nullable|string|max:255',
                'adaddress' => 'nullable|string|max:255',
                'authorized_driver_license_image' => 'nullable|image|max:2048',
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

            // Generate unique filenames using UUID
            $dlfileName = $request->hasFile('driver_license_image') ? Str::uuid() . '.' . $request->file('driver_license_image')->getClientOriginalExtension() : null;
            $adlfileName = $request->hasFile('authorized_driver_license_image') ? Str::uuid() . '.' . $request->file('authorized_driver_license_image')->getClientOriginalExtension() : null;

            // Store driver license image if exists
            if ($dlfileName) {
                $request->file('driver_license_image')->storeAs('public/images/drivers', $dlfileName);
            }

            // Store authorized driver license image if exists
            if ($adlfileName) {
                $request->file('authorized_driver_license_image')->storeAs('public/images/drivers', $adlfileName);
            }

            // Create new applicant data with user_id and unique file names
            $driverData = [
                'user_id' => $user_id,
                'driver_name' => $request->dname,
                'driver_license_image' => $dlfileName,
                'authorized_driver_license_image' => $adlfileName ?: 'N/A',
                'authorized_driver_name' => $request->adname ?: 'N/A',
                'authorized_driver_address' => $request->adaddress ?: 'N/A',
                'approval_status' => $request->approval,
                'reason' => $request->filled('reason') ? $request->reason : 'None / Approved', // Check if reason is empty
            ];

            // Create the driver record
            Driver::create($driverData);

            return response()->json([
                'status' => 200,
                'message' => 'Driver created successfully.'
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
        $driver = Driver::find($id);
        return response()->json($driver);
    }

    public function update(Request $request)
    {
        try {

            // Before validating the request, modify the reason field if approval is "Approved"
            $request->merge([
                'reason' => $request->approval === 'Approved' ? 'None / Approved' : $request->reason,
            ]);
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'dname' => 'required|string|max:255|unique:drivers,driver_name,' . $request->driver_id,
                'driver_license_image' => 'image|max:2048', // Assuming it's an image file
                'adname' => 'nullable|string|max:255',
                'adaddress' => 'nullable|string|max:255',
                'authorized_driver_license_image' => 'nullable|image|max:2048', // Assuming it's an image file
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

            // Retrieve the driver record
            $driver = Driver::find($request->driver_id);

            // Process file upload for driver's license image
            if ($request->hasFile('driver_license_image')) {
                $dlfile = $request->file('driver_license_image');
                $dlfileName = Str::uuid() . '.' . $dlfile->getClientOriginalExtension();
                $dlfile->storeAs('public/images/drivers', $dlfileName); //php artisan storage:link
                // Delete the old file if it exists
                if ($driver->driver_license_image) {
                    Storage::delete('public/images/drivers/' . $driver->driver_license_image);
                }
            } else {
                $dlfileName = $driver->driver_license_image;
            }

            // Process file upload for authorized driver's license image
            if ($request->hasFile('authorized_driver_license_image')) {
                $adlfile = $request->file('authorized_driver_license_image');
                $adlfileName = Str::uuid() . '.' . $adlfile->getClientOriginalExtension();
                $adlfile->storeAs('public/images/drivers', $adlfileName); //php artisan storage:link
                // Delete the old file if it exists
                if ($driver->authorized_driver_license_image) {
                    Storage::delete('public/images/drivers/' . $driver->authorized_driver_license_image);
                }
            } else {
                $adlfileName = $driver->authorized_driver_license_image;
            }

            // Update driver data
            $driverData = [
                'driver_name' => $request->dname,
                'authorized_driver_name' => $request->adname,
                'authorized_driver_address' => $request->adaddress,
                'approval_status' => $request->approval,
                'reason' => $request->reason,
                'driver_license_image' => $dlfileName,
                'authorized_driver_license_image' => $adlfileName,
            ];

            $driver->update($driverData);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Driver updated successfully.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // delete an driver ajax request
    public function delete(Request $request)
    {
        $id = $request->id;
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver not found'
            ], 404);
        }

        // Delete driver license image
        if ($driver->driver_license_image) {
            Storage::delete('public/images/drivers/' . $driver->driver_license_image);
        }

        // Delete authorized driver license image
        if ($driver->authorized_driver_license_image) {
            Storage::delete('public/images/drivers/' . $driver->authorized_driver_license_image);
        }

        // Now delete the driver record
        $driver->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Driver deleted successfully'
        ]);
    }

    public function show($id)
    {
        $drivers = Driver::find($id);
        return view('drivers.show', compact('drivers'));
    }
}
