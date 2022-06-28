<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalSchedule extends Model
{
    use HasFactory;
    protected $table = "doctor_hospital";

    protected $fillable = [
        'doctor_id',
        'hospital_id',
        'schedule',
        'description',
        'agent_id',
        'agent_name'
    ];

    protected $casts = [
        'schedule' => AsArrayObject::class,
    ];
}
