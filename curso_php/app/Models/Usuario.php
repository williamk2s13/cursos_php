<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'telefone'
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

public function escolherPlano(int $planoId): void
{
    $this->plano_id = $planoId;
    $this->save();
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

}
