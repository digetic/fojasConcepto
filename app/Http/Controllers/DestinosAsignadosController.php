<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinosAsignadosController extends Controller
{
    public function ListaUnidadesDesignadas(Request $request)
    {
        if ($request->buscar == '') {
            $secciones = DB::table('jurados as j')
                ->join('nivel1_destinos as d1','j.dest1','d1.id')
                ->join('nivel2_destinos as d2','j.dest2','d2.id')
                ->join('nivel3_destinos as d3','j.dest3','d3.id')
                ->join('nivel4_destinos as d4','j.dest4','d4.id')
                ->select('d1.descripcion as d1','d2.descripcion as d2','d3.descripcion as d3','d4.descripcion as d4','j.evaluacion','j.dest4','j.dest3','j.dest2','j.dest1','d2.prioridad','d4.orden','d3.prioridad','d3.d2_cod')
                ->where('j.evaluacion',$request->eva)
                ->groupBy('d1.descripcion')
                ->groupBy('d2.descripcion')
                ->groupBy('d3.descripcion')
                ->groupBy('d4.descripcion')
                ->groupBy('j.dest1')
                ->groupBy('j.dest2')
                ->groupBy('j.dest3')
                ->groupBy('j.dest4')
                ->groupBy('j.evaluacion')
                ->groupBy('d1.id')
                ->groupBy('d4.orden')
                ->groupBy('d4.d3_cod')
                ->groupBy('d2.prioridad')
                ->groupBy('d2.id')
                ->groupBy('d3.prioridad')
                ->groupBy('d3.d2_cod')
                ->orderBy('d1.id')
                ->orderBy('d2.prioridad')
                ->orderBy('d2.id')
                ->orderBy('d3.prioridad')
                ->orderBy('d3.d2_cod')
                ->orderBy('d4.orden')
                ->orderBy('d4.d3_cod')
                ->paginate(10);
        } else {
            $secciones = DB::table('jurados as j')
                ->join('nivel1_destinos as d1','j.dest1','d1.id')
                ->join('nivel2_destinos as d2','j.dest2','d2.id')
                ->join('nivel3_destinos as d3','j.dest3','d3.id')
                ->join('nivel4_destinos as d4','j.dest4','d4.id')
                ->select('d1.descripcion as d1','d2.descripcion as d2','d3.descripcion as d3','d4.descripcion as d4','j.evaluacion','j.dest4','j.dest3','j.dest2','j.dest1','d2.prioridad','d4.orden','d3.prioridad','d3.d2_cod')
                ->where('j.evaluacion',$request->eva)
                ->where($request->criterio,'like', '%'.$request->buscar.'%')
                ->groupBy('d1.descripcion')
                ->groupBy('d2.descripcion')
                ->groupBy('d3.descripcion')
                ->groupBy('d4.descripcion')
                ->groupBy('j.dest1')
                ->groupBy('j.dest2')
                ->groupBy('j.dest3')
                ->groupBy('j.dest4')
                ->groupBy('j.evaluacion')
                ->groupBy('d1.id')
                ->groupBy('d4.orden')
                ->groupBy('d4.d3_cod')
                ->groupBy('d2.prioridad')
                ->groupBy('d2.id')
                ->groupBy('d3.prioridad')
                ->groupBy('d3.d2_cod')
                ->orderBy('d1.id')
                ->orderBy('d2.prioridad')
                ->orderBy('d2.id')
                ->orderBy('d3.prioridad')
                ->orderBy('d3.d2_cod')
                ->orderBy('d4.orden')
                ->orderBy('d4.d3_cod')
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


    public function JuradosAsignados(Request $request)
    {
        $d4 = $request->d4;
        $eva = $request->eva;
        $jurado = DB::table('jurados as j')
            ->join('personals as p','j.per_cod','p.per_codigo')
            ->select('p.per_codigo','p.per_nombre','p.per_materno','p.per_paterno','j.graCom','j.cargo')
            ->where('j.dest4',$d4)
            ->where('j.evaluacion',$eva)
            ->where('j.estado','<=',2)
            ->orderBy('j.orden')
            ->get();    
        return response()->json($jurado);
    }
}
