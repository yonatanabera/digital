<?php

namespace App\Http\Controllers;

use App\Models\Diagnostic;
use App\Models\Doctor;
use App\Models\Procedure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DiagnosticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Diagnostic::all();
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
        $diagnostic = new Diagnostic();
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

        $diagnostic->name = $request->name;
        $diagnostic->logo = $filename;
        $diagnostic->address = $request->address;
        $diagnostic->phone = $request->phone;
        $diagnostic->email = $request->email;
        $diagnostic->services = $request->services;
        $diagnostic->description = $request->description;
        $diagnostic->agent_id = $request->agent_id;
        $diagnostic->agent_name = $request->agent_name;


        $result = $diagnostic->save();


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
        $diagnostic = Diagnostic::where('id', $id)->with('procedures')->get();
        return $diagnostic;
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

        $diagnostic = Diagnostic::findorfail($id);

        $destination = public_path("images\\" . $diagnostic->logo);
        $filename = "";
        if ($request->hasFile('logo')) {
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $filename = $request->file('logo')->store('images', 'public');
        } else {
            $filename = $diagnostic->logo;
        }

        $request->name && $diagnostic->name = $request->name;
        $request->logo && $diagnostic->logo = $filename;
        $request->address && $diagnostic->address = $request->address;
        $request->phone && $diagnostic->phone = $request->phone;
        $request->email && $diagnostic->email = $request->email;
        $request->services && $diagnostic->services = $request->services;
        $request->description && $diagnostic->description = $request->description;
        $diagnostic->agent_name = $request->agent_name;
        $diagnostic->agent_id = $request->agent_id;

        $result = $diagnostic->save();


        return $result;
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
        Diagnostic::destroy($id);
        return response()->json(['msg' => 'Diagnostic is deleted']);
    }

    /**
     * Find Procedures using the relationship
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function procedures()
    {
        $procedure = Procedure::find(1)->with("diagnostics");
        return $procedure;
    }

    public function agentDiagnostics($id)
    {
        if (User::find($id)->role == User::IS_ADMIN) {
            return Diagnostic::all();
        } else if (User::find($id)->role == User::IS_AGENT) {
            return Diagnostic::where('agent_id', $id)->get();
        }
    }
}
