<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActividadController extends Controller
{
    /**
     * Historial del usuario autenticado.
     * - últimas 100 (máximo) + paginado
     * - filtros: accion y rango de fechas
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $accion = trim((string) $request->query('accion', ''));
        $desde = $request->query('desde'); // YYYY-MM-DD
        $hasta = $request->query('hasta'); // YYYY-MM-DD

        $query = Actividad::query()
            ->where('user_id', $userId)
            ->with([
                'prompt:id,titulo', // prompt_id puede ser null
            ])
            ->orderByDesc('created_at');

        if ($accion !== '') {
            $query->where('accion', $accion);
        }

        if (!empty($desde)) {
            $query->whereDate('created_at', '>=', $desde);
        }

        if (!empty($hasta)) {
            $query->whereDate('created_at', '<=', $hasta);
        }

        // "últimas 100" + paginado:
        // limitamos el universo a 100 y paginamos sobre eso con simplePaginate
        $actividades = $query
            ->limit(100)
            ->simplePaginate(20)
            ->withQueryString();

        // Opciones de acción (fijas según requerimiento)
        $acciones = [
            'crear_prompt',
            'editar_prompt',
            'eliminar_prompt',
            'compartir_prompt',
            'usar_prompt',
        ];

        return view('actividades.index', compact('actividades', 'acciones'));
    }
}
