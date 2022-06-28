<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class doctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Doctor::all();
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
        $doctor = new Doctor();
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'speciality' => 'required',
            'expertise' => 'required',

        ]);

        $filename = "";
        if ($request->hasFile('profilePicture')) {
            $filename = $request->file('profilePicture')->store('images', 'public');
        } else {
            $filename = Null;
        }

        $doctor->name = $request->name;
        $doctor->profilePicture = $filename;
        $doctor->address = $request->address;
        $doctor->speciality = $request->speciality;
        $doctor->expertise = $request->expertise;
        $doctor->description = $request->description;
        $doctor->agent_id = $request->agent_id;
        $doctor->agent_name = $request->agent_name;


        $result = $doctor->save();


        if ($result) {
            return $doctor;
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
        return Doctor::where("id", $id)->with('hospitals')->get();
    }
    public function name()
    {
        return Doctor::select('name')->distinct()->get();
    }

    public function speciality()
    {
        return Doctor::select('speciality')->distinct()->get();
    }
    public function expertise()
    {
        return Doctor::select('expertise')->distinct()->get();
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
        $doctor = Doctor::findorfail($id);

        $destination = public_path("images\\" . $doctor->logo);
        $filename = "";
        if ($request->hasFile('profilePicture')) {
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $filename = $request->file('profilePicture')->store('images', 'public');
        } else {
            $filename = $doctor->profilePicture;
        }

        $request->name && $doctor->name = $request->name;
        $request->profilePicture && $doctor->profilePicture = $filename;
        $request->address && $doctor->address = $request->address;
        $request->speciality && $doctor->speciality = $request->speciality;
        $request->expertise && $doctor->expertise = $request->expertise;
        $request->description && $doctor->description = $request->description;
        $doctor->agent_id = $request->agent_id;
        $doctor->agent_name = $request->agent_name;



        $result = $doctor->save();


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
        Doctor::destroy($id);
        return response()->json(['msg' => 'Doctor is deleted']);
    }
    public function search($condition)
    {
        //
    }

    public function hopitals()
    {
        $hospital = Hospital::find(1)->with("doctors");
        return $hospital;
    }

    public function agentDoctors($id)
    {
        if (User::find($id)->role == User::IS_ADMIN) {
            return Doctor::all();
        } else if (User::find($id)->role == User::IS_AGENT) {
            return Doctor::where('agent_id', $id)->get();
        }
    }
}
