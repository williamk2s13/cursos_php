<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'senha' => 'required',
        ]);

      
        $user = Usuario::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado'
            ], 404);
        }

       if (!Hash::check($request->senha, $user->senha)) {
            return response()->json([
                'success' => false,
                'message' => 'Senha incorreta'
            ], 401);
        }


        $token = $user->createToken('api_token')->plainTextToken;


        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso',
            'token' => $token,
            'usuario' => [
                'id' => $user->id,
                'nome' => $user->nome,
                'email' => $user->email,
                'admin' => (bool) $user->admin,
            ]
        ]);
    }

public function register(Request $request)
{
    $messages = [
        'senha.min' => 'A senha deve ter no mínimo 8 caracteres.',
        'senha.regex' => 'A senha deve conter letra maiúscula, minúscula, número e caractere especial.',
    ];

    $request->validate([
        'nome' => 'required|string|max:255',
        'email' => 'required|email|unique:usuarios,email',
        'senha' => [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',
        ],
    ], $messages);

    $usuario = Usuario::create([
        'nome' => $request->nome,
        'email' => $request->email,
        'senha' => bcrypt($request->senha),
        'cpf' => $request->cpf,
        'admin' => $request->admin ?? 0
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Usuário cadastrado com sucesso!',
        'usuario' => $usuario
    ], 201);
}
}
