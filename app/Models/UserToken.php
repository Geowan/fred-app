<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserToken extends Model
{
    //
    protected $fillable = ["user_id","token","valid_upto"];

    public static function generateToken($user_id){
        $token = sha1(time());
        UserToken::where('user_id', $user_id)->delete();
        UserToken::create([
            "user_id"=>$user_id,
            "token"=>$token,
            "valid_upto"=>Carbon::now()->addHours(24)->format("Y-m-d h:i:s")
        ]);
        return $token;
    }
}
