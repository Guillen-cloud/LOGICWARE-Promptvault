<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prompts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('categoria_id');

            $table->string('titulo', 180);
            $table->longText('contenido');
            $table->text('descripcion')->nullable();

            $table->string('ia_destino', 60);

            $table->boolean('es_favorito')->default(false);
            $table->boolean('es_publico')->default(false);

            $table->unsignedInteger('veces_usado')->default(0);
            $table->unsignedInteger('version_actual')->default(1);

            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id', 'fk_prompts_users')
                ->references('id')->on('users')
                ->onDelete('cascade');

            // ✅ RESTRICT seguro (equivalente a ON DELETE RESTRICT)
            $table->foreign('categoria_id', 'fk_prompts_categorias')
                ->references('id')->on('categorias')
                ->restrictOnDelete();

            $table->index('user_id', 'idx_prompts_user');
            $table->index('categoria_id', 'idx_prompts_categoria');
            $table->index('ia_destino', 'idx_prompts_ia');
            $table->index('es_favorito', 'idx_prompts_favorito');
            $table->index('es_publico', 'idx_prompts_publico');
            $table->index('created_at', 'idx_prompts_created_at');

            // Opcional recomendado para búsqueda rápida (NO se ejecuta si lo dejas comentado)
            // $table->fullText(['titulo', 'contenido'], 'ft_prompts_text');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
