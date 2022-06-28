<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Models\HospitalSchedule;

class HospitalScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($hospital)
    {
        //
        $schedule = [];
        $pivot = HospitalSchedule::where('hospital_id', $hospital)->get();

        $count = 0;
        foreach ($pivot as $p) {
            $schedule[$p->doctor_id] = [$p->schedule, $p->agent_name];
        }

        return $schedule;
    }

    public function user_schedule($hospital)
    {
        $schedule = [];
        $pivot = HospitalSchedule::where('hospital_id', $hospital)->get();

        $count = 0;
        foreach ($pivot as $p) {
            $schedule[$p->doctor_id] = $p->schedule;
        }

        return $schedule;
    }

    public function doctors($doctors)
    {
        //
        $schedule = [];
        $pivot = HospitalSchedule::where('doctor_id', $doctors)->get();

        foreach ($pivot as $p) {
            $schedule[$p->hospital_id] = $p->schedule;
        }
        return $schedule;
    }

    public function admin_doctors($doctors)
    {
        //
        $schedule = [];
        $pivot = HospitalSchedule::where('doctor_id', $doctors)->get();

        foreach ($pivot as $p) {
            $schedule[$p->hospital_id] = [$p->schedule, $p->agent_name];
        }
        return $schedule;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'hospital_id' => 'required',
            'doctor_id' => 'required',
            'schedule' => 'required',
        ]);

        HospitalSchedule::create($request->all());
        return response()->json(['msg' => 'Hospital Schedule is Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hospital_schedule($hospital_id)
    {
        //
        return HospitalSchedule::findorfail($hospital_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $HospitalSchedule = HospitalSchedule::findorfail($id);
        $HospitalSchedule->update($request->all());
        return response()->json(['msg' => 'Hospital Schedule is updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($hospital, $doctor)
    {
        HospitalSchedule::where('hospital_id', $hospital)->where('doctor_id', $doctor)->delete();

        return response()->json(['msg' => 'Schedule Deleted']);
    }
}
