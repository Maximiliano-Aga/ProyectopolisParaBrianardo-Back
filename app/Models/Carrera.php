<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrera extends Model
{
    protected $fillable=["carNombre"];//

    public function materias():HasMany{
        return $this->hasMany(Materia::class,"carrera_id");
    }
}
