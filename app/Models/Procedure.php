<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'agent_id',
        'agent_name',
    ];

    public function diagnostics()
    {
        return $this->belongsToMany(Diagnostic::class, 'diagnostics_procedures', 'procedures_id', 'diagnostics_id')->withPivot('schedule', 'description');
    }
}
