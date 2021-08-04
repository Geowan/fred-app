<?php

namespace App\Http\Controllers;

use App\Models\ChecklistCategory;
use Illuminate\Http\Request;

class ChecklistCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'perPage' => 'required',
            'page' => 'required',
        ]);
        return response()->json(ChecklistCategory::paginate($request->get("perPage")));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      ;
        $this->validate($request, [
            'name' => 'required',
            'duration' => 'required',
        ]);
       return ChecklistCategory::create($request->all());
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChecklistCategory  $checklistCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'duration' => 'required',
            'id' => 'required',
        ]);

       return ChecklistCategory::where('id', $request->input("id"))
            ->update(['name' => $request->input("name"),"duration"=>$request->input("duration")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChecklistCategory  $checklistCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

       return ChecklistCategory::where('id', $request->input("id"))->delete();
    }
}
