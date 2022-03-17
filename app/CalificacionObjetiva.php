<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalificacionObjetiva extends Model
{
    protected $table = 'objetiva_calificaciones';

    protected $fillable = [
        'iddetalleObjetiva',
        'idjuradoPersonal',
        'nota'
    ];
}
