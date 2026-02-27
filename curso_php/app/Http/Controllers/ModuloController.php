<?php

namespace App\Http\Controllers;
use App\Models\Modulo;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreModuloRequest;

class ModuloController extends Controller
{
   public function store(StoreModuloRequest $request)
{
    $curso = \App\Models\Curso::where('id', $request->curso_id)
        ->where('professor_id', Auth::id())
        ->firstOrFail();

    return $curso->modulos()->create([
        'titulo' => $request->titulo
    ]);
}
}

