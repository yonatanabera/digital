<?php

namespace App\Http\Controllers;

use App\Models\Diagnostic;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Medication;
use App\Models\Pharmacy;
use App\Models\Procedure;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index(){
        $doctors=[
            'number'=> Doctor::count(),
            'provider'=> "Doctors"
        ];

        $hospitals=[
            'number'=> Hospital::count(),
            'provider'=> "Hospitals"
        ];

        $diagnostics=[
            'number'=> Diagnostic::count(),
            'provider'=> "Diagnostic centers and Laboratories"
        ];

        $pharmacies=[
            'number'=> Pharmacy::count(),
            'provider'=> "Pharmacies"
        ];

        $medications=[
            'number'=> Medication::count(),
            'provider'=> "Medications"
        ];

        $procedures=[
            'number' => Procedure::count(),
            'provider' => "Laboratory Tests"
        ];

        $count=[];
        array_push($count, $doctors);
        array_push($count, $hospitals);
        array_push($count, $diagnostics);
        array_push($count, $pharmacies);
        array_push($count, $medications);
        array_push($count, $procedures);

        return $count;
       
    }

    public function providers(){
        $doctors=[
            'number'=> Doctor::count(),
            'provider'=> "Doctors"
        ];

        $hospitals=[
            'number'=> Hospital::count(),
            'provider'=> "Hospitals"
        ];

        $diagnostics=[
            'number'=> Diagnostic::count(),
            'provider'=> "Diagnostic centers and Laboratories"
        ];

        $pharmacies=[
            'number'=> Pharmacy::count(),
            'provider'=> "Pharmacies"
        ];

        $medications=[
            'number'=> Medication::count(),
            'provider'=> "Medications"
        ];

        $count=[];
        array_push($count, $doctors);
        array_push($count, $hospitals);
        array_push($count, $diagnostics);
        array_push($count, $pharmacies);
        array_push($count, $medications);

        return $count;
       
    }
}
