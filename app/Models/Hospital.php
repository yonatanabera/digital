<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'services',
        'address',
        'phone',
        'description',
        'user_id',
        'logo',
        'agent_id',
        'agent_name'
    ];

    protected $casts = [
        'services' => 'array'
    ];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_hospital')->withPivot('schedule', 'description');
    }
}
