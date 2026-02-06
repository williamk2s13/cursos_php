<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Aula extends Model
{
    protected $fillable = [
        'modulo_id',
        'titulo',
        'video_url',
        'duracao',
        'tem_pdf',
        'pdf_url',
        'ordem',
        'status'
    ];

    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }
}
