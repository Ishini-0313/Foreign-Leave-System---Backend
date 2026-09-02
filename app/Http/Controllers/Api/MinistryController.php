<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ministry;

class MinistryController extends Controller
{
    // get all ministries
    public function index(){
        return response()->json(
            Ministry::all()
        );
    }

    // add new ministry
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $ministry = Ministry::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Ministry Created',
            'data' => $ministry
        ], 201);
    }
}
