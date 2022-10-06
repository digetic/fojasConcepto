<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinosController extends Controller
{
    public function Destinos2(Request $request)
    {
        $dest1 = $request->dest1;
        $dest2 = DB::connection('pgsql2')->table('nivel2_destinos')
            ->select('id','descripcion')
            ->where('d1_cod',$dest1)
            ->where('estado',1)
            ->orderBy('descripcion')
            ->get();
        
        return response()->json($dest2);
    }
    
    public function Destinos3(Request $request)
    {
        $dest2 = $request->dest2;
        $dest3 = DB::connection('pgsql2')->table('nivel3_destinos')
            ->select('id','descripcion')
            ->where('d2_cod',$dest2)
            ->where('estado',1)
            ->orderBy('descripcion')
            ->get();
        
        return response()->json($dest3);
    }

    //  NOMBRE DE UNIDAD DESTINO 3
    public function NombreUnidad(Request $request)
    {
        $nomUnidad = DB::connection('pgsql2')->table('nivel3_destinos')
            ->select('descripcion')
            ->where('id',$request->id)
            ->first();
        
            return response()->json($nomUnidad);
    }
}
