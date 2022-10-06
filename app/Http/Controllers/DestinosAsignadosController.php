<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DestinosAsignadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('authSis');
    }

    public function JuradosAsignados(Request $request)
    {
        $d4 = $request->d4;
        $eva = $request->eva;
        $jurado = DB::table('jurados as j')
            ->select('j.per_cod','j.graCom')
            ->where('j.dest4',$d4)
            ->where('j.evaluacion',$eva)
            ->where('j.estado','<=',2)
            ->orderBy('j.orden')
            ->get();
            
        $data = [];
        foreach ($jurado as $key => $value) {
            
            // $dato = Http::withHeaders([
            //     'token' => '$2a$10$R1GqvPTF6aRmn4yO3/lSk.k7uy3pG5kmSLdbIzN2BXm.8NVyUZk9q'
            //     ])->post(Config::get('nomServidor.web').'/api/nomJud',[
            //         'percodigo' => $value->per_cod
            //     ]);

            $func = new FuncionesGlobalesController();
            $dato = $func->DatosMinimos($value->per_cod); 

            $data[$key]['nombre'] = $value->graCom.' '.$dato->nombre.' '.$dato->paterno.' '.$dato->materno;
        }
        return response()->json($data);
    }
}
