<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuncionesGlobalesController extends Controller
{
    /**
     * FUNCIONES DATOS PERSONALES DEL PERSONAL DE LA FAB
     */
    public function DatosMinimos($percodigo)
    {
        $datos = DB::connection('pgsql2')->table('personal_escalafones as ep')
            ->join('personals as p','ep.per_codigo','p.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->select('p.per_codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','g.abreviatura as grado','e.abreviatura as complemento')
            ->where('ep.per_codigo',$percodigo)
            ->where('ep.estado',1)
            ->where('epe.estado',1)
            ->first();
        
            return $datos;
    }

    /**
     * MUESTRA LOS DATOS PERSONAL DE UNA PERSONA ->usuarios
     */
    public function DatosPersonales($percodigo)
    {
        $datos = DB::connection('pgsql2')->table('personal_escalafones as ep')
            ->join('personals as p','ep.per_codigo','p.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
            ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
            ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
            ->join('nivel3_destinos as nd3','pd.d3_cod','nd3.id')
            ->join('nivel2_destinos as nd2','pd.d2_cod','nd2.id')
            ->join('personal_especialidades as pesp', 'p.per_codigo', 'pesp.per_codigo')
            ->join('especialidades as esp', 'pesp.espe_cod','esp.id')
            ->join('subespecialidades as subesp', 'pesp.subespe_cod','subesp.id')
            ->select('p.per_codigo as percodigo','p.per_foto as foto','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm','p.per_ci as ci', 'p.per_expedido as expedido', 'p.per_mail as email','g.id as gid','g.abreviatura as grado','g.division','e.abreviatura as complemento','nd2.descripcion as des2','nd3.descripcion as des3','ss.nombre as situacion','p.per_sexo as sexo', 'esp.nombre as especialidad','subesp.nombre as subespecialidad')
            ->where('ep.per_codigo',$percodigo)
            ->where('ps.estado',1)
            ->where('ep.estado',1)
            ->where('epe.estado',1)
            ->where('pesp.estado',1)
            ->where('pd.estado',1)
            ->first();
        
            return $datos;
    }

}
