<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
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
        'agent_id',
        'agent_name'
    ];

    protected $casts = [
        'services' => 'array'
    ];


    public function procedures()
    {
        return $this->belongsToMany(Procedure::class, 'diagnostics_procedures', 'diagnostics_id', 'procedures_id')->withPivot('schedule', 'description');
    }
}
