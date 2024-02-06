<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;
use Datatables;

class ViolationController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Violation::select('*'))
                ->addColumn('action', 'violations.violation-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(True);
        }
        return view('violations.index');
    }

    public function store(Request $request)
    {  
  
        $violationId = $request->id;
  
        $violation   =   Violation::updateOrCreate(
                    [
                     'id' => $violationId
                    ],
                    [
                    'violation' => $request->violation, 
                    ]);    
                          
        return Response()->json($violation);
    }

    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $violation  = Violation::where($where)->first();
       
        return Response()->json($violation);
    }

    public function destroy(Request $request)
    {
        $violation = Violation::where('id',$request->id)->delete();
       
        return Response()->json($violation);
    }
}
