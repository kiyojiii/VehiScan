<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Vehicle;

class QRCodeController extends Controller
{
    public function download(Request $request)
    {
        // Retrieve the vehicle code from the request
        $vehicleCode = $request->input('qrData');
    
        // Query the vehicle using the vehicle code
        $vehicle = Vehicle::where('vehicle_code', $vehicleCode)->first();
    
        // Check if the vehicle with the given code exists
        if ($vehicle) {
            // Generate QR code for the vehicle code
            $qrcode = QrCode::format('png')->size(200)->errorCorrection('H')->generate($vehicleCode);
    
            // Set the file name for the downloaded file as plate_number + qr code .png
            $fileName = $vehicle->plate_number . '_' . $vehicleCode . '.png';
    
            // Store the generated QR code in storage
            $storagePath = 'public/images/qrcodes/';
            Storage::put($storagePath . $fileName, $qrcode);

            // Set the response headers
            $headers = [
                'Content-Type' => 'image/png',
            ];
    
            // Return the response with the generated QR code file for download
            return response()->download(storage_path('app/' . $storagePath . $fileName), $fileName, $headers)->deleteFileAfterSend();
        } else {
            // If the vehicle with the given code does not exist, return a response with a 404 status code
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
    }

    public function getPlateNumber(Request $request)
    {
        $vehicleCode = $request->input('qrData');
        $vehicle = Vehicle::where('vehicle_code', $vehicleCode)->first();
        if ($vehicle) {
            return response()->json(['plateNumber' => $vehicle->plate_number]);
        } else {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
    }
}
