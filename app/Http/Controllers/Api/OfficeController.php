<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;

class OfficeController extends Controller
{
    // get offices of a district office
    public function getByDistrictOffice($district_office_id){
        $offices = Office::where('district_office_id', $district_office_id)->get();
        return response()->json($offices);
    }

    // insert a office
    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'district_office_id'=>'required|integer'
        ]);

        $office = Office::create([
            'name' => $request->name,
            'district_office_id' => $request->district_office_id
        ]);

        return response()->json([
            'message'=> 'Office created successfully',
            'data' => $office
        ]);
    }

    public function index(){
        return Office::select('id', 'name')->orderBy('id')->get();
    }
}
