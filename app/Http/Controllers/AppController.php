<?php


namespace App\Http\Controllers;


use App\Models\ChecklistCategory;
use App\Models\ChecklistItems;
use App\Models\Vehicles;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function app_data(){
        return response()->json([
            "checkist_category"=>ChecklistCategory::all(),
            "checklists"=>ChecklistItems::all(),
            "vehicles"=>Vehicles::where('user_id',Auth::user()->id)->get(),
        ]);
    }

}
