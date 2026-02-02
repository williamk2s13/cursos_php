<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
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
            'cpf' => 'nullable|string',
            'admin' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            'senha.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'senha.regex' => 'A senha deve conter letra maiúscula, minúscula, número e caractere especial.',
        ];
    }
}
