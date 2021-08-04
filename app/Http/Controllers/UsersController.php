<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(User::paginate($request->get("perPage")));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'email'=>'required',
            'phone'=>'required',
            'full_name'=>'required',
            'password'=>'required',
        ]);

       $user =  User::create([
            "full_name"=>$request->input("full_name"),
            "email"=>$request->input("email"),
            "phone"=>$request->input("phone"),
            "password"=>Hash::make($request->input("password"))
        ]);


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
        $this->validate($request,[
            'id'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'full_name'=>'required',
            'password'=>'required',
        ]);

        User::where('id', $request->input("id"))->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return User::where('id', $request->input("id"))->delete();
    }

    public function formData(Request $request){
        return response()->json([
                "roles"=>Role::get()
            ]);
    }
}
