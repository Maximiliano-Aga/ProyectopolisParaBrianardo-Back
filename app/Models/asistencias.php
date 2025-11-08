<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class asistencias extends Model
{
  protected $primaryKey = 'idAsist';
  protected $fillable = [
    'asisFecha',
    'asisJustificada',
    'idEstadoAsist',
    'idInscripcion'
  ];
}
