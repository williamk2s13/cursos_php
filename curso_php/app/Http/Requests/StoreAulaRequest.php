<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAulaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'modulo_id' => 'required|exists:modulos,id',
            'titulo' => 'required|string|max:255',
            'video_url' => 'required|string',
            'duracao' => 'integer',
            'tem_pdf' => 'boolean',
            'pdf_url' => 'nullable|string',
            'ordem' => 'integer'
        ];
    }
}
