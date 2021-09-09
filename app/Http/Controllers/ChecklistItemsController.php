<?php

namespace App\Http\Controllers;

use App\Models\ChecklistCategory;
use App\Models\ChecklistItems;
use Illuminate\Http\Request;

class ChecklistItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->validate($request, [ 'perPage' => 'required', 'page' => 'required', 'category_id' => 'required']);
        return response()->json(ChecklistItems::where('category_id', $request->get("category_id"))->paginate($request->get("perPage")));

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'mandatory' => 'required',
            'name' => 'required',
            "is_header"=>'required'
        ]);
        return ChecklistItems::create($request->all());
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'mandatory' => 'required',
            'name' => 'required',
            "is_header"=>'required',
            'id' => 'required'
        ]);
        return ChecklistItems::where('id', $request->input("id"))
            ->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        return ChecklistItems::where('id', $request->input("id"))->delete();
    }
}
