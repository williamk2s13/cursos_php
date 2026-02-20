<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $table = 'planos';

  protected $fillable = [
    'nome',
    'preco',
    'status',
    'pdf',
    'duracao',
    'dias_validade',
    'limite_cursos_mes',
    'limite_aulas_dia'
];

    public $timestamps = false;

     protected $attributes = [
    'status' => 1
    ];
        protected $casts = [
        'pdf' => 'boolean',
        'status' => 'boolean'
    ];

    public function beneficios()
    {
        return $this->hasMany(PlanoBeneficio::class);
    }

    public function users()
    {
        return $this->hasMany(Usuario::class);
    }

    public function historicoUsuarios()
{
    return $this->hasMany(PlanoHistorico::class, 'plano_id');
}

}
