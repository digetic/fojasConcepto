<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PersonalController extends Controller
{
    public function ListaPersonalDesignacion(Request $request)
    {
        $destino1 = $request->destino1;
        $destino2 = $request->destino2;
        $destino3 = $request->destino3;
        $personal = DB::table('personal_destinos as pd')
            ->join('personals as p','pd.per_codigo','p.per_codigo')
            ->join('personal_escalafones as ep','p.per_codigo','ep.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as sp','p.per_codigo','sp.per_codigo')
            ->join('estudios as e','sp.est_cod','e.id')
            ->join('personal_cargos as pc','p.per_codigo','pc.per_codigo')
            ->join('cargos as c','pc.car_cod','c.id')
            ->select('p.per_codigo','p.per_paterno as paterno','p.per_materno as materno', 'p.per_nombre as nombre', 'g.abreviatura as grado', 'e.abreviatura as complemento','c.descripcion as cargo','g.orden')
            ->where('pd.d1_cod','=',$destino1)
            ->where('pd.d2_cod','=',$destino2)
            ->where('pd.d3_cod','=',$destino3)
            ->where('pd.estado','=',1)
            ->where('ep.estado','=',1)
            ->where('sp.estado','=',1)
            ->where('pc.estado','=',1)
            ->where('pc.flag','=',1)
            ->where('pc.nivel_cargo','=',1)
            ->orderBy('ep.esca_cod')
            ->orderBy('ep.subesc_cod')
            ->orderBy('g.orden')
            ->orderBy('p.per_cm')
            ->get();
        
            $data = [];

            foreach ($personal as $key => $value) {
                $data[$key] = [
                    'id' => $value->per_codigo,
                    'text' => $value->grado.' '.$value->complemento.' '.$value->paterno.' '.$value->materno.', '.$value->nombre.' - '.$value->cargo,
                    'orden' => $value->orden,
                    'gradCom' => $value->grado.' '.$value->complemento,
                    'cargo' => $value->cargo
                ];
            }

    
        return response()->json($data);  
    }

    /**
     * Funcion para listar a los evaluados de la tabla "jurado_personal"
     */
    public function juradoPersonal(Request $request){
        $id = $request->id;

        $perjur = DB::table('jurado_personals as jp')
                ->select('jp.id as jpid', 'jp.idpersonal as percod','jp.graCom','jp.cargo', 'jp.estado', 'jp.evaluacion')
                ->where('jp.idjurado',$id)
                ->get();
                
        $data = [];
        foreach ($perjur as $key => $value) {
            
            $dato = Http::withHeaders([
                'token' => '$2a$10$R1GqvPTF6aRmn4yO3/lSk.k7uy3pG5kmSLdbIzN2BXm.8NVyUZk9q'
                ])->post(Config::get('nomServidor.web').'/api/nomJud',[
                    'percodigo' => $value->percod
                ]);

            $data[$key] = [
                'nombre' => $value->graCom.' '.$dato['nombre'].' '.$dato['paterno'].' '.$dato['materno'],
                'jpid' => $value->jpid,
                'per_codigo' => $value->percod,
                'cargo' => $value->cargo,
                'estado' => $value->estado
            ];
        }
        
        
        return response()->json($data);
    }

    /**
     * Funcion para acceder a los datos del evaluador
     */

    public function datosEvaluador(Request $request){
        $id = $request->id;
        $evaluador = DB::table('jurados as j')
                ->select('j.graCom','j.cargo', 'j.estado','j.evaluacion','j.dest3','j.per_cod','j.destJur')
                ->where('j.id',$id)
                ->first();
        $dato = Http::withHeaders([
            'token' => '$2a$10$R1GqvPTF6aRmn4yO3/lSk.k7uy3pG5kmSLdbIzN2BXm.8NVyUZk9q'
            ])->post(Config::get('nomServidor.web').'/api/nomdestper3',[
                'percodigo' => $evaluador->per_cod,
                'd3' => $evaluador->destJur
            ]);
        $data = [
                'nombre' => $evaluador->graCom.' '.$dato['nombre'].' '.$dato['paterno'].' '.$dato['materno'],
                'd3' => $dato['dest3'],
                'cargo' => $evaluador->cargo
            ];
        return response()->json($data);
    }

    /**
     * Funcion para acceder a los datos del evaluado
     */

    public function datosEvaluado(Request $request){
        
        $perCod = $request->perCod;
        $eva = $request->eva;
        $id = $request->id;
        $evaluado = DB::table('jurado_personals as jp')
                ->select('jp.graCom','jp.cargo','jp.division','jp.idpersonal as perecod','jp.dest4')
                ->where('jp.idpersonal',$perCod)
                ->where('jp.idjurado',$id)
                ->where('jp.evaluacion',$eva)
                ->first();
        $dato = Http::withHeaders([
            'token' => '$2a$10$R1GqvPTF6aRmn4yO3/lSk.k7uy3pG5kmSLdbIzN2BXm.8NVyUZk9q'
            ])->post(Config::get('nomServidor.web').'/api/nomdestper4',[
                'percodigo' => $perCod,
                'd4' => $evaluado->dest4
            ]);
        $data = [
            'nombre' => $evaluado->graCom.' '.$dato['nombre'].' '.$dato['paterno'].' '.$dato['materno'],
            'division' => $evaluado->division,
            'd4' => $dato['dest4'],
            'cargo' => $evaluado->cargo
        ];

        return response()->json($data);
    }

    
}
