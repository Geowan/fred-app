<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistItems extends Model
{
    //
    protected $fillable = ["name","category_id","fails_marked","mandatory","is_header"];
}
