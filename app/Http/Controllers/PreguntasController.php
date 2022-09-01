<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreguntasController extends Controller
{
    public function __construct()
    {
        $this->middleware('authSis');
    }
    
    public function preguntasObjetivas(Request $request){

        switch ($request->division) {
            case 1:
                $d = 1;
                break;
            case 2:
                $d = 1;
                break;
            case 3:
                $d = 1;
                break;
            case 4:
                $d = 2;
                break;
        }
        $preguntas = DB::table('pregunta_objetivas')
            ->select('id','detalle')
            ->whereIn('division',[0, $d])
            ->where('estado','=', 1)
            ->get();
        return response()->json($preguntas) ;
    }

    public function preguntasObjetivasImp($division){
        switch ($division) {
            case 1:
                $d = 1;
                break;
            case 2:
                $d = 1;
                break;
            case 3:
                $d = 1;
                break;
            case 4:
                $d = 2;
                break;
        }
        $preguntas = DB::table('pregunta_objetivas')
            ->select('id','detalle')
            ->whereIn('division',[0,$d])
            ->where('estado','=', 1)
            ->get();
        return response()->json($preguntas) ;
    }
}
