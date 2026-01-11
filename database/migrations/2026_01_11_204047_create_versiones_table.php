<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('versiones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('prompt_id');

            $table->unsignedInteger('numero_version');
            $table->longText('contenido_anterior');
            $table->string('motivo_cambio', 255);

            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->foreign('prompt_id', 'fk_versiones_prompt')
                ->references('id')->on('prompts')
                ->cascadeOnDelete();

            $table->index('prompt_id', 'idx_versiones_prompt');
            $table->unique(['prompt_id', 'numero_version'], 'uk_version_prompt_num');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('versiones');
    }
};
