<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('prompt_id')->nullable();

            $table->string('accion', 40);
            $table->text('descripcion');

            $table->timestamp('created_at')->nullable()->useCurrent();

            // FK → users (ON DELETE CASCADE)
            $table->foreign('user_id', 'fk_actividades_user')
                ->references('id')->on('users')
                ->cascadeOnDelete();

            // FK → prompts (ON DELETE SET NULL)
            $table->foreign('prompt_id', 'fk_actividades_prompt')
                ->references('id')->on('prompts')
                ->nullOnDelete();

            $table->index('user_id', 'idx_actividades_user');
            $table->index('accion', 'idx_actividades_accion');
            $table->index('created_at', 'idx_actividades_created');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
