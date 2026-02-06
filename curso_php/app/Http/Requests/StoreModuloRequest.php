<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuloRequest extends FormRequest
{
    public function rules()
    {
        return [
            'curso_id' => 'required|exists:cursos,id',
            'titulo' => 'required|string|max:255',
            'ordem' => 'integer'
        ];
    }
}

