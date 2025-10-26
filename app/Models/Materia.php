<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materia extends Model
{
    protected $fillable=["matNombre", "carrera_id"]; 
    
    public function carrera():BelongsTo{
        return $this->belongsTo(Carrera::class,"carrera_id");
    }
    
 //
}
