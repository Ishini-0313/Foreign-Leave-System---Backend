<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DistrictOffice;

class DistrictOfficeController extends Controller
{
    // get district offices belongs to a dept
    public function getByDept($dept_id){
        $district_offices = DistrictOffice::where('dept_id', $dept_id)->get();
        return response()->json($district_offices);
    }

    // insert a district office
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'dept_id' => 'required|integer'
        ]);

        $district_office = DistrictOffice::create([
            'name' => $request->name,
            'dept_id' => $request->dept_id
        ]);

        return response()->json([
            'message' => 'District Office created',
            'data' => $district_office
        ]);
    }
}
