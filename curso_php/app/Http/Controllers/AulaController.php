<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreAulaRequest;
use App\Models\Aula;
    
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function store(StoreAulaRequest $request)
    {
        return Aula::create($request->validated());
    }

    public function show(Aula $aula, Request $request)
    {
        $user = $request->user();

        if ($aula->tem_pdf && !$user->plano->tem_pdf) {
            return response()->json([
                'message' => 'Seu plano não permite acessar PDFs'
            ], 403);
        }

        return $aula;
    }
}

