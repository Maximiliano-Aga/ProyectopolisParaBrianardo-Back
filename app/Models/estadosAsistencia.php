<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class estadosAsistencia extends Model
{
    use HasFactory;
    protected $primaryKey = 'idEstados_Asist';
    protected $table = 'estados_asistencias';
    protected $fillable = [
        'valor',
        'estado',
    ];

public function asistencias():HasMany{
    return $this->hasMany(asistencias::class);}
}

