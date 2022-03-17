<?php

namespace App\Http\Controllers;

use App\Mail\CrearJurador;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Else_;

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
                        'dest1' => $dest1,
                        'dest2' => $dest2,
                        'dest3' => $dest3,
                        'dest4' => $s,
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
                    $datos = DB::table('personal_escalafones as ep')
                        ->join('personals as p','ep.per_codigo','p.per_codigo')
                        ->join('grados as g','ep.gra_cod','g.id')
                        ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
                        ->join('estudios as e','epe.est_cod','e.id')
                        ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
                        ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
                        ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
                        ->join('nivel3_destinos as nd3','pd.d3_cod','nd3.id')
                        ->join('nivel2_destinos as nd2','pd.d2_cod','nd2.id')
                        ->select('p.per_nombre','p.per_paterno as paterno','p.per_materno as materno', 'p.per_mail as email','g.abreviatura as grado','e.abreviatura as complemento','nd3.descripcion as destino')
                        ->where('ep.per_codigo',$e['id'])
                        ->where('ps.estado',1)
                        ->where('ep.estado',1)
                        ->where('epe.estado',1)
                        ->where('pd.estado',1)
                        ->first();
                    $nick = substr($request->nombre,0,1).substr($request->paterno,0,1).substr($request->materno,0,1).$e['id'];
                    $user = User::create([
                        'percod' => $e['id'],
                        'nick' => $nick,
                        'email' => $datos->email,
                        'password' => Hash::make($randomString),
                        'tipo' => 2
                    ]);
                    $user->assignRole('CALIFICADOR');
                    Mail::to($datos->email)
                    ->send(new CrearJurador($datos, $randomString));
                }
            }

            foreach ($secciones as $s) {
                DB::table('nivel4_destinos')
                  ->where('id', $s)
                  ->update(['asignado' => 1]);
            }
            DB::commit();return response()->json(['titulo' => 'Asignado', 'mensaje' => 'Los evaluadores fueron asignados correctamente.','tipo' => 'success']);
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
        
        $per = new PersonalController();
        $person = $per->listarPersonalD4($destino4);
        
        
        foreach ($person as $p) {
            DB::table('jurado_personals')->insert([
                    'idpersonal' => $p->per_codigo,
                    'idjurado' => $id,
                    'graCom' => $p->grado.' '.$p->complemento,
                    'division' => $p->division,
                    'cargo' => $p->cargo,
                    'dest4' => $destino4,
                    'evaluacion' => $evaluacion,
                    'estado' => 1,
                    'sysuser' => 'admin'
                ]);
        }

        DB::table('jurados')
            ->where('id',$id)
            ->update([
                'estado' => 2
            ]);
        return $person;
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
