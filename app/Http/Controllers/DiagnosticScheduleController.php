<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnostic;
use App\Models\DiagnosticSchedule;

class DiagnosticScheduleController extends Controller
{
    //
    public function index($diagnostic)
    {
        //
        $schedule = [];
        $pivot = DiagnosticSchedule::where('diagnostics_id', $diagnostic)->get();
        //    return $pivot;
        foreach ($pivot as $p) {
            $schedule[$p->procedures_id] = [$p->schedule, $p->agent_name];
        }
        return $schedule;
    }

    public function user_schedule($diagnostic)
    {
        //
        $schedule = [];
        $pivot = DiagnosticSchedule::where('diagnostics_id', $diagnostic)->get();
        //    return $pivot;
        foreach ($pivot as $p) {
            $schedule[$p->procedures_id] = $p->schedule;
        }
        return $schedule;
    }

    public function procedure_schedule($procedure)
    {
        //
        $schedule = [];
        $pivot = DiagnosticSchedule::where('procedures_id', $procedure)->get();

        foreach ($pivot as $p) {
            $schedule[$p->diagnostics_id] = $p->schedule;
        }
        return $schedule;
    }

    public function store(Request $request)
    {
        $request->validate([
            'diagnostics_id' => 'required',
            'procedures_id' => 'required',
            'schedule' => 'required',
        ]);
        DiagnosticSchedule::create($request->all());
        return response()->json(['msg' => 'Diagnostic Schedule is Created']);
    }

    public function diagnostic_schedule($diagnostic_id)
    {
        //
        return DiagnosticSchedule::findorfail($diagnostic_id);
    }

    public function destroy($diagnostics, $procedure)
    {
        DiagnosticSchedule::where('diagnostics_id', $diagnostics)->where('procedures_id', $procedure)->delete();

        return response()->json(['msg' => 'Schedule Deleted']);
    }

    public function pivot($diagnostics, $procedures)
    {
        // return ("Diagno ".$diagnostics." proce ".$procedures);

        return DiagnosticSchedule::where('diagnostics_id', $diagnostics)->where('procedures_id', $procedures)->first();
    }

    public function update(Request $request, $id)
    {
        $DiagnosticsSchedule = DiagnosticSchedule::findorfail($id);
        $DiagnosticsSchedule->update($request->all());
        return response()->json(['msg' => 'Diagnostics Schedule is updated']);
    }
}
