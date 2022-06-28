<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class promotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Promotion::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'address'=>'required',
            'services'=>'required',
            'logo'=>'required',
            'image'=>'required',
            'description'=>'required',
            'status'=>'required|boolean'
            
        ]);
        Promotion::create($request->all());
        return response()->json(['msg'=>'Promotion is Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Promotion::findorfail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $promotion= Promotion::findorfail($id);
        $promotion->update($request->all());
        return response()->json(['msg'=>'Promotion is deleted']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Promotion::destroy($id);
        return response()->json(['msg'=>'Promotion is deleted']);
    }
}
