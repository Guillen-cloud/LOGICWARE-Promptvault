<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('prompt_id')->nullable()->constrained('prompts')->onDelete('set null');
            $table->json('request_json')->comment('Datos de la solicitud (mensaje, contexto)');
            $table->json('response_json')->comment('Respuesta de OpenAI');
            $table->timestamps();

            $table->index('user_id');
            $table->index('prompt_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_interactions');
    }
};
