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

                    $datos = Http::withHeaders([
                                'token' => '$2a$10$KjELHfB0eP.Jq4bKwAi52OGe2/jA8OCIbtD31TQd5FZtPHs2PHGAK'
                                ])->post(Config::get('nomServidor.web').'/api/datosPersonales',[
                                    'percodigo' => $e['id']
                                ]);
                    $nick = $e['id'];
                    $user = User::create([
                        'percod' => $e['id'],
                        'nick' => $nick,
                        'email' => $datos['email'],
                        // 'password' => Hash::make($randomString),
                        'password' => Hash::make('12345678'),
                        'tipo' => 2
                    ]);
                    $user->assignRole('CALIFICADOR');
                    // Mail::to($datos->email)
                    // ->send(new CrearJurador($datos, $randomString));
                }
            }
            DB::commit();
            foreach ($secciones as $s) {
               Http::withHeaders([
                    'token' => '$2a$10$R1GqvPTF6aRmn4yO3/lSk.k7uy3pG5kmSLdbIzN2BXm.8NVyUZk9q'
                    ])->post(Config::get('nomServidor.web').'/api/destDesginado',[
                        'id' => $s
                    ]);
            }
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
        
        // // $per = new PersonalController();
        // // $person = $per->listarPersonalD4($destino4);
        
        $dato = Http::withHeaders([
            'token' => '$2a$10$R1GqvPTF6aRmn4yO3/lSk.k7uy3pG5kmSLdbIzN2BXm.8NVyUZk9q'
            ])->post(Config::get('nomServidor.web').'/api/permenran',[
                'percod' => Auth::user()->percod,
                'dest4' => $destino4
            ]);
        $data = [];
        foreach (json_decode($dato->getBody()->getContents()) as $key => $value) {
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
}
