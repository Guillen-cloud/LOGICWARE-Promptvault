<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Etiqueta;
use App\Models\Prompt;
use Illuminate\Http\Request;

class AdminPromptController extends Controller
{
    /**
     * Muestra una lista de TODOS los prompts del sistema con filtros.
     */
    public function index(Request $request)
    {
        $query = Prompt::with(['user', 'categoria'])->latest();

        // Filtro de búsqueda
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('titulo', 'like', "%{$searchTerm}%")
                    ->orWhere('contenido', 'like', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', "%{$searchTerm}%")
                            ->orWhere('email', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $prompts = $query->paginate(15)->withQueryString();

        return view('admin.prompts.index', compact('prompts'));
    }

    /**
     * Muestra el formulario para editar un prompt.
     */
    public function edit(Prompt $prompt)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $etiquetas = Etiqueta::orderBy('nombre')->get();
        $etiquetasSeleccionadas = $prompt->etiquetas->pluck('id')->all();

        return view('admin.prompts.edit', compact('prompt', 'categorias', 'etiquetas', 'etiquetasSeleccionadas'));
    }

    /**
     * Actualiza un prompt en la base de datos.
     */
    public function update(Request $request, Prompt $prompt)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:180',
            'contenido' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'ia_destino' => 'required|string|max:60',
            'descripcion' => 'nullable|string',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id',
            'es_publico' => 'nullable|boolean',
            'es_favorito' => 'nullable|boolean',
        ]);

        $prompt->update([
            'titulo' => $validated['titulo'],
            'contenido' => $validated['contenido'],
            'categoria_id' => $validated['categoria_id'],
            'ia_destino' => $validated['ia_destino'],
            'descripcion' => $validated['descripcion'],
            'es_publico' => $request->has('es_publico'),
            'es_favorito' => $request->has('es_favorito'),
        ]);

        if ($request->has('etiquetas')) {
            $prompt->etiquetas()->sync($request->etiquetas);
        } else {
            $prompt->etiquetas()->detach();
        }

        return redirect()->route('admin.prompts.index')->with('status', '¡Prompt actualizado con éxito!');
    }

    /**
     * Elimina un prompt del sistema.
     */
    public function destroy(Prompt $prompt)
    {
        $prompt->delete();
        return back()->with('status', '¡Prompt eliminado permanentemente!');
    }
}