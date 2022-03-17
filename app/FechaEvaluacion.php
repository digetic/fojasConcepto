<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechaEvaluacion extends Model
{
    protected $table = 'fecha_evaluaciones';

    protected $fillable = [
        'idperiodo',
        'inicio',
        'final',
        'estado',
        'sysuser'
    ];
}
