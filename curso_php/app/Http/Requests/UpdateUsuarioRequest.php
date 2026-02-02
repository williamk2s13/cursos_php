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
    ];
}

}
