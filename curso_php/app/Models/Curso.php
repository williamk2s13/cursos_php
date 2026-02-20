<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['titulo', 'descricao', 'capa', 'status'];

    public function modulos()
    {
        return $this->hasMany(Modulo::class)->orderBy('ordem');
    }

    public function usuariosQueSalvaram()
{
    return $this->belongsToMany(Usuario::class, 'curso_usuario_salvos')
                ->withTimestamps();
}
}
