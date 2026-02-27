<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;

class UserAdminController extends Controller
{
    public function index()
    {
        return response()->json(
            Usuario::select('id', 'nome', 'email', 'role')->get()
        );
    }

    public function toggleProfessor($id)
    {
        $user = Usuario::findOrFail($id);

        if ($user->role === 'admin') {
            return response()->json([
                'message' => 'Não é possível alterar um admin'
            ], 400);
        }

        $user->role = $user->role === 'professor'
            ? 'user'
            : 'professor';

        $user->save();

        return response()->json([
            'message' => 'Cargo atualizado',
            'user' => $user
        ]);
    }
}