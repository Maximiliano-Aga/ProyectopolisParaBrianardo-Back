<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class asistencias extends Model
{
  protected $primaryKey = 'idAsist';
  protected $fillable = [
    'asisFecha',
    'asisJustificada',
    'estadoAsistencia',
    'idInscripcion'
  ];

  public function inscripcion(): BelongsTo {
    return $this->belongsTo(Inscripcion::class, 'idInscripcion', 'idInscripciones');
  }
}
