<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DeptController extends Controller
{
    //get departments of a ministry
    public function getByMinistry($min_id){
        $departments = Department::where('ministry_id', $min_id)->get();
        return response()->json($departments);
    }

    //add department
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'ministry_id' => 'required|integer'
        ]);

        $department = Department::create([
            'name' => $request->name,
            'ministry_id' => $request->ministry_id,
        ]);

        return response()->json([
            'message' => 'Department created',
            'data'=> $department
        ]);
    }
}
