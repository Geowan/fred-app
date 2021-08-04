<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicles;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request  $request)
    {
        return response()->json(Vehicles::paginate($request->get("perPage")));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       return Vehicles::create($request->all());
    }






    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $role = Vehicles::where('id', $request->input("id"))->first();
        if ($role){
            $role->name = $request->input("name");
            $role->update();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        return  Vehicles::where('id', $request->input("id"))->delete();
    }

    public function formData(){
        return response()->json([
            "users"=>User::get()
        ]);
    }
}
