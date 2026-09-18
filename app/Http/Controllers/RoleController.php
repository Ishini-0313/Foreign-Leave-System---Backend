<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function getRoleById(Request $request){
        return Role::select('role_name')->where('id', $request->id)->first();
    }
}
