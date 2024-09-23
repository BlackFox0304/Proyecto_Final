<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function register(Request $request)
    {
        //validar datos
        $usuario = new Usuario();

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->numberPhone = $request->numberPhone;
        $usuario->password = Hash::make($request->password);

        $usuario->save();

        Auth::login($usuario);

        return redirect(route('privada'));
    }

    public function login(Request $request)
    {
        //validacion

        $credentials = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        $remember = ($request->has('remember') ? true : false);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('privada'));
        } else {
            return redirect('login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
