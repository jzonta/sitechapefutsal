<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('legacy_id')->nullable()->unique(); // número do antigo noticiaXX.html
            $table->string('slug')->unique();
            $table->string('titulo');
            $table->string('resumo', 500)->nullable();
            $table->string('categoria', 60)->nullable();
            $table->longText('corpo');
            $table->string('imagem')->nullable();        // caminho relativo a public/
            $table->string('imagem_alt')->nullable();
            $table->string('imagem_posicao', 40)->nullable(); // object-position do hero
            $table->longText('sidebar_html')->nullable();   // caixas laterais (HTML)
            $table->timestamp('publicado_em')->nullable()->index();
            $table->boolean('publicado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
