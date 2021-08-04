<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $fillable =["driver_id","reg_no","checklist_category","raw_data","status"];

    protected $appends = ["driver","category"];
    protected $dateFormat = 'Y-m-d';


    public function getDriverAttribute(){
        $driver = User::where('id',$this->driver_id)->first();
        return $driver?$driver->full_name:'';
    }

    public function getCreatedAtAttribute($value)
    {
        return date("Y-m-d h:i:s", strtotime($value));
    }

    public function getCategoryAttribute(){
        $driver = ChecklistCategory::where('id',$this->checklist_category)->first();
        return $driver?$driver->name:'';
    }

}
