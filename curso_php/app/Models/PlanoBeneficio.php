<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanoBeneficio extends Model
{
    protected $table = 'plano_beneficios';

    protected $fillable = [
        'plano_id',
        'chave',
        'valor',
        'texto'
    ];

    public $timestamps = false;

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }
}