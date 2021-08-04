<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $failed_message = "Incorrect email and or password";
        $user = User::where('email',$request->post("email"))->first();
        if (!$user){
            abort(500,$failed_message);
        }
        if (!Hash::check($request->post("password"),$user->password)){
            abort(500,$failed_message);
        }

        return response()->json([
            "token"=>UserToken::generateToken($user->id)
        ]);
    }

    public function activeUser(){
        return Auth::user();
    }

    // kcr 023d 0-> jopeet

    public function register(Request  $request){
        $data = $request->input("form_data");

        $role = env('STUDENT_ROLE', 'student');
        if($request->post("option") === 1){
            $role = env('INSTITUTE_ROLE', 'student');
        }
        //allocate this role to user
        $user = User::create([
            "full_name"=>$data["name"],
            "email"=>$data["email"],
            "password"=>$data["password"],
            "extra_data"=>json_encode($data),
        ]);

        return response()->json([
            "token"=>$user?UserToken::generateToken($user->id):null
        ]);
    }
}
