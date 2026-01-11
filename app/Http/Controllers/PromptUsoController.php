<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Support\ActividadLogger;
use Illuminate\Support\Facades\Auth;

class PromptUsoController extends Controller
{
    public function store(Prompt $prompt)
    {
        $userId = Auth::id();

        // Regla segura:
        // - Si es público, se permite "usar"
        // - Si no es público, solo el dueño puede usar
        if ((int) $prompt->user_id !== (int) $userId && (int) $prompt->es_publico !== 1) {
            abort(403, 'No tienes permiso para marcar este prompt como usado.');
        }

        // Incremento atómico
        $prompt->increment('veces_usado');

        ActividadLogger::log(
            'usar_prompt',
            "Marcó como usado el prompt \"{$prompt->titulo}\". Veces usado: {$prompt->veces_usado}.",
            $prompt->id
        );

        return back()->with('status', 'Marcado como usado.');
    }
}
