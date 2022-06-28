<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medication_pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacy_id',
        'medication_id',
        'agent_id',
        'agent_name',
    ];
}
