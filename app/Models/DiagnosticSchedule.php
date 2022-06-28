<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosticSchedule extends Model
{
    use HasFactory;
    protected $table = "diagnostics_procedures";
    protected $fillable = [
        'diagnostics_id',
        'procedures_id',
        'schedule',
        'description',
        'agent_id',
        'agent_name'
    ];

    protected $casts = [
        'schedule' => AsArrayObject::class,
    ];
}
