<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class Usuario extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'admin',
        'cpf',
        'plano_id',
        'telefone',
        'plano_expira_em'
    ];

    protected $hidden = [
        'senha',
    ];

public function setSenhaAttribute($value)
{
    $this->attributes['senha'] = bcrypt($value);
}

protected $attributes = [
    'status' => 'ativo',
];

public function plano()
{
    return $this->belongsTo(Plano::class);
}



public function podeSerDeletadoPor($usuarioLogado)
{
    return $usuarioLogado->id !== $this->id;
}

public function escolherPlano($planoId)
{
    $plano = Plano::findOrFail($planoId);

    $this->update([
        'plano_id' => $plano->id,
        'plano_expira_em' => Carbon::now()->addDays($plano->dias_validade)
    ]);
}
public function removerPlano()
{
    $this->plano_id = null;
    $this->save();
}

public function historicoPlanos()
{
    return $this->hasMany(PlanoHistorico::class, 'usuario_id')
                ->orderBy('created_at', 'desc');
}

public function cursosSalvos()
{
    return $this->belongsToMany(Curso::class, 'curso_usuario_salvos')
                ->withTimestamps();
}
    public function usoPlano()
{
    return $this->hasMany(\App\Models\UsuarioUsoPlano::class, 'usuario_id');
}



}
