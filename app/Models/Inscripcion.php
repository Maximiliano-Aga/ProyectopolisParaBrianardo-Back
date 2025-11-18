<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';
    protected $primaryKey = 'idInscripciones';
    protected $fillable = [
        'cicloLectivo',
        'estadoInscrip',
        'idUsuario',
        'idMateria'
    ];

    /* Una inscripción pertenece a un usuario */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUsuario', 'id');
    }

    /* Una inscripción pertenece a una materia */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'idMateria', 'id');
    }
}
