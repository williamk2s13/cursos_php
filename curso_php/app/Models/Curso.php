<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'capa',
        'status',
        'professor_id'
    ];

    public function modulos()
    {
        return $this->hasMany(Modulo::class)->orderBy('ordem');
    }

      public function professor()
    {
        return $this->belongsTo(Usuario::class, 'professor_id');
    }

    public function usuariosQueSalvaram()
{
    return $this->belongsToMany(Usuario::class, 'curso_usuario_salvos')
                ->withTimestamps();
}

public function avaliacoes()
{
    return $this->hasMany(Avaliacao::class);
}

protected $appends = ['media_notas', 'total_avaliacoes'];

public function getMediaNotasAttribute()
{
    return round($this->avaliacoes()->avg('nota'), 1) ?: 0;
}

public function getTotalAvaliacoesAttribute()
{
    return $this->avaliacoes()->count();
}
}
