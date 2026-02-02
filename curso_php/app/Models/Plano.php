<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
   protected $table = 'planos';

    protected $fillable = [
        'nome',
        'preco',
        'status'
    ];

    public $timestamps = false;

    protected $attributes = [
    'status' => true
    ];
    public function users()
    {
        return $this->hasMany(Usuario::class);
    }
}