<?php

namespace App\Http\Controllers;

use App\Mail\CrearJurador;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Else_;
use Illuminate\Support\Facades\Http;

class JuradoController extends Controller
{
    public function __construct()
    {
        $this->middleware('authSis');
    }
    
    public function GuardarJurados(Request $request)
    {
        $dest1 = $request->dest1;
        $dest2 = $request->dest2;
        $dest3 = $request->dest3;
        $eva = $request->eva;
        $evaluadores = $request->calificadores;
        $secciones = $request->seccion;
        try {
            DB::beginTransaction();
            foreach ($evaluadores as $e) {
                foreach ($secciones as $s) {
                    DB::table('jurados')->insert([
                        'per_cod' => $e['id'],
                        'graCom' => $e['gradCom'],
                        'cargo' => $e['cargo'],
                        'orden' => $e['orden'],
                        'promo'=> $e['promo'],
                        'dest1' => $dest1,
                        'dest2' => $dest2,
                        'dest3' => $dest3,
                        'dest4' => $s,
                        'destJur' => $e['d3'],
                        'evaluacion' => $eva,
                        'estado' => 1,
                        'sysuser' => 'sta'
                    ]);
                }
            }

            foreach ($evaluadores as $e) {
                $exist = User::where('percod',$e['id'])->exists();
                if ($exist) {
                    $val = User::where('percod',$e['id'])->select('tipo', 'estado','id')->first();
                    if ($val->estado == 1) {
                        if ($val->tipo == 1) {
                            User::where('percod',$e['id'])->update(['tipo' => 3]);
                            $val->assignRole('CALIFICADOR');
                        }
                    } else {
                        User::where('percod',$e['id'])->update(['tipo' => 2,'estado' => 1]);
                        $roles = $val->getRoleNames();
                        foreach ($roles as $r) {
                            $val->removeRole($r);
                        }
                        $val->assignRole('CALIFICADOR');
                    }
                       
                } else {
                    // Generador de Contraseña aleatoria
                    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i=0; $i < 10; $i++) {
                        $randomString .= $characters[rand(0,$charactersLength - 1)];
                    }
                    $func = new FuncionesGlobalesController();
                    $datos = $func->DatosPersonales($e['id']);
                    $nick = $e['id'];
                    $user = User::create([
                        'percod' => $e['id'],
                        'nick' => $nick,
                        'email' => $datos->email,
                        // 'password' => Hash::make($randomString),
                        'password' => Hash::make('12345678'),
                        'tipo' => 2
                    ]);
                    $user->assignRole('CALIFICADOR');
                    // Mail::to($datos['email'])
                    // ->send(new CrearJurador(json_decode($datos->getBody()->getContents()), $randomString));
                }
            }
            DB::commit();
            return response()->json(['titulo' => 'Asignado', 'mensaje' => 'Los evaluadores fueron asignados correctamente.','tipo' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['titulo' => 'Error', 'mensaje' => 'Ocurrio un error al momento del registro','tipo' => 'error']);
        }
    }

     

    /**
     * Funcion para asignar al jurado, el personal a evaluar, y el cambio de estado a en
     * en progreso en la vista
     */
    public function asignarJurados(Request $request){
        $destino4 = $request->dest4;
        $evaluacion = $request->eva;
        $id = $request->id;
        $func = new FuncionesGlobalesController();
        $dato = $func->PersonalMenorRango($destino4);
        $data = [];
        foreach ($dato as $key => $value) {
            $data[$key]= [
                'percod' => $value->per_codigo
            ];
            DB::table('jurado_personals')->insert([
                'idpersonal' => $value->per_codigo,
                'idjurado' => $id,
                'graCom' => $value->grado.' '.$value->complemento,
                'division' => $value->division,
                'cargo' => $value->cargo,
                'dest4' => $destino4,
                'evaluacion' => $evaluacion,
                'estado' => 1,
                'sysuser' => Auth::user()->percod
            ]);
                
        }
        

        DB::table('jurados')
            ->where('id',$id)
            ->update([
                'estado' => 2
            ]);
        return response()->json($data);
    }


