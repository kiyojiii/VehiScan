<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Datatables;

class AppointmentController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Appointment::select('*'))
            ->addColumn('action', 'appointments.appointment-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('appointments.index');
    }

    // public function create()
    // {
    //     $appointments = Appointment::all();
    //     return view('appointments.create', compact('appointments'));
    // }

    public function store(Request $request)
    {  
  
        $appointmentId = $request->id;
  
        $appointment   =   Appointment::updateOrCreate(
                    [
                     'id' => $appointmentId
                    ],
                    [
                    'appointment' => $request->appointment, 
                    ]);    
                          
        return Response()->json($appointment);
    }

    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $appointment  = Appointment::where($where)->first();
       
        return Response()->json($appointment);
    }

    public function destroy(Request $request)
    {
        $appointment = Appointment::where('id',$request->id)->delete();
       
        return Response()->json($appointment);
    }
 
}
