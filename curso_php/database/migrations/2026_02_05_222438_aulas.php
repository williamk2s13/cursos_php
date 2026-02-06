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
       Schema::create('aulas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('modulo_id')->constrained()->cascadeOnDelete();
    $table->string('titulo');
    $table->string('video_url');
    $table->integer('duracao')->default(0); // minutos
    $table->boolean('tem_pdf')->default(false);
    $table->string('pdf_url')->nullable();
    $table->integer('ordem')->default(1);
    $table->boolean('status')->default(true);
    $table->timestamps();
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
