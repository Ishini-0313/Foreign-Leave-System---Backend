<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Grade;

class GradeController extends Controller
{
    public function index(){
        return Grade::select('id', 'name')->get();
    }

    // get grade_or_class by id
    public function getClassById(Request $request){
        return Grade::select('name')->where('id', $request->id)->first();
    }
}
