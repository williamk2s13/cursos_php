<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChoosePlanoRequest extends FormRequest
{
 public function authorize()
{
    return true;
}

public function rules()
{
    return [
        'plano_id' => 'required|exists:planos,id'
    ];
}

}
