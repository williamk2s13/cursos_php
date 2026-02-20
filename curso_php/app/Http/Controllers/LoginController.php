<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUsuarioRequest;

class LoginController extends Controller
{
   public function login(Request $request) 
{
    $request->validate([
        'email' => 'required',
        'senha' => 'required',
    ]);

    $user = Usuario::with('plano')->where('email', $request->email)->first();

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
        'usuario' => $user
    ]);
}
public function register(StoreUsuarioRequest $request)
{

    $data = $request->all();
    $data['admin'] = $request->input('admin', 0); 
    $usuario = Usuario::create($data);

    return response()->json([
        'success' => true,
        'message' => 'Usuário cadastrado com sucesso!',
        'usuario' => $usuario
    ], 201);

    
}

}
