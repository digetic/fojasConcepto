<?php

namespace App\Http\Controllers;

use App\Evaluacion;
use App\FechaEvaluacion;
use App\Periodo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvaluacionController extends Controller
{
    public function ultimaEvaluacion(){
 
        $evaluacion = Periodo::all()
            ->where('estado','<>',0)
            -> last(); // Busca el periodo de la ultima evaluacion -> Tabala: Periodo
        
        $año = Carbon::now()->format('Y'); // Metodo Carbon que nos permite obtener fechas -> Obtenemos el año actual
        if (!(is_null($evaluacion))) { // Verificamos si la solicitud esta vacia
            
            return response()->json([
                'ano' => $evaluacion->ano,
                'periodo' => $evaluacion->periodo,
                'evaincio' => $evaluacion->inicio,
                'evafinal' => $evaluacion->fin,
                'estado' => $evaluacion->estado
            ]);
            

        }else{
            return response()->json([
                'ano' => $año,
                'periodo' => 0,
                'evafinal' => '',
                'estado' => 0
            ]);
        }
        
    }

    public function GuardarEvaluacion(Request $request)
    {
        $periodo = Periodo::create([
            'inicio' => $request->get('pinicio'),
            'fin' => $request->get('pfinal'),
            'estado' => 1,
            'periodo' => $request->get('semestre'),
            'ano' => $request->get('ano'),
            'sysuser' => 'ADMIN'
        ]);

        $fechaEvaluacion = FechaEvaluacion::create([
            'idperiodo' => $periodo->id,
            'inicio' => $request->get('einicio'),
            'final' => $request->get('efinal'),
            'estado' => 1,
            'sysuser' => 'ADMIN'
        ]);

        $evaluaciones = Evaluacion::create([
            'idperiodo' => $periodo->id,
            'idfechaEvaluacion' => $fechaEvaluacion->id,
            'estado' => 1,
            'sysuser' => 'ADMIN'
        ]);
        return response()->json($request);
    }

    public function ListarEvaluaciones(Request $request)
    {
        if ($request->buscar == 'ANUAL') {
            $buscar = 3;
        }else{
            $buscar = $request->buscar;
        }

        if ($request->buscar == '') {
            $evaluaciones = DB::table('evaluaciones as e')
                ->join('periodos as p','e.idperiodo','p.id')
                ->join('fecha_evaluaciones as fe','e.idfechaEvaluacion','fe.id')
                ->select('e.id','p.inicio as pinicio', 'p.fin as pfin', 'fe.inicio as einicio','fe.final as efinal', 'e.estado', 'p.periodo', 'p.ano', 'e.idperiodo', 'e.idfechaEvaluacion')
                ->orderBy('e.id', 'desc')
                ->where('e.estado','<>',0)
                ->paginate(10);
        }else{
            $evaluaciones = DB::table('evaluaciones as e')
                ->join('periodos as p','e.idperiodo','p.id')
                ->join('fecha_evaluaciones as fe','e.idfechaEvaluacion','fe.id')
                ->select('e.id','p.inicio as pinicio', 'p.fin as pfin', 'fe.inicio as einicio','fe.final as efinal', 'e.estado', 'p.periodo', 'p.ano', 'e.idperiodo','e.idfechaEvaluacion')
                ->where($request->criterio,'like','%'.$buscar.'%')
                ->where('e.estado','<>',0)
                ->orderBy('id','desc')
                ->paginate(10);
        }

        return [
            'pagination' => [
                'total'         => $evaluaciones->total(),
                'current_page'  => $evaluaciones->currentPage(),
                'per_page'      => $evaluaciones->perPage(),
                'last_page'     => $evaluaciones->lastPage(),
                'from'          => $evaluaciones->firstItem(),
                'to'            => $evaluaciones->lastItem(),
            
            ],
            'evaluaciones' => $evaluaciones
        ];
    }


    public function ListEva()
    {
        $evaluaciones = DB::table('evaluaciones as e')
                ->join('periodos as p','e.idperiodo','p.id')
                ->join('fecha_evaluaciones as fe','e.idfechaEvaluacion','fe.id')
                ->select('e.id','p.inicio as pinicio', 'p.fin as pfin', 'fe.inicio as einicio','fe.final as efinal', 'e.estado', 'p.periodo', 'p.ano', 'e.idperiodo', 'e.idfechaEvaluacion')
                ->orderBy('e.id', 'desc')
                ->where('e.estado','<>',0)
                ->get();
        $data = [];

        foreach ($evaluaciones as $key => $value) {
            switch ($value->periodo) {
                case 1:
                    $tipo = '1º Semestre';
                    break;
                case 2:
                    $tipo = '2º Semestre';
                    break;
                case 3:
                    $tipo = 'anual';
                    break;
            }
            
            
            $data[$key] = [
                'text' => $value->ano.' - '.$tipo,
                'eva' => $value->id
            ];
        }
        
        return response()->json($data);
    }

    public function FechaEvaluacion(Request $request)
    {
        $fecha = DB::table('fecha_evaluaciones as fe')
            ->select('fe.inicio as einicio','fe.final as efinal')
            ->where('fe.id','=',$request->id)
            ->first();
        
        return response()->json($fecha);
    }

    public function EditarFechaEval(Request $request)
    {
        FechaEvaluacion::find($request->id)
        ->update([
            'inicio' => $request->einicio,
            'final' => $request->efinal
        ]);  
        
        return $request;
    }

    public function EliminarEvaluacion(Request $request)
    {
        $eval = Evaluacion::find($request->id);
        $idp = $eval->idperiodo;
        $idf = $eval->idfechaEvaluacion;
        $per = Periodo::find($idp);
        $fec = FechaEvaluacion::find($idf);
        $eval->update([
            'estado' => 0
        ]);        

        $per->update([
            'estado' => 0
        ]);

        $fec->update([
            'estado' => 0
        ]);
    }

    public function FinalizarEvaluacion(Request $request)
    {
        $eval = Evaluacion::find($request->id);
        $idp = $eval->idperiodo;
        $idf = $eval->idfechaEvaluacion;
        $per = Periodo::find($idp);
        $fec = FechaEvaluacion::find($idf);
        $eval->update([
            'estado' => 2
        ]);        

        $per->update([
            'estado' => 2
        ]);

        $fec->update([
            'estado' => 2
        ]);
    }

    /**
     * Funciones para la vista principal de evaluacion de fojas
     */
    //Muestra datos de la evaluacion actual programado para un usuario
    public function EvaluacionDesignada()
    {
        $evaluacion = DB::table('evaluaciones as e')
            ->join('fecha_evaluaciones as fe','e.idfechaEvaluacion','fe.id')
            ->join('periodos as p','e.idperiodo','p.id')
            ->select('e.id as evaluacion', 'fe.inicio', 'fe.final', 'p.periodo', 'p.ano')
            ->where('e.estado',1)
            ->first();

        if ($evaluacion != "") {
            $res = DB::table('jurados')
                ->where('evaluacion', $evaluacion->evaluacion)
                ->where('per_cod',Auth::user()->percod)//cambiar al dato del personal designado para la evaluacion
                ->where('estado','<',3)
                ->exists();
            if ($res == 1) {
                return response()->json([
                    'evaluacion' => $evaluacion,
                    'code' => 200
                ]);
            }else{
                return response()->json([
                    'code' => 401
                ]);
            }
        } else {
            return response()->json([
                    'code' => 401
                ]);
        }
        return $evaluacion;
    }

     /**
     * Funcion que devuelve una lista de los destinos a ser evaluados, los cuales 
     * fueron asignados
     */
    public function listarDesignacionUsuario(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $evaluacion = $request->eva;

        if ($buscar == "") {
            $secciones = DB::table('jurados as j')
                ->join('evaluaciones as e', 'j.evaluacion','e.id')
                ->join('nivel1_destinos as d1','j.dest1','d1.id')
                ->join('nivel2_destinos as d2','j.dest2','d2.id')
                ->join('nivel3_destinos as d3','j.dest3','d3.id')
                ->join('nivel4_destinos as d4','j.dest4','d4.id')
                ->select('j.id','d2.descripcion as d2','d3.descripcion as d3',
                        'd4.descripcion as d4','d4.id as d4c', 
                        'j.evaluacion as eva', 'j.estado')
                ->where('j.per_cod',Auth::user()->percod)//cambiar al dato del personal designado para la evaluacion
                ->where('j.evaluacion',$evaluacion)
                ->where('e.estado','>',0)
                ->where('j.estado','<',3)
                ->paginate(10);
        } else {
            $secciones = DB::table('jurados as j')
                ->join('evaluaciones as e', 'j.evaluacion','e.id')
                ->join('nivel1_destinos as d1','j.dest1','d1.id')
                ->join('nivel2_destinos as d2','j.dest2','d2.id')
                ->join('nivel3_destinos as d3','j.dest3','d3.id')
                ->join('nivel4_destinos as d4','j.dest4','d4.id')
                ->select('j.id','d2.descripcion as d2','d3.descripcion as d3',
                        'd4.descripcion as d4','d4.id as d4c', 
                        'j.evaluacion as eva', 'j.estado')
                ->where($criterio,'like','%'.$buscar.'%')
                ->where('j.per_cod',Auth::user()->percod)//cambiar al dato del personal designado para la evaluacion
                ->where('j.evaluacion',$evaluacion)
                ->where('e.estado','>',0)
                ->where('j.estado','<',3)
                ->paginate(10);
        }
        
        return [
            'pagination' => [
                'total'         => $secciones->total(),
                'current_page'  => $secciones->currentPage(),
                'per_page'      => $secciones->perPage(),
                'last_page'     => $secciones->lastPage(),
                'from'          => $secciones->firstItem(),
                'to'            => $secciones->lastItem(),
            
            ],
            'secciones' => $secciones
        ];
    }

    //FUNCION QUE RETORNA LA ULTIMA EVALUACION ACTIVA 
    public function EvaluacionActual()
    {
        $evaluacion = DB::table('evaluaciones')
            ->where('estado',1)
            ->first();
        
        if (!empty($evaluacion)) {
            return $evaluacion->id;
        } else {
            return 0;
        }
        

        
    }
    /**
     * Funcion cuentas evaluaciones faltan evaluar
     */
    public function NumEvaluacionNoTerminadas($id, $eva)
    {
        $personal = DB::table('jurado_personals')
            ->where('idpersonal',$id)
            ->where('evaluacion',$eva)
            ->where('estado',1)
            ->count();
            
        return $personal;
    }
    /**
     * Funcion cuentas evaluaciones faltan evaluar
     */
    public function NumEvaluacionesTerminadas($id, $eva)
    {
        $personal = DB::table('jurado_personals')
            ->where('idpersonal',$id)
            ->where('evaluacion',$eva)
            ->where('estado',0)
            ->count();
        return $personal;
    }

    public function EvaluacionActiva()
    {
        $data = DB::table('evaluaciones')
                ->where('estado',1)
                ->exists();
        
        return response()->json($data);
    }
}
