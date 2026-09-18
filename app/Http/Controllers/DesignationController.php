<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    public function index(){
        return Designation::select('id', 'name')->orderBy('id')->get();
    }
}
