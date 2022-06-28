<?php

namespace App\Http\Controllers;

use App\Models\medication_pharmacy;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class pharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pharmacy::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request->all();
        $pharmacy = new pharmacy();
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'opening' => 'required',
            'closing' => 'required'
        ]);

        $filename = "";
        if ($request->hasFile('logo')) {
            $filename = $request->file('logo')->store('images', 'public');
        } else {
            $filename = Null;
        }

        $pharmacy->name = $request->name;
        $pharmacy->phone = $request->phone;
        $pharmacy->email = $request->email;
        $pharmacy->address = $request->address;
        $pharmacy->logo = $filename;
        $pharmacy->opening = $request->opening;
        $pharmacy->closing = $request->closing;
        $pharmacy->agent_id = $request->agent_id;
        $pharmacy->agent_name = $request->agent_name;


        $result = $pharmacy->save();


        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
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
        return Pharmacy::where('id', $id)->with('medications')->get();
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
        $pharmacy = pharmacy::findOrFail($id);

        $destination = public_path("images\\" . $pharmacy->logo);
        $filename = "";
        if ($request->hasFile('logo')) {
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $filename = $request->file('logo')->store('images', 'public');
        } else {
            $filename = $pharmacy->logo;
        }

        $request->name && $pharmacy->name = $request->name;
        $request->phone && $pharmacy->phone = $request->phone;
        $request->email && $pharmacy->email = $request->email;
        $request->address && $pharmacy->address = $request->address;
        $request->logo && $pharmacy->logo = $filename;
        $request->opening && $pharmacy->opening = $request->opening;
        $request->closing && $pharmacy->closing = $request->closing;
        $pharmacy->agent_id = $request->agent_id;
        $pharmacy->agent_name = $request->agent_name;

        $result = $pharmacy->save();


        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
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
        Pharmacy::destroy($id);
        return response()->json(['msg' => 'Provider is deleted']);
    }

    /**
     * Find medications related to this pharmacy
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function medication()
    {
        $pharmacy = Pharmacy::find(1)->with("medications");
        return $pharmacy;
    }

    public function addMedication(Request $request)
    {
        // return medication_pharmacy::where('pharmacy_id', $request->pharmacy_id)->where('medication_id', $request->medication_id)->count();
        if (!medication_pharmacy::where('pharmacy_id', $request->pharmacy_id)->where('medication_id', $request->medication_id)->count()) {
            medication_pharmacy::create($request->all());
        }
        return response()->json(['msg' => 'Medication added']);
    }

    public function removeMedication($pharmacy, $medication)
    {
        medication_pharmacy::where('pharmacy_id', $pharmacy)->where('medication_id', $medication)->delete();
        return response()->json(['msg' => 'Medication is deleted']);
    }

    public function agentPharmacies($id)
    {
        if (User::find($id)->role == User::IS_ADMIN) {
            return Pharmacy::all();
        } else if (User::find($id)->role == User::IS_AGENT) {
            return Pharmacy::where('agent_id', $id)->get();
        }
    }
}
