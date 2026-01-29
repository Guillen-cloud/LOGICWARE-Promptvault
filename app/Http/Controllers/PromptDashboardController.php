<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromptDashboardController extends Controller
{
    /**
     * Mostrar dashboard con todos los prompts del sistema
     * y opciones para gestionar solo los propios
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $q = trim((string) $request->query('q', ''));
        $categoriaId = $request->query('categoria_id');

        // Obtener todos los prompts públicos del sistema
        $query = Prompt::query()
            ->where('es_publico', 1)
            ->with([
                'categoria:id,nombre',
                'etiquetas:id,nombre',
                'user:id,name,id',
            ]);

        // Filtro de búsqueda
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('titulo', 'like', "%{$q}%")
                    ->orWhere('contenido', 'like', "%{$q}%");
            });
        }

        // Filtro por categoría
        if (!empty($categoriaId)) {
            $query->where('categoria_id', (int) $categoriaId);
        }

        $promptsDelSistema = $query
            ->latest('created_at')
            ->paginate(6)
            ->withQueryString();

        // Obtener prompts propios del usuario
        $promptsPropios = Prompt::query()
            ->where('user_id', $userId)
            ->with([
                'categoria:id,nombre',
                'etiquetas:id,nombre',
            ])
            ->latest('created_at')
            ->get();

        // Categorías para el filtro
        $categorias = Categoria::query()
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        return view('prompts.dashboard', [
            'promptsDelSistema' => $promptsDelSistema,
            'promptsPropios' => $promptsPropios,
            'categorias' => $categorias,
            'q' => $q,
            'categoriaId' => $categoriaId,
        ]);
    }
}
