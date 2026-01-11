<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prompt_tag', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->unsignedBigInteger('prompt_id');
            $table->unsignedBigInteger('tag_id');

            // PK compuesta (N:M)
            $table->primary(['prompt_id', 'tag_id']);

            // FK → prompts
            $table->foreign('prompt_id', 'fk_prompt_tag_prompt')
                ->references('id')->on('prompts')
                ->cascadeOnDelete();

            // FK → etiquetas
            $table->foreign('tag_id', 'fk_prompt_tag_tag')
                ->references('id')->on('etiquetas')
                ->cascadeOnDelete();

            $table->index('tag_id', 'idx_prompt_tag_tag');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prompt_tag');
    }
};
