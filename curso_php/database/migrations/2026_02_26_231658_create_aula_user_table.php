<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('aula_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('aula_id')->constrained()->onDelete('cascade');
        $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade'); 
        // Nota: se sua tabela de usuários se chamar 'usuarios' em vez de 'users', 
        // ajuste o nome acima.
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aula_user');
    }
};
