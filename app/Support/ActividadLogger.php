<?php

namespace App\Support;

use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;

class ActividadLogger
{
    /**
     * Registra una actividad en tabla actividades.
     *
     * @param string $accion (<= 40 chars)
     * @param string $descripcion texto entendible
     * @param int|null $promptId id del prompt si aplica
     */
    public static function log(string $accion, string $descripcion, ?int $promptId = null): void
    {
        // Si no hay usuario autenticado, no registramos (seguro para llamadas accidentales)
        $userId = Auth::id();
        if (!$userId) {
            return;
        }

        // Seguridad: respetar accion VARCHAR(40)
        $accion = mb_substr($accion, 0, 40);

        Actividad::create([
            'user_id' => $userId,
            'prompt_id' => $promptId,
            'accion' => $accion,
            'descripcion' => $descripcion,
        ]);
    }
}
