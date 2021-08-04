<?php


namespace App\Http\Controllers;

use App\Models\Inspection;
use Laravel\Lumen\Http\Request;

class ReportsController extends Controller
{
    public function summary(Request $request){
        $query = Inspection::query();
        $totalQuery = clone $query;
        $passedQuery = clone $query;
        $failedQuery = clone $query;

        return response()->json([
            "totals"=>$totalQuery->count(),
            "passed"=>$passedQuery->where(["status"=>1])->count(),
            "failed"=>$failedQuery->where(["status"=>2])->count(),
        ]);
    }

}
