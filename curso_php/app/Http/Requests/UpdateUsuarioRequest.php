<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
{
   public function authorize()
{
    return true;
}
public function rules()
{
    return [
        'nome' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:usuarios,email,' . $this->route('id'),
        'telefone' => 'sometimes|string|max:11', 
        'senha' => [
            'sometimes', 
            'string',
            'min:8',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',
        ],
    ];
}
}
