<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|unique:planos,nome',
            'preco' => 'required|numeric|min:0',
            'status' => 'nullable|boolean',
            'duracao' => 'required|in:mensal,anual',
            'dias_validade' => 'required|integer|min:1',
            'limite_cursos_mes' => 'nullable|integer|min:0',
            'limite_aulas_dia' => 'nullable|integer|min:0',

            'beneficios' => 'required|array|min:1',
            'beneficios.*.chave' => 'required|string',
            'beneficios.*.texto' => 'required|string',
            'beneficios.*.valor' => 'nullable|integer|min:0'
        ];
    }
}

