<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCursoRequest;
use App\Models\Curso;
class CursoController extends Controller
{
    public function index()
    {
        return Curso::where('status', true)
            ->with('modulos.aulas')
            ->get();
    }

    public function store(StoreCursoRequest $request)
    {
        return Curso::create($request->validated());
    }

    public function show(Curso $curso)
    {
        return $curso->load('modulos.aulas');
    }
}
