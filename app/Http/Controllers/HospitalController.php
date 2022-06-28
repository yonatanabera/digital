<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\HospitalSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Hospital::all();
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
        $hospital = new hospital();
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'services' => 'required',
        ]);

        $filename = "";
        if ($request->hasFile('logo')) {
            $filename = $request->file('logo')->store('images', 'public');
        } else {
            $filename = Null;
        }

        $hospital->name = $request->name;
        $hospital->logo = $filename;
        $hospital->address = $request->address;
        $hospital->phone = $request->phone;
        $hospital->email = $request->email;
        $hospital->services = $request->services;
        $hospital->description = $request->description;
        $hospital->agent_id = $request->agent_id;
        $hospital->agent_name = $request->agent_name;


        $result = $hospital->save();


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
    public function show($id, $param)
    {
        $hospital = Hospital::where('id', $id)->with(['doctors' => function ($query) use ($param) {
            $query->where('speciality', 'like', '%' . $param . '%');
        }])->get()->toArray();
        $hospital2 = Hospital::where('id', $id)->with(['doctors' => function ($query) use ($param) {
            $query->where('speciality', 'not like', '%' . $param . '%');
        }])->get();

        $doctors = $hospital2[0]->doctors->toArray();
        $hospital[0]['doctors'] = array_merge($hospital[0]['doctors'], $doctors);

        return $hospital;
    }

    public function showHospital($id)
    {
        $hospital = Hospital::where('id', $id)->with('doctors')->get();
        return $hospital;
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

        $hospital = Hospital::findOrFail($id);

        $destination = public_path("images\\" . $hospital->logo);
        $filename = "";
        if ($request->hasFile('logo')) {
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $filename = $request->file('logo')->store('images', 'public');
        } else {
            $filename = $hospital->logo;
        }

        $request->name && $hospital->name = $request->name;
        $request->logo && $hospital->logo = $filename;
        $request->address && $hospital->address = $request->address;
        $request->phone && $hospital->phone = $request->phone;
        $request->email && $hospital->email = $request->email;
        $request->services && $hospital->services = $request->services;
        $hospital->description = $request->description;
        $hospital->agent_id = $request->agent_id;
        $hospital->agent_name = $request->agent_name;
        $result = $hospital->save();
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
        Hospital::destroy($id);
        return response()->json(['msg' => 'Hospital is deleted']);
    }

    /**
     * Find Doctors using the relationship
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doctors()
    {
        $doctor = Doctor::find(1)->with("hospitals");
        return $doctor;
    }

    public function pivot($hospital, $doctor)
    {
        return HospitalSchedule::where('hospital_id', $hospital)->where('doctor_id', $doctor)->first();
    }

    public function agentHospitals($id)
    {
        if (User::find($id)->role == User::IS_ADMIN) {
            return Hospital::all();
        } else if (User::find($id)->role == User::IS_AGENT) {
            return Hospital::where('agent_id', $id)->get();
        }
    }
}
