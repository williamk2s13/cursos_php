<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Http\Requests\UpdateUsuarioRequest;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function update(UpdateUsuarioRequest $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->update($request->validated());

        return response()->json([
            'mensagem' => 'Usuário atualizado com sucesso!',
            'usuario' => $usuario
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $logado = $request->user();

        if (!$usuario->podeSerDeletadoPor($logado)) {
            return response()->json([
                'erro' => 'Você não pode deletar o próprio usuário logado.'
            ], 403);
        }

        $usuario->delete();

        return response()->json([
            'mensagem' => 'Usuário removido com sucesso!'
        ]);
    }

        public function perfil(Request $request)
    {
        $user = $request->user();

        $user->load([
            'plano',
            'historicoPlanos.plano'
        ]);

        return response()->json([
            'usuario' => $user
        ]);
    }
}



