<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class PartnerController extends Controller
{
    public function index(){
        return Partner::all();
    }
    
    public function show($id){
        return Partner::findOrFail($id);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'logo' => 'required'
        ]);

        $filename="";
        if($request->hasFile('logo')){
            $filename=$request->file('logo')->store('images','public');
        }else{
            $filename=Null;
        }

        $partners = Partner::create([
            'name' => $request->name,
            'logo' => $filename,
        ]);

        if($partners){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }

    public function update(Request $request, $id){

        $partner=Partner::findOrFail($id);
            
        $destination=public_path("images\\".$partner->logo);
        $filename="";
        if($request->hasFile('logo')){
            if(File::exists($destination)){
                File::delete($destination);
            }

        $filename=$request->file('logo')->store('images','public');

        }else{
            $filename=$partner->logo;
        }

        $request->name && $partner->name= $request->name; 
        $request->logo && $partner->logo= $filename;
        $result = $partner->save();
        
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }

    }


    public function delete($id){
        $partner=Partner::findOrFail($id);
        $destination=public_path($partner->logo);
        if(File::exists($destination)){
            File::delete($destination);
        }
        $partner->delete();
        return response()->json(['msg'=>'Partner is deleted']);

    }
}
