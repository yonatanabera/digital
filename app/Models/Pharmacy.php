<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'opening',
        'closing',
        'email',
        'address',
        'phone',
        'user_id',
        'agent_id',
        'agent_name',
    ];

    public function medications()
    {
        return $this->belongsToMany(Medication::class, 'medication_pharmacies')->withPivot('agent_name', 'agent_id');
    }
}
