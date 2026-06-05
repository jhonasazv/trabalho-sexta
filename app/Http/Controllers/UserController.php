<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nette\Schema\ValidationException;

class UserController extends Controller
{

function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return ['erro' => 'dados errados'];
        }

        $request->session()->regenerate();
        
        return ['redirect' =>'/home'];

    }

    function register(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'apelido' => ['required', 'string', 'max:255', 'unique:users,apelido'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'senha' => ['required', 'min:5'],
        ]);

        $user = User::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'senha' => Hash::make($validated['senha']),
            'apelido' => $validated['apelido']
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return ['redirect' =>'/home'];
    }

    function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return ['redirect' => '/home'];
    }

    function delete(Request $request)
    {
        $user = Auth::user();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();


        return ['redirect' => '/login'];
    }

    function update(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['nullable','string', 'max:255'],
            'apelido' => ['nullable','string', 'max:255', 'unique:users,apelido'],
            'email' => ['nullable','email', 'max:255', 'unique:users,email'],
            'senhaNew' => ['nullable','min:5'],
            'senha' => ['required', 'min:5'],
        ]);

        $user = Auth::user();

        if (!empty($validated['email']) && Hash::check($validated['senha'], $user->senha)) {
            $user->updateOrFail([
            'email' => $validated['email']
        ]);
            return ['redirect' => '/home'];
        }

        if(!empty($validated['senhaNew']) and Hash::check($validated['senha'], $user->senha)){

            $user->updateOrFail(['senha' => Hash::make($validated['senhaNew'])]);
            return ['redirect' => '/home'];
        }

        if(!empty($validated['apelido']) and Hash::check($validated['senha'], $user->senha)){

            $user->updateOrFail(['apelido' => $validated['apelido']]);
            return ['redirect' => '/home'];
        }

        if(!empty($validated['nome']) !== null and Hash::check($validated['senha'], $user->senha)){

            $user->updateOrFail(['nome' => $validated['nome']]);
            return ['redirect' => '/home'];
        }

        return ['erro' => 'erro, dados não atualizados'];
    }
}