    public function actEstado(Request $request)
    {
        $jurado = $request->jurado;
        $count = DB::table('jurado_personals')
            ->where('dest4',$request->destino)
            ->where('estado', 1)
            ->count();

        if($count == 0){
            DB::table('jurados')
            ->where('id',$jurado)
            ->update([
                'estado' => 0
            ]);
        }
        return $count;
    }

    /**
     * Lista de Unidades designadasa
     */

    public function ListarUnidadesAsignadas(Request $request)
    {
        $data = DB::table('jurados')
            ->select('dest4')
            ->where('evaluacion',$request->eva)
            ->groupBy(
                'dest4'
            )
            ->get();
        $datos = [];
        foreach ($data as $key => $value) {
            $datos[] = $value->dest4;
        }
            if ($request->buscar == '') {
                $destinos = DB::connection('pgsql2')->table('nivel1_destinos as n1')
                ->join('nivel2_destinos as n2','n1.id','n2.d1_cod')
                ->join('nivel3_destinos as n3','n2.id','n3.d2_cod')
                ->join('nivel4_destinos as n4','n3.id','n4.d3_cod')
                ->select('n1.descripcion as d1','n2.descripcion as d2','n3.descripcion as d3','n4.descripcion as d4','n4.id as id4')
                ->whereIn('n4.id',$datos)
                ->orderBy('n1.id')
                ->orderBy('n2.prioridad')
                ->orderBy('n2.id')
                ->orderBy('n3.prioridad')
                ->orderBy('n3.d2_cod')
                ->orderBy('n4.orden')
                ->orderBy('n4.d3_cod')
                ->paginate(15);
            } else {
                $destinos = DB::connection('pgsql2')->table('nivel1_destinos as n1')
                ->join('nivel2_destinos as n2','n1.id','n2.d1_cod')
                ->join('nivel3_destinos as n3','n2.id','n3.d2_cod')
                ->join('nivel4_destinos as n4','n3.id','n4.d3_cod')
                ->select('n1.descripcion as d1','n2.descripcion as d2','n3.descripcion as d3','n4.descripcion as d4','n4.id as id4')
                ->whereIn('n4.id',$datos)
                ->where($request->criterio,'like', '%'.$request->buscar.'%')
                ->orderBy('n1.id')
                ->orderBy('n2.prioridad')
                ->orderBy('n2.id')
                ->orderBy('n3.prioridad')
                ->orderBy('n3.d2_cod')
                ->orderBy('n4.orden')
                ->orderBy('n4.d3_cod')
                ->paginate(15);
            }

        
        
       
        
            return [
                'pagination' => [
                    'total'         => $destinos->total(),
                    'current_page'  => $destinos->currentPage(),
                    'per_page'      => $destinos->perPage(),
                    'last_page'     => $destinos->lastPage(),
                    'from'          => $destinos->firstItem(),
                    'to'            => $destinos->lastItem(),
                
                ],
                'destinos' => $destinos
            ];
    }


    /**
     * Lista de no Unidades designadas con evaluador
     */
    

    public function ListarUnidadesNoAsignadas(Request $request)
    {
        $data = DB::table('jurados')
            ->select('dest4')
            ->where('evaluacion',$request->eva)
            ->groupBy(
                'dest4'
            )
            ->get();
        $datos = [];
        foreach ($data as $key => $value) {
            $datos[] = $value->dest4;
        }

        $dest4 = DB::connection('pgsql2')->table('nivel4_destinos')
            ->select('id','descripcion')
            ->whereNotIn('id',$datos)
            ->where('d3_cod',$request->dest3)
            ->where('estado',1)
            ->orderBy('descripcion')
            ->get();


        return response()->json($dest4);
    }
}
