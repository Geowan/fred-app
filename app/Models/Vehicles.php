<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $fillable = ["user_id","reg_no"];
    protected $appends = ["user"];


    public function getUserAttribute(){
       $user =  User::where("id",$this->user_id)->first();
        return $user?$user->full_name:"";
    }

}
