<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class TestimonialController extends Controller
{
    public function index(){
        return Testimonial::all();
    }
    
    public function show($id){
        return Testimonial::findOrFail($id);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'testimony' => 'required'
        ]);

        $filename="";
        if($request->hasFile('image')){
            $filename=$request->file('image')->store('images','public');
        }else{
            $filename=Null;
        }

        $testimonial = Testimonial::create([
            'name' => $request->name,
            'testimony' => $request->testimony,
            'title' => $request->title,
            'image' => $filename,
        ]);

        if($testimonial){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }

    public function update(Request $request, $id){

        $testimonial=Testimonial::findOrFail($id);
            
        $destination=public_path("images\\".$testimonial->logo);
        $filename="";
        if($request->hasFile('image')){
            if(File::exists($destination)){
                File::delete($destination);
            }

        $filename=$request->file('image')->store('images','public');

        }else{
            $filename=$testimonial->image;
        }

        $request->name && $testimonial->name= $request->name; 
        $request->testimony && $testimonial->testimony= $request->testimony; 
        $request->title && $testimonial->title= $request->title; 
        $request->image && $testimonial->image= $filename;
        $result = $testimonial->save();
        
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }

    }


    public function delete($id){
        $testimonial=Testimonial::findOrFail($id);
        $destination=public_path("images\\".$testimonial->logo);
        if(File::exists($destination)){
            File::delete($destination);
        }
        $testimonial->delete();
        return response()->json(['msg'=>'Testimonial is deleted']);

    }
}
