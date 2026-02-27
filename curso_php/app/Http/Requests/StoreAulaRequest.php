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
            'video_url' => 'required|file|mimes:mp4,mov,avi|max:204800',
            'duracao' => 'integer',
            'tem_pdf' => 'boolean',
            'pdf_url' => 'nullable|file|mimes:pdf|max:20480',
            'ordem' => 'integer'
        ];
    }
}
