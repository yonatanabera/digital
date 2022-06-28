<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(){
        return ContactUs::all();
    }

    public function store(Request $request){
        $validated=$request->validate([
            'name'=>'required',
            'email'=>'required|email|',
            'message'=>'required'
        ]);
        return ContactUs::create($validated);

    }
}
