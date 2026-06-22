<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Grade;

class GradeController extends Controller
{
    public function index(){
        return Grade::select('id', 'name')->get();
    }
}
