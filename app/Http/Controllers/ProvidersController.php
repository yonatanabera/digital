<?php

namespace App\Http\Controllers;

use App\Models\Diagnostic;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Medication;
use App\Models\Pharmacy;
use App\Models\Procedure;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    //
    public function index(){
        $all=[];
        $all['doctors']=Doctor::all();
        $all['diagnostics']=Diagnostic::all();
        $all['hospitals']=Hospital::all();
        $all['pharmacies']=Pharmacy::all();
        $all['procedures']=Procedure::all();
        $all['medications']=Medication::all();
        return $all;
    }
}
