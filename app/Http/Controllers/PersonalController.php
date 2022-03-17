<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * Funcion que nos servira para realizar el listado 
     * del personal a evaluar
     */

    public function listarPersonalD4($destino4){
       
        $personal = DB::table('personal_destinos as pd')
            ->join('personals as p','pd.per_codigo','p.per_codigo')
            ->join('personal_escalafones as ep','p.per_codigo','ep.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as sp','p.per_codigo','sp.per_codigo')
            ->join('estudios as e','sp.est_cod','e.id')
            ->join('personal_cargos as pc','p.per_codigo','pc.per_codigo')
            ->join('cargos as c','pc.car_cod','c.id')
            ->select('p.per_codigo','p.per_paterno as paterno','p.per_materno as materno', 'p.per_nombre as nombre', 'g.abreviatura as grado', 'e.abreviatura as complemento','c.descripcion as cargo','g.orden','g.division')
            ->where('pd.d4_cod','=',$destino4)
            ->where('p.per_codigo','<>',Auth::user()->percod)//cambiar al dato del personal designado para la evaluacion
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
        return $personal;
    }

    /**
     * Funcion para listar a los evaluados de la tabla "jurado_personal"
     */
    public function juradoPersonal(Request $request){
        $id = $request->id;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == "") {
            $perjur = DB::table('jurado_personals as jp')
                ->join('personals as p','p.per_codigo', 'jp.idpersonal')
                ->select('p.per_codigo','p.per_nombre', 'p.per_paterno', 'p.per_materno','jp.id as jpid', 'jp.graCom','jp.cargo', 'jp.estado', 'jp.evaluacion')
                ->where('jp.idjurado',$id)
                ->paginate(10);
        } else {
            $perjur = DB::table('jurado_personal as jp')
                ->join('personal as p','p.per_codigo', 'jp.idpersonal')
                ->select('p.per_codigo','p.per_nombre', 'p.per_paterno', 'p.per_materno','jp.id as jpid', 'jp.graCom','jp.cargo', 'jp.estado', 'jp.evaluacion')
                ->where($criterio,'like','%'.$buscar.'%')
                ->where('jp.idjurado',$id)
                ->paginate(10);
        }
        
        
        
        return [
            'pagination' => [
                'total'         => $perjur->total(),
                'current_page'  => $perjur->currentPage(),
                'per_page'      => $perjur->perPage(),
                'last_page'     => $perjur->lastPage(),
                'from'          => $perjur->firstItem(),
                'to'            => $perjur->lastItem(),
            
            ],
            'perjur' => $perjur
        ];
    }

    /**
     * Funcion para acceder a los datos del evaluador
     */

    public function datosEvaluador(Request $request){
        $id = $request->id;
        $evaluador = DB::table('jurados as j')
                ->join('personals as p','p.per_codigo', 'j.per_cod')
                ->join('nivel3_destinos as d3','j.dest3','d3.id')
                ->select('p.per_codigo','p.per_nombre', 'p.per_paterno', 
                        'p.per_materno', 'j.graCom','j.cargo', 'j.estado', 
                        'j.evaluacion', 'd3.descripcion as de3')
                ->where('j.id',$id)
                ->first();
        
        return response()->json($evaluador);
    }

    /**
     * Funcion para acceder a los datos del evaluado
     */

    public function datosEvaluado(Request $request){
        
        $perCod = $request->perCod;
        $eva = $request->eva;
        $id = $request->id;
        $evaluado = DB::table('jurado_personals as jp')
                ->join('personals as p','p.per_codigo', 'jp.idpersonal')
                ->join('nivel4_destinos as d4','d4.id','jp.dest4')
                ->select('p.per_nombre', 'p.per_paterno', 'p.per_materno', 'jp.graCom','jp.cargo','d4.descripcion as d4','jp.division')
                ->where('jp.idpersonal',$perCod)
                ->where('jp.idjurado',$id)
                ->where('jp.evaluacion',$eva)
                ->first();

        return response()->json($evaluado);
    }

    //Lista personal de la unidad (DESTINO 3)
    public function listaPersonal(Request $request)
    {
        $destino = $request->destino;
        $personal = DB::table('personal_destinos as pd')
            ->join('personals as p','pd.per_codigo','p.per_codigo')
            ->join('personal_escalafones as ep','p.per_codigo','ep.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as sp','p.per_codigo','sp.per_codigo')
            ->join('estudios as e','sp.est_cod','e.id')
            ->join('personal_cargos as pc','p.per_codigo','pc.per_codigo')
            ->join('cargos as c','pc.car_cod','c.id')
            ->join('nivel4_destinos as d4','pd.d4_cod','d4.id')
            ->select('p.per_codigo','p.per_paterno as paterno','p.per_materno as materno', 'p.per_nombre as nombre', 'g.abreviatura as grado', 'e.abreviatura as complemento','c.descripcion as cargo','g.orden','g.division','d4.descripcion as destino','pd.d4_cod as id4')
            ->where('pd.d3_cod','=',$destino)
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
            ->paginate(10);

            return [
                'pagination' => [
                    'total'         => $personal->total(),
                    'current_page'  => $personal->currentPage(),
                    'per_page'      => $personal->perPage(),
                    'last_page'     => $personal->lastPage(),
                    'from'          => $personal->firstItem(),
                    'to'            => $personal->lastItem(),
                
                ],
                'personal' => $personal
            ];
    }

    /***************FUNCIONES PARA ACCESO DE SISTEMA********************* */
    /**
     * FUNCION PARA LISTAR PERSONAL EN UN SELECT-VUE
     */
    public function ListPersonal()
    {

        $datos = DB::table('personal_destinos as pd')
            ->join('personals as p','pd.per_codigo','p.per_codigo')
            ->join('personal_escalafones as ep','p.per_codigo','ep.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as sp','p.per_codigo','sp.per_codigo')
            ->join('estudios as e','sp.est_cod','e.id')
            ->join('personal_cargos as pc','p.per_codigo','pc.per_codigo')
            ->join('cargos as c','pc.car_cod','c.id')
            ->join('personal_situaciones as ps', 'p.per_codigo','ps.per_codigo')
            ->select('p.per_codigo as codigo','p.per_paterno as paterno','p.per_materno as materno', 'p.per_nombre as nombre', 'g.abreviatura as grado', 'e.abreviatura as complemento')
            ->where('pd.estado','=',1)
            ->where('ep.estado','=',1)
            ->where('sp.estado','=',1)
            ->where('pc.estado','=',1)
            ->where('ps.estado',1)
            ->whereIn('ps.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
            ->where('pc.flag','=',1)
            ->where('pc.nivel_cargo','=',1)
            ->orderBy('ep.esca_cod')
            ->orderBy('ep.subesc_cod')
            ->orderBy('g.orden')
            ->orderBy('p.per_cm')
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

    /**
     * MUESTRA LOS DATOS PERSONAL DE UNA PERSONA
     */
    public function DatosPersonalesAcceso(Request $request)
    {
        $percodigo = $request->percodigo;
        $datos = DB::table('personal_escalafones as ep')
            ->join('personals as p','ep.per_codigo','p.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
            ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
            ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
            ->join('nivel3_destinos as nd3','pd.d3_cod','nd3.id')
            ->join('nivel2_destinos as nd2','pd.d2_cod','nd2.id')
            ->select('p.per_codigo as percodigo','p.per_foto as foto','p.per_nombre as nombre','p.per_paterno as paterno','p.per_materno as materno','p.per_cm as cm',
                        'p.per_ci as ci', 'p.per_expedido as expedido', 'p.per_mail as email','g.abreviatura as grado','e.abreviatura as complemento',
                        'ss.nombre as situacion','nd2.descripcion as des2','nd3.descripcion as des3')
            ->where('ep.per_codigo',$percodigo)
            ->where('ps.estado',1)
            ->where('ep.estado',1)
            ->where('epe.estado',1)
            ->where('pd.estado',1)
            ->first();

            return response()->json($datos);
    }

    public function ListaPerExt(Request $request)
    {

        $destino2 = $request->dest2;
        $personal = DB::table('personal_destinos as pd')
            ->join('personals as p','pd.per_codigo','p.per_codigo')
            ->join('personal_escalafones as ep','p.per_codigo','ep.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as sp','p.per_codigo','sp.per_codigo')
            ->join('estudios as e','sp.est_cod','e.id')
            ->join('personal_cargos as pc','p.per_codigo','pc.per_codigo')
            ->join('cargos as c','pc.car_cod','c.id')
            ->join('personal_situaciones as ps', 'p.per_codigo','ps.per_codigo')
            ->select('p.per_codigo','p.per_paterno as paterno','p.per_materno as materno', 'p.per_nombre as nombre', 'g.abreviatura as grado', 'e.abreviatura as complemento','c.descripcion as cargo','g.orden')
            ->where('pd.d2_cod','<>',$destino2)
            ->where('pd.estado','=',1)
            ->where('ep.estado','=',1)
            ->where('sp.estado','=',1)
            ->where('pc.estado','=',1)
            ->where('ps.estado',1)
            ->whereIn('ps.detsit_cod',[1,2,4,5,8,9,11,13,14,16,17,29,30,31,32,33])
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
}
