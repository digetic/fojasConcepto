<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {   
        $email = $request->email;
        $password = $request->password;
        $respuesta = Auth::attempt(['email' => $email, 'password' => $password, 'estado'=>1]);
        if ($respuesta) {
            return response()->json([
                'authUser' => Auth::user(),
                'code' => 200
            ]);
        } else {
            return response()->json([
                'code' => 401
            ]);
        }
    }

    public function logout(Request $request)
    {   
        Auth::logout();
        return redirect("/");
    }

    public function ver()
    {
        return response()->json([
            'authUser' => Auth::user()->per_codigo,
            'code' => 200
        ]);
    }
}
