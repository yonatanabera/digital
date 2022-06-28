<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'expertise',
        'speciality',
        'address',
        'description',
        'profilePicture',
        'coverImage',
        'agent_id',
        'agent_name',

    ];


    protected $casts = [
        'expertise' => 'array'
    ];



    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'doctor_hospital')->withPivot('schedule', 'description');
    }
}
