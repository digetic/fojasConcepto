<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatosFojaController extends Controller
{
    public function __construct()
    {
        $this->middleware('authSis');
    }
    
    public function EvaluacionDatos(Request $request)
    {
        $data = DB::table('evaluaciones as e')
            ->join('periodos as p', 'e.idperiodo','p.id')
            ->join('fecha_evaluaciones as fe','e.idfechaEvaluacion','fe.id')
            ->select('p.ano','fe.final as evafinal','p.inicio','p.fin','p.periodo')
            ->where('e.id',$request->e)
            ->first();
        
        return response()->json($data);
    }
    /**
     * Funcion para las notas objetivas
     */

    public function notasObjetiva(Request $request)
    {
        $jpid = $request->jpid;
        $objetiva = DB::table('objetiva_calificaciones as co')
                ->join('pregunta_objetivas as dco', 'co.iddetalleObjetiva', 'dco.id')
                ->select('co.id', 'dco.detalle', 'co.nota')
                ->where('idjuradoPersonal',$jpid)
                ->orderBy('dco.id')
                ->get();
        
        $promedio = $objetiva->avg('nota');
                
        return response()->json([
            'objetiva' => $objetiva,
            'promedio' => $promedio
            ]);
        return $request;
    }

    /**
     * Funcion para la nota conceptual
     */
    public function notaConceptual(Request $request)
    {
        $jpid = $request->jpid;
        
        $concpetual = DB::table('conceptual_calificaciones')
                ->where('idjuradoPersonal',$jpid)
                ->first();
                
        return response()->json($concpetual);
    }
}
