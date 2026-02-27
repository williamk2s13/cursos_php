<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAulaRequest;
use App\Models\Aula;
use App\Models\UsuarioUsoPlano;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AulaController extends Controller
{

public function store(StoreAulaRequest $request)
{
    $modulo = \App\Models\Modulo::where('id', $request->modulo_id)
        ->whereHas('curso', function ($q) {
            $q->where('professor_id', Auth::id());
        })
        ->firstOrFail();

    $data = $request->validated();

    if ($request->hasFile('video_url')) {
        $data['video_url'] = $request->file('video_url')->store('videos', 'public');
    }

    if ($request->hasFile('pdf_url')) {
        $data['pdf_url'] = $request->file('pdf_url')->store('pdfs', 'public');
    }

    return $modulo->aulas()->create($data);
}

public function show(Aula $aula, Request $request)
{
      $user = $request->user();
   if (strtolower($user->role) === 'admin') {
        $aula->increment('views');
        $aula->foi_concluida = $user->aulasConcluidas()
            ->where('aula_id', $aula->id)
            ->exists();

        return response()->json($aula);
    }

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

    if ($aula->tem_pdf && !$plano->tem_pdf) {
        return response()->json(['message' => 'Seu plano não permite PDFs'], 403);
    }

    $limiteAulas = (int) $plano->limite_aulas_dia;

    $hoje = now()->timezone(config('app.timezone'))->toDateString();
    $aula->foi_concluida = $user->aulasConcluidas()->where('aula_id', $aula->id)->exists();
    $controle = UsuarioUsoPlano::firstOrCreate(
        [
            'usuario_id' => $user->id,
            'data_controle' => $hoje
        ],
        [
            'aulas_usadas_dia' => 0
        ]
    );

    $aula->increment('views');

    $usadasHoje = (int) $controle->aulas_usadas_dia;

    if ($limiteAulas > 0 && $usadasHoje >= $limiteAulas) {
        return response()->json(['message' => 'Limite diário de aulas atingido'], 403);
    }

    if ($limiteAulas > 0) {
        $controle->increment('aulas_usadas_dia');
        $controle->refresh(); 
    }
        


    return response()->json($aula);
}

public function concluir(Aula $aula, Request $request)
{
    try {
        $user = $request->user();
        
        $resultado = $user->aulasConcluidas()->toggle($aula->id);
        
        $concluido = count($resultado['attached']) > 0;

        return response()->json([
            'concluido' => $concluido,
            'message' => $concluido ? 'Aula concluída!' : 'Conclusão removida!'
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
