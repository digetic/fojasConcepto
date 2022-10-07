<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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



    /**
     * DATOS DE DESTINOS
     */

    /**
     * Nombre de destinos que se encuentra una persona
     * parametros:
     *  d1 -> id destino 1
     *  d2 -> id destino 2
     *  d3 -> id destino 3
     *  d4 -> id destino 4
     * Devolucion:
     *  n1 -> nombre destino 1
     *  n2 -> nombre destino 2
     *  n3 -> nombre destino 3
     *  n4 -> nombre destino 4
     */

    public function NombreDestinoPersonal($d4)
    {
       $data = DB::connection('pgsql2')->table('nivel4_destinos as d4')
               ->join('nivel3_destinos as d3','d4.d3_cod','d3.id')
               ->join('nivel2_destinos as d2','d3.d2_cod','d2.id')
               ->join('nivel1_destinos as d1','d2.d1_cod','d1.id')
               ->select('d1.descripcion as n1','d2.descripcion as n2','d3.descripcion as n3','d4.descripcion as n4')
               ->where('d4.id',$d4)
               ->first();
       
       return $data;
    }


    /**
     * Lista de Personal de menor rango, se listara al personal con menro rango del destino actual
     * de la persona que definira el pedido
     * parametros:
     *  niv -> nivGra del grado de la persona que definira el rango
     *  dest4 -> id destino 4 
     *  per_codigo -> codigo de la persona que tendra 
     * devolucion
     *  array -> devolvera una array con los datos del personal de menor rango
     */

    public function PersonalMenorRango($dest4)
    {
        $divGra = DB::connection('pgsql2')->table('personal_escalafones as pe')
                    ->join('grados as g','pe.gra_cod','g.id')
                    ->select('g.divGra')
                    ->where('pe.per_codigo',Auth::user()->percod)
                    ->where('pe.estado',1)
                    ->first();
        $personal = DB::connection('pgsql2')->table('personal_destinos as pd')
            ->join('personals as p','pd.per_codigo','p.per_codigo')
            ->join('personal_escalafones as ep','p.per_codigo','ep.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as sp','p.per_codigo','sp.per_codigo')
            ->join('estudios as e','sp.est_cod','e.id')
            ->join('personal_cargos as pc','p.per_codigo','pc.per_codigo')
            ->join('cargos as c','pc.car_cod','c.id')            
            ->join('personal_situaciones as ps', 'p.per_codigo','ps.per_codigo')
            ->select('p.per_codigo','p.per_paterno as paterno','p.per_materno as materno', 'p.per_nombre as nombre', 'g.abreviatura as grado', 'e.abreviatura as complemento','c.descripcion as cargo','g.orden','g.division')
            ->where('pd.d4_cod','=',$dest4)
            ->where('p.per_codigo','<>',Auth::user()->percod)//cambiar al dato del personal designado para la evaluacion
            ->where('pd.estado','=',1)
            ->whereIn('ps.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
            ->where('ep.estado','=',1)   
            ->where('g.divGra','>=',$divGra->divGra)         
            ->where('ps.estado',1)
            ->where('sp.estado','=',1)
            ->where('pc.estado','=',1)
            ->where('pc.flag','=',1)
            ->where('pc.nivel_cargo','=',1)
            ->orderBy('ep.esca_cod')
            ->orderBy('ep.subesc_cod')
            ->orderBy('g.orden')
            ->orderBy('p.per_cm')
            ->get();
        return $personal;
    }


    /**
     * Devuelve datos minomos grado nombre apellidos y detino 3(nombre)
     * parametros:
     * d3 -> id destinos nivel 3
     * percodigo -> percodigo de la persona
     */
    public function DatosPersonalDestino3($d3, $percodigo)
    {
        $data = DB::connection('pgsql2')->table('personal_destinos as pd')
                    ->join('nivel3_destinos as n3','pd.d3_cod','n3.id')
                    ->join('personals as p','pd.per_codigo','p.per_codigo')
                    ->select('p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','n3.descripcion as dest3')
                    ->where('pd.d3_cod',$d3)
                    ->where('pd.per_codigo',$percodigo)
                    ->first();
        return $data;
    }

    /**
     * Devuelve datos minomos grado nombre apellidos y detino 4(nombre)
     * parametros:
     * d4 -> id destinos nivel 4
     * percodigo -> percodigo de la persona
     */
    public function DatosPersonalDestino4($d4, $percodigo)
    {
        $data = DB::connection('pgsql2')->table('personal_destinos as pd')
                    ->join('nivel4_destinos as n4','pd.d4_cod','n4.id')
                    ->join('nivel3_destinos as n3','n4.d3_cod','n3.id')
                    ->join('personals as p','pd.per_codigo','p.per_codigo')
                    ->join('personal_especialidades as pe','p.per_codigo','pe.per_codigo')
                    ->join('especialidades as e','pe.espe_cod','e.id')
                    ->join('subespecialidades as se','pe.subespe_cod','se.id')
                    ->select('p.per_foto as foto','p.per_cm as cm','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','n4.descripcion as dest4','n3.descripcion as destino','e.nombre as esp','se.nombre as subespe')
                    ->where('pd.d4_cod',$d4)
                    ->where('pd.per_codigo',$percodigo)
                    ->where('pe.estado',1)
                    ->first();
        return $data;
    }

}
