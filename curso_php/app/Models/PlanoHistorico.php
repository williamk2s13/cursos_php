<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanoHistorico extends Model
{
    protected $table = 'plano_historico';

    protected $fillable = [
        'usuario_id',
        'plano_id',
        'created_at'
    ];

public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }
}

