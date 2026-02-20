<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioUsoPlano extends Model
{
    protected $table = 'usuario_uso_planos';

    protected $fillable = [
        'usuario_id',
        'aulas_usadas_dia',
        'data_controle'
    ];
}
