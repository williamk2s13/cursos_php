<?php

namespace App\Http\Controllers;
use App\Models\Modulo;

use App\Http\Requests\StoreModuloRequest;

class ModuloController extends Controller
{
    public function store(StoreModuloRequest $request)
    {
        return Modulo::create($request->validated());
    }
}

