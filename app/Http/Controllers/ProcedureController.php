<?php

namespace App\Http\Controllers;

use App\Models\Diagnostic;
use App\Models\Procedure;
use App\Models\User;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Procedure::all();
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
            'name' => 'required',
        ]);
        return Procedure::create($request->all());
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
        return Procedure::findorfail($id);
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
        $Procedure = Procedure::findorfail($id);
        $Procedure->update($request->all());
        return response()->json(['msg' => 'Procedure is updated']);
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
        Procedure::destroy($id);
        return response()->json(['msg' => 'Procedure is updated']);
    }
    public function diagnostics()
    {
        $diagnostic = Diagnostic::find(1)->with("Procedures");
        return $diagnostic;
    }

    public function agentProcedures($id)
    {

        if (User::find($id)->role == User::IS_ADMIN) {
            return Procedure::all();
        } else if (User::find($id)->role == User::IS_AGENT) {
            return Procedure::where('agent_id', $id)->get();
        }
    }
}
