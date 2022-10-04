<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('authSis');
    }
    
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


    /**
     * MUESTRA LOS DATOS PERSONAL DE UNA PERSONA ->usuarios
     */
    public function DatosPersonales(Request $request)
    {
        $percodigo = $request->percodigo;
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
        
            return response()->json($datos);
    }

    //Listador para combo
    public function ListarPersonal2()
    {
        $datos = DB::connection('pgsql2')->table('personal_escalafones as ep')
        ->join('personals as p','ep.per_codigo','p.per_codigo')
        ->join('grados as g','ep.gra_cod','g.id')
        ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
        ->join('estudios as e','epe.est_cod','e.id')
        ->join('personal_situaciones as ps', 'p.per_codigo','ps.per_codigo')
        ->select('p.per_codigo as codigo','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno', 'g.abreviatura as grado','e.abreviatura as complemento')
        ->where('ep.estado',1)
        ->where('epe.estado',1)
        ->where('ps.estado',1)
        ->whereIn('ps.detsit_cod',[1,2,4,5,29,30,31,32,33])
        ->where('g.fuerza','FAB')
        ->orderBy('ep.esca_cod')  
        ->orderBy('ep.subesc_cod')        
        ->orderBy('g.orden')
        ->get();

        $data = [];

        foreach ($datos as $key => $value) {
            $data[$key] = [
                'id' => $value->codigo,
                'text' => $value->grado.' '.$value->complemento.' '.$value->nombre.' '.$value->paterno.' '.$value->materno,
            ];
        }

        return response()->json($data);

    }
    
}
