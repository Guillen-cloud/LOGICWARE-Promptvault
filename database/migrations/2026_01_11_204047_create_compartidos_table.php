<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('compartidos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('prompt_id');

            $table->string('nombre_destinatario', 140);
            $table->string('email_destinatario', 160);
            $table->dateTime('fecha_compartido');
            $table->text('notas')->nullable();

            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->foreign('prompt_id', 'fk_compartidos_prompt')
                ->references('id')->on('prompts')
                ->cascadeOnDelete();

            $table->index('prompt_id', 'idx_compartidos_prompt');
            $table->index('email_destinatario', 'idx_compartidos_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compartidos');
    }
};
