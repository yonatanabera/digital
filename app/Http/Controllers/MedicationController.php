<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\medication_pharmacy;
use App\Models\User;
use Illuminate\Http\Request;

class medicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Medication::all();
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
        // return $request->all();
        $request->validate([
            'name' => 'required',
        ]);
        Medication::create($request->all());
        return response()->json(['msg' => 'Medication is Created']);
    }

    public function createAndAdd(Request $request, $pharmacy)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $medication = Medication::create($request->all());
        medication_pharmacy::create([
            'medication_id' => $medication->id,
            'pharmacy_id' => $pharmacy,
            'agent_id' => $request->agent_id,
            'agent_name' => $request->agent_name,
        ]);
        return response()->json(['msg' => 'Medication is Created and Added to your List']);
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
        return Medication::findorfail($id);
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
        $medication = Medication::findorfail($id);
        $medication->update($request->all());
        return response()->json(['msg' => 'Medication is updated']);
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
        Medication::destroy($id);
        return response()->json(['msg' => 'Medication is updated']);
    }
    public function pharmacies()
    {
        $medication = Medication::find(1);
        foreach ($medication->pharmacies as $pharmacy) {
            return $pharmacy;
        }
    }

    public function medWithAgent()
    {
        return Medication::where('name', 'like', '%a%')->with('user')->get();
    }

    public function agentMedications($id)
    {
        if (User::find($id)->role == User::IS_ADMIN) {
            return Medication::all();
        } else if (User::find($id)->role == User::IS_AGENT) {
            return Medication::where('agent_id', $id)->get();
        }
    }
}
