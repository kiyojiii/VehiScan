<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Driver;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('drivers.index');
    }

    public function fetchAllDriver()
    {
        $driver = Driver::all();
        $output = '';
        if ($driver->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>No.</th>
                <th>Driver Name</th>
                <th>Driver License</th>
                <th>Authorized Driver</th>
                <th>Authorized Driver License</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($driver as $rs) {
                $output .= '<tr>
                <td>' . $rs->id . '</td>
                <td>' . $rs->driver_name . '</td>
                <td>
                    <img src="' . asset('storage/images/drivers/' . $rs->driver_license_image) . '" alt="Driver\'s License" style="max-width: 50px; max-height: 50px;">
                </td>
                <td>' . $rs->authorized_driver_name . '</td>
                <td>
                    <img src="' . asset('storage/images/drivers/' . $rs->authorized_driver_license_image) . '" alt="Authorized Driver\'s License" style="max-width: 50px; max-height: 50px;">
                </td>
                <td>' . $rs->approval_status . '</td>
                <td>
                <a href="' . route('drivers.show', $rs->id) . '" class="text-primary mx-1"><i class="bi bi-eye h4"></i></a>
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

     // insert a new driver ajax request
     public function store(Request $request)
     {
         try {
             // Validate incoming request data
             $validator = Validator::make($request->all(), [
                 'dname' => 'required|string|max:255',
                 'driver_license_image' => 'required|image|max:2048', // Assuming it's an image file
                 'adname' => 'required|string|max:255',
                 'adaddress' => 'required|string|max:255',
                 'authorized_driver_license_image' => 'required|image|max:2048', // Assuming it's an image file
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
 
             // Process file upload
             if ($request->hasFile('driver_license_image')) {
                 $dlfile = $request->file('driver_license_image');
                 $dlfileName = time() . '.' . $dlfile->getClientOriginalExtension();
                 $dlfile->storeAs('public/images/drivers', $dlfileName); //php artisan storage:link
             } else {
                 throw new \Exception('Photo file is required.');
             }

            // Process file upload
            if ($request->hasFile('authorized_driver_license_image')) {
                $adlfile = $request->file('authorized_driver_license_image');
                $adlfileName = time() . '.' . $adlfile->getClientOriginalExtension();
                $adlfile->storeAs('public/images/drivers', $adlfileName); //php artisan storage:link
            } else {
                throw new \Exception('Photo file is required.');
            }
 
             // Create new applicant data with user_id
             $driverData = [
                 'user_id' => $user_id,
                 'driver_name' => $request->dname,
                 'driver_license_image' => $dlfileName,
                 'authorized_driver_license_image' => $adlfileName,
                 'authorized_driver_name' => $request->adname,
                 'authorized_driver_address' => $request->adaddress,
                 'approval_status' => $request->approval,
                 'reason' => $request->filled('reason') ? $request->reason : 'None / Approved', // Check if reason is empty
             ];
 
             // Create the applicant record
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
 
}

