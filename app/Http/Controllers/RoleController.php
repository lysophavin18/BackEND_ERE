<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Illuminate\Http\Request;
class RoleController extends Controller
{
    //fucntion Views All Role 
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'status' => true,
            'data' => $roles
        ]);
    }
    //function Views Role by id 
    public function getbyid($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not Founds!'
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $role
        ]);
    }
    public function create(Request $request)
    {

        $validatiorRole = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validatiorRole->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatiorRole->errors(),
                'error' => $validatiorRole->errors()
            ], 401);

        }
        $role = Role::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Role ceate successfullt'
        ], 200);



    }
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not Found!'
            ], 404);
        }
        $validatiorRole = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validatiorRole->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatiorRole->errors(),
            ], 401);
        }
        $role->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Update Successfully',
            'data' => $role
        ], 200);

    }
    public function delete($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not Found'
            ], 404);
        }
        $role->delete();
        return response()->json([
            'status' => true,
            'message' => 'Role was Deleted'
        ], 200);
    }
}