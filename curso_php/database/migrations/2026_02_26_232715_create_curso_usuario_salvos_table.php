<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curso_usuario_salvos', function (Blueprint $table) {
            $table->id();
            
            // Relacionamento com a tabela de cursos
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            
            // Relacionamento com a tabela de usuários 
            // (Ajuste para 'users' ou 'usuarios' dependendo do nome da sua tabela de users)
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            
            $table->timestamps();

            // Opcional: Garante que o usuário não salve o mesmo curso duas vezes
            $table->unique(['curso_id', 'usuario_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curso_usuario_salvos');
    }
};