<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalificacionConceptual extends Model
{
    protected $table = 'conceptual_calificaciones';

    protected $fillable = [
        'idjuradoPersonal',
        'literal',
        'numerica'
    ];
}
