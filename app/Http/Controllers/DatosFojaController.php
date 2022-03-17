<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatosFojaController extends Controller
{
    public function listarDesignaciones(Request $request){
        $id = $request->id;
        $date = DB::table('evaluaciones as e')
            ->join('periodos as p', 'e.idperiodo','p.id')
            ->select('p.ano')
            ->where('e.id',$request->e)
            ->first();
        $designaciones = DB::table('personal_designaciones')
            ->select('id','fecha', 'nro_doc as ndoc', 'documento as doc','descripcion as desc')
            ->where('per_codigo',$id)
            ->whereYear('fecha', $date->ano)
            ->orderBy('id')
            ->orderBy('fecha')
            ->get();
        
        return response()->json($designaciones);
    }
    
    public function listarSanciones(Request $request){
        $date = DB::table('evaluaciones as e')
            ->join('periodos as p', 'e.idperiodo','p.id')
            ->select('p.ano')
            ->where('e.id',$request->e)
            ->first();
        $id = $request->id;
        
        $sanciones = DB::table('personal_faltas as pf')
            ->join('nivel1_faltas as f1','pf.f1_cod','f1.id')
            ->join('nivel2_faltas as f2','pf.f2_cod','f2.id' )
            ->join('sanciones as s','pf.san_cod','s.id')
            ->select('pf.id','pf.per_codigo','pf.ndoc','pf.documento','pf.dias','pf.fecha_sancion as fecha','f1.descripcion as falta1', 'f2.descripcion as falta2','s.descripcion as sancion')
            ->where('pf.per_codigo',$id)
            ->whereYear('pf.fecha_sancion',  $date->ano)
            ->get();
        
        return response()->json($sanciones);
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
