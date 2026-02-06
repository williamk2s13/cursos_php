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
        'pdf'
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
}
