<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAulaRequest;
use App\Models\Aula;
use App\Models\UsuarioUsoPlano;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AulaController extends Controller
{
    public function store(StoreAulaRequest $request)
    {
        return Aula::create($request->validated());
    }


public function show(Aula $aula, Request $request)
{
    $user = $request->user();
    $plano = $user->plano;

    
   $controle = UsuarioUsoPlano::firstOrCreate(
    [
        'usuario_id' => $user->id,
        'data_controle' => now()->toDateString()
    ],
    [
        'aulas_usadas_dia' => 0
    ]
);

logger([
    'limite' => $plano->limite_aulas_dia,
    'usadas' => $controle->aulas_usadas_dia,
    'expira_em' => $user->plano_expira_em
]);

    if (!$plano || !$user->plano_expira_em || now()->greaterThan($user->plano_expira_em)) {
        return response()->json(['message' => 'Seu plano expirou'], 403);
    }

    // 2️⃣ Bloqueio de PDF
    if ($aula->tem_pdf && !$plano->tem_pdf) {
        return response()->json(['message' => 'Seu plano não permite PDFs'], 403);
    }

    // 3️⃣ Limite de aulas por dia
    $limiteAulas = (int) $plano->limite_aulas_dia;

    // Garantindo fuso horário correto
    $hoje = now()->timezone(config('app.timezone'))->toDateString();

    // Buscar ou criar controle diário
    $controle = UsuarioUsoPlano::firstOrCreate(
        [
            'usuario_id' => $user->id,
            'data_controle' => $hoje
        ],
        [
            'aulas_usadas_dia' => 0
        ]
    );

    $usadasHoje = (int) $controle->aulas_usadas_dia;

    // 4️⃣ Checar se atingiu o limite
    if ($limiteAulas > 0 && $usadasHoje >= $limiteAulas) {
        return response()->json(['message' => 'Limite diário de aulas atingido'], 403);
    }

    // 5️⃣ Incrementa o uso diário **antes de liberar a aula**
    if ($limiteAulas > 0) {
        $controle->increment('aulas_usadas_dia');
        $controle->refresh(); // garante que o valor atualizado seja usado
    }

    // 6️⃣ Retorna a aula
    return response()->json($aula);
}
}
