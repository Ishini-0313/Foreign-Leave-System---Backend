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

    public function getMinistries(){
        return Office::select('id', 'name')->where('type', 'Ministry')->orderBy('name')->get();
    }

    // get departments,district offices and offices(not ministries)
    public function getDept_distOffices_offices(){
        return Office::select('id', 'name')->where('type', '!=', 'Ministry')->orderBy('name')->get();
    }

    //get child offices under a ministry
    public function get_sub_office_by_ministry(Request $request){
        return Office::select('id', 'name')->where('parent_office_id', $request->parent_office_id)->get();
    }

    // get office by id
    public function getOfficeById(Request $request){
        return Office::select('name')->where('id', $request->id)->first();
    }
}
