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
        'nome'  => 'required|string|unique:planos,nome',
        'preco' => 'required|numeric|min:0'
    ];
}

}
