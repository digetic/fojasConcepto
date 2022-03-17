<?php

namespace App\Http\Controllers;

use App\Mail\CrearUsuario;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;

class UsuarioController extends Controller
{
    public function DatosUsuario()
    {
        $usuario = DB::table('users as u')
            ->join('personals as p','u.percod','p.per_codigo')
            ->join('personal_escalafones as pe','u.percod','pe.per_codigo')
            ->join('grados as g','pe.gra_cod','g.id')
            ->join('personal_estudios as epe','u.percod','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
            ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
            ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
            ->join('nivel3_destinos as nd3','pd.d3_cod','nd3.id')
            ->join('nivel2_destinos as nd2','pd.d2_cod','nd2.id')
            ->select('u.id','u.nick','u.estado','u.email','p.per_nombre as nombre','p.per_paterno as paterno',
                    'p.per_materno as materno','p.per_cm as cm','p.per_foto as foto',
                    'g.abreviatura as grado','e.abreviatura as complemento',
                    'p.per_cm as cm','p.per_ci as ci','p.per_expedido as expedido',
                    'ss.nombre as situacion','nd2.descripcion as des2','nd3.descripcion as des3')
            ->where('pe.estado',1)
            ->where('epe.estado',1)
            ->where('pd.estado',1)
            ->where('ps.estado',1)
            ->where('u.id',Auth::user()->id)
            ->first();
        
        return response()->json($usuario);
    }
    public function CrearUsuario(Request $request)
    {  
        // Generador de Contraseña aleatoria
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i=0; $i < 10; $i++) {
            $randomString .= $characters[rand(0,$charactersLength - 1)];
        }

        $verificacion = User::where('percod',$request->percodigo)->exists();
        if ($verificacion) {
            return response()->json(['code' => $verificacion, 'mensaje' => 'El usuario ya fue registrado.','tipo'=>'error']);
        } else {
            try {
                DB::beginTransaction();

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
                    ->where('ep.per_codigo', $request->percodigo)
                    ->where('ps.estado',1)
                    ->where('ep.estado',1)
                    ->where('epe.estado',1)
                    ->where('pd.estado',1)
                    ->first();
                $user = User::create([
                    'percod' => $request->percodigo,
                    'nick' => $request->nick,
                    'email' => $request->email,
                    'password' => Hash::make($randomString),
                    'tipo' => 1
                ]);
        
                $user->assignRole($request->rol);
                DB::commit();
                Mail::to($request->email)
                    ->send(new CrearUsuario($datos, $randomString));
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['code' => $verificacion, 'mensaje' => 'Ocurrio un error al momento de registra al usuario.','tipo' => 'error']);
            }
            return response()->json(['code' => $verificacion, 'mensaje' => 'Usuario creado correctamente.','tipo' => 'success']);
        }
        return response()->json($request);
    }
    public function ListarUsuarios(Request $request)
    {
        $buscar = $request->buscar;
        if ($buscar == '') {
            $usuarios = DB::table('users as u')
            ->join('personals as p','u.percod','p.per_codigo')
            ->join('personal_escalafones as pe','u.percod','pe.per_codigo')
            ->join('grados as g','pe.gra_cod','g.id')
            ->join('personal_estudios as epe','u.percod','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->select('u.id','u.nick','u.estado','p.per_nombre as nombre',
                    'p.per_paterno as paterno','p.per_materno as materno',
                    'p.per_cm as cm','g.abreviatura as grado',
                    'e.abreviatura as complemento',
                    )
            ->where('pe.estado',1)
            ->where('epe.estado',1)
            ->orderBy('u.id','desc')
            ->paginate(10);
        } else {
            $usuarios = DB::table('users as u')
            ->join('personals as p','u.percod','p.per_codigo')
            ->join('personal_escalafones as pe','u.percod','pe.per_codigo')
            ->join('grados as g','pe.gra_cod','g.id')
            ->join('personal_estudios as epe','u.percod','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->select('u.id','u.nick','u.estado','p.per_nombre as nombre','p.per_paterno as paterno',
                    'p.per_materno as materno','p.per_cm as cm','g.abreviatura as grado','e.abreviatura as complemento'
                    )
            ->where(function($q) use ($buscar){
                $q->where('p.per_paterno','LIKE','%'.$buscar.'%')
                ->orWhere('p.per_cm','LIKE','%'.$buscar.'%')
                ->orWhere('p.per_nombre','LIKE','%'.$buscar.'%')
                ->orWhere('p.per_materno','LIKE','%'.$buscar.'%');
            })
            ->where('pe.estado',1)
            ->where('epe.estado',1)
            ->orderBy('u.id','desc')
            ->paginate(10);
            
        }
        
        return response()->json([
            'pagination' => [
                'total'         => $usuarios->total(),
                'current_page'  => $usuarios->currentPage(),
                'per_page'      => $usuarios->perPage(),
                'last_page'     => $usuarios->lastPage(),
                'from'          => $usuarios->firstItem(),
                'to'            => $usuarios->lastItem(),
            
            ],
            'usuarios' => $usuarios
        ]);       
    }

    public function DatosUsuarios(Request $request)
    {
        $id = $request->id;
        $usuarios = DB::table('users as u')
            ->join('personals as p','u.percod','p.per_codigo')
            ->join('personal_escalafones as pe','u.percod','pe.per_codigo')
            ->join('grados as g','pe.gra_cod','g.id')
            ->join('personal_estudios as epe','u.percod','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
            ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
            ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
            ->join('nivel3_destinos as nd3','pd.d3_cod','nd3.id')
            ->join('nivel2_destinos as nd2','pd.d2_cod','nd2.id')
            ->select('u.id','u.nick','u.estado','p.per_nombre as nombre','p.per_paterno as paterno',
                    'p.per_materno as materno','p.per_cm as cm','p.per_foto as foto',
                    'g.abreviatura as grado','e.abreviatura as complemento',
                    'p.per_cm as cm','p.per_ci as ci','p.per_expedido as expedido',
                    'ss.nombre as situacion','nd2.descripcion as des2','nd3.descripcion as des3')
            ->where('pe.estado',1)
            ->where('epe.estado',1)
            ->where('pd.estado',1)
            ->where('u.id',$id)
            ->first();
        $rol = DB::table('model_has_roles as mr')
            ->join('roles as r','mr.role_id','r.id')
            ->select('r.id','r.name')
            ->where('mr.model_id',$id)
            ->first();
        return response()->json(['usuarios'=>$usuarios,'role'=>$rol]);
    }

    public function EditarUsuario(Request $request)
    {
        $id = $request->id;
        $password = $request->password;
        $user = User::find($id);

        if ($password != '') {
            DB::table('users')
            ->where('id',$id)
            ->update([
                'password' => Hash::make($password)
            ]);
        }
        
        return response()->json($request);
    }

    public function ListarPermisos(Request $request)
    {
        $user = User::find($request->id);
        $roles = $user->getAllPermissions();
        return response()->json($roles);
    }

    public function CambiarEstadoUsuario(Request $request)
    {
        $estado = 1 - $request->estado;
        $usuario = User::find($request->id);
        $usuario->estado = $estado;
        $usuario->save();

         return response()->json($estado);
    }

    /**
     * ACCEDE A LOS DATOS DEL USUARIO LOGUEADO
     */
    public function datosP()
    {
        $datos = DB::table('personal_escalafones as ep')
            ->join('personals as p','ep.per_codigo','p.per_codigo')
            ->join('grados as g','ep.gra_cod','g.id')
            ->join('personal_estudios as epe','p.per_codigo','epe.per_codigo')
            ->join('estudios as e','epe.est_cod','e.id')
            ->join('personal_situaciones as ps','p.per_codigo','ps.per_codigo')
            ->join('subsituaciones as ss','ps.subsit_cod','ss.id')
            ->join('personal_destinos as pd','p.per_codigo','pd.per_codigo')
            ->select('p.per_nombre as nombre','p.per_paterno as paterno','g.abreviatura as grado','e.abreviatura as complemento')
            ->where('ep.per_codigo',Auth::user()->percod)
            ->where('ps.estado',1)
            ->where('ep.estado',1)
            ->where('epe.estado',1)
            ->where('pd.estado',1)
            ->first();
        
            return response()->json($datos);
    }

    public function EditContrasena(Request $request)
    {
        $u = DB::table('users')
            ->select('password')
            ->where('id',Auth::user()->id)
            ->first();
        if (Hash::check($request->contrasenaA, $u->password)) {
            DB::table('users')
                ->where('id',Auth::user()->id)
                ->update([
                    'password' => Hash::make($request->contrasena)
                ]);
            Auth::logout();
            $code = 200;
            return response()->json($code);
        } else {
            $code = 400;
            return response()->json($code);
        }
        
        
    }
}
