<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinoController extends Controller
{
    public function Destinos1()
    {
        $dest1 = DB::table('nivel1_destinos')
            ->select('id','descripcion')
            ->where('estado',1)
            ->orderBy('descripcion')
            ->get();
        
        return response()->json($dest1);
    }

    public function Destinos2(Request $request)
    {
        $dest1 = $request->dest1;
        $dest2 = DB::table('nivel2_destinos')
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
        $dest3 = DB::table('nivel3_destinos')
            ->select('id','descripcion')
            ->where('d2_cod',$dest2)
            ->where('estado',1)
            ->orderBy('descripcion')
            ->get();
        
        return response()->json($dest3);
    }
    
    public function Destinos4(Request $request)
    {
        $dest3 = $request->dest3;
        $dest4 = DB::table('nivel4_destinos')
            ->select('id','descripcion')
            ->where('d3_cod',$dest3)
            ->where('estado',1)
            ->where('asignado',0)
            ->orderBy('descripcion')
            ->get();
        
        return response()->json($dest4);
    }

    public function dest3cal()
    {
        $destino = DB::table('personal_destinos')
         ->where('estado',1)
        ->where('per_codigo',354)
        ->first();

        $dest3 = DB::table('nivel3_destinos as n3')
            ->join('departamentos as d','n3.depa_cod','d.id')
            ->select('n3.id','n3.descripcion','d.nombre')
            ->where('n3.d2_cod',$destino->d2_cod)
            ->where('n3.estado',1)
            ->orderBy('n3.descripcion')
            ->get();
        return response()->json($dest3);
    }

    public function NombreUnidad(Request $request)
    {
        $nomUnidad = DB::table('nivel3_destinos')
            ->select('descripcion')
            ->where('id',$request->id)
            ->first();
        
            return response()->json($nomUnidad);
    }
}
