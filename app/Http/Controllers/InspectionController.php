<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionController extends Controller
{

    public function index(Request $request){
        return response()->json(Inspection::paginate($request->input("perPage")));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $details = $request->input("details");
        $checklists = $request->input("checklist");
        $inspection = Inspection::create([
            "driver_id"=>Auth::user()->id,
            "reg_no"=>$details["reg_no"],
            "checklist_category"=>$details["checklist_category"],
            "raw_data"=>json_encode($request->all()),
            "status"=>1
        ]);

        if ($inspection){

        }
    }
}
