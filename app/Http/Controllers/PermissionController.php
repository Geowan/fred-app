<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(RolePermission::where('role_id', $request->get('role_id'))
            ->paginate($request->get("perPage")));
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
            'role_id'=>'required',
            'permission_id'=>'required',
        ]);
       return RolePermission::create($request->all());
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
            'role_id'=>'required',
            'permission_id'=>'required',
        ]);
        return RolePermission::where('id', $request->input("id"))
            ->update($request->all());
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

        return RolePermission::where('id', $request->input("id"))->delete();
    }

    public function unallocatedPermissions(){
        return response()->json(
            Permission::get()
        );
    }
}
