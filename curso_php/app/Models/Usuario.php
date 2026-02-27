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
        'plano_expira_em',
        'role'
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
    
public function cursos()
{
    return $this->hasMany(Curso::class, 'professor_id');
}


public function podeSerDeletadoPor($usuarioLogado)
{
    return $usuarioLogado->id !== $this->id;
}

public function escolherPlano($planoId)
{
    $plano = Plano::with('beneficios')->findOrFail($planoId);

    $this->plano_id = $plano->id;
    $this->plano_expira_em = now()->addDays(30); 

    $temBeneficioProfessor = $plano->beneficios
        ->where('chave', 'professor')
        ->where('valor', 1)
        ->count() > 0;

    if ($temBeneficioProfessor) {
        $this->role = 'professor';
    } else {
        $this->role = 'user';
    }

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

public function cursosSalvos()
{
    return $this->belongsToMany(Curso::class, 'curso_usuario_salvos')
                ->withTimestamps();
}
    public function usoPlano()
{
    return $this->hasMany(UsuarioUsoPlano::class, 'usuario_id');
}

public function isAdmin()
{
    return $this->role === 'admin';
}

public function isProfessor()
{
    return $this->role === 'professor';
}   

public function aulasConcluidas()
{
    return $this->belongsToMany(Aula::class, 'aula_user')->withTimestamps();
}
public function avaliacoes()
{
    return $this->hasMany(Avaliacao::class);
}
}
