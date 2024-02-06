<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statuses;
use Datatables;

class StatusController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Statuses::select('*'))
            ->addColumn('action', 'status.status-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('status.index');
    }

    public function store(Request $request)
    {  
  
        $statusId = $request->id;
  
        $status   =   Statuses::updateOrCreate(
                    [
                     'id' => $statusId
                    ],
                    [
                    'applicant_role_status' => $request->applicant_role_status, 
                    ]);    
                          
        return Response()->json($status);
    }

    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $status  = Statuses::where($where)->first();
       
        return Response()->json($status);
    }

    public function destroy(Request $request)
    {
        $status = Statuses::where('id',$request->id)->delete();
       
        return Response()->json($status);
    }
}
