<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatosCurricularesControlller extends Controller
{
    public function __construct()
    {
        $this->middleware('authSis');
    }
    /**
     * Lista faltas disciplinarias de una persona de un año especifico
     */
    
    public function ListarSanciones(Request $request){
        
        $sanciones = DB::connection('pgsql2')->table('personal_faltas as pf')
            ->join('nivel1_faltas as f1','pf.f1_cod','f1.id')
            ->join('nivel2_faltas as f2','pf.f2_cod','f2.id' )
            ->join('sanciones as s','pf.san_cod','s.id')
            ->select('pf.id','pf.per_codigo','pf.ndoc','pf.documento','pf.dias','pf.fecha_sancion as fecha','f1.descripcion as falta1', 'f2.descripcion as falta2','s.descripcion as sancion')
            ->where('pf.per_codigo',$request->id)
            ->whereYear('pf.fecha_sancion',  $request->date)
            ->get();
        
        return response()->json($sanciones);
    }

    /**
     * Lista designaciones de una persona de un año especifico
     */
    public function ListarDesignaciones(Request $request){
        
        $designaciones = DB::connection('pgsql2')->table('personal_designaciones')
            ->select('id','fecha', 'nro_doc as ndoc', 'documento as doc','descripcion as desc')
            ->where('per_codigo',$request->id)
            ->whereYear('fecha', $request->date)
            ->orderBy('id')
            ->orderBy('fecha')
            ->get();
        
        return response()->json($designaciones);
    }
}
