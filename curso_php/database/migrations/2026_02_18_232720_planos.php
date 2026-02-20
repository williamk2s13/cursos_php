<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('planos', function (Blueprint $table) {
    $table->enum('duracao', ['mensal', 'anual']);
    $table->integer('dias_validade');
    $table->integer('limite_cursos_mes')->nullable();
    $table->integer('limite_aulas_dia')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
