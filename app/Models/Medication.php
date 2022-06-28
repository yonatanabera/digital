<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
    'agent_id',
    'agent_name'
  ];

  public function pharmacies()
  {
    return $this->belongsToMany(Pharmacy::class, 'medication_pharmacies');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'agent_id');
  }
}
