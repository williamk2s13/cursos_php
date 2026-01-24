<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);
    
        if (!$usuario) {
            return response()->json(['erro' => 'Usuário não encontrado'], 404);
        }
    
        $usuario->nome = $request->nome ?? $usuario->nome;
        $usuario->email = $request->email ?? $usuario->email;
    
        $usuario->save();
    
        return response()->json([
            'mensagem' => 'Usuário atualizado com sucesso!',
            'usuario' => $usuario
        ]);
    }

    public function destroy(Request $request, $id)
{
    $usuario = Usuario::find($id);

    if (!$usuario) {
        return response()->json(['erro' => 'Usuário não encontrado'], 404);
    }

    $logado = $request->user(); 
    if ($logado && $logado->id == $usuario->id) {
        return response()->json([
            'erro' => 'Você não pode deletar o próprio usuário logado.'
        ], 403);
    }

    $usuario->delete();

    return response()->json([
        'mensagem' => 'Usuário removido com sucesso!'
    ]);
}

    

}


