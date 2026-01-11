<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\Categoria;
use App\Models\Etiqueta;
use App\Http\Requests\StorePromptRequest;
use App\Http\Requests\UpdatePromptRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Version;
use Illuminate\Support\Facades\DB;
use App\Support\ActividadLogger;


class PromptController extends Controller
{
    /**
     * Listado paginado del usuario autenticado.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Inputs (normalizados)
        $q = trim((string) $request->query('q', ''));
        $categoriaId = $request->query('categoria_id');
        $iaDestino = trim((string) $request->query('ia_destino', ''));
        $desde = $request->query('desde');   // YYYY-MM-DD
        $hasta = $request->query('hasta');   // YYYY-MM-DD
        $favorito = (int) $request->query('favorito', 0) === 1;
        $publico = (int) $request->query('publico', 0) === 1;

        // Base: por defecto SOLO del usuario autenticado
        $query = Prompt::query()
            ->with([
                'categoria:id,nombre',
                'etiquetas:id,nombre',
                'user:id,name', // para distinguir si es de terceros
            ]);

        if ($publico) {
            // Si publico=1: listar prompts públicos (incluye propios y de terceros)
            $query->where('es_publico', 1);
        } else {
            // Por defecto: solo del usuario
            $query->where('user_id', $userId);
        }

        // q: buscar en titulo y contenido (LIKE).
        // (FULLTEXT es opcional; aquí dejamos LIKE por defecto)
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('titulo', 'like', "%{$q}%")
                    ->orWhere('contenido', 'like', "%{$q}%");
            });
        }

        if (!empty($categoriaId)) {
            $query->where('categoria_id', (int) $categoriaId);
        }

        if ($iaDestino !== '') {
            $query->where('ia_destino', $iaDestino);
            // Alternativa opcional (si quieres “contiene”):
            // $query->where('ia_destino', 'like', "%{$iaDestino}%");
        }

        if (!empty($desde)) {
            // created_at >= desde 00:00:00
            $query->whereDate('created_at', '>=', $desde);
        }

        if (!empty($hasta)) {
            // created_at <= hasta 23:59:59 (whereDate cubre el día completo)
            $query->whereDate('created_at', '<=', $hasta);
        }

        if ($favorito) {
            $query->where('es_favorito', 1);
        }

        // Orden: más recientes primero
        $prompts = $query
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        // Para poblar selects en el filtro
        $categorias = Categoria::query()
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        // Para select de IA destino (valores existentes)
        $iasDestino = Prompt::query()
            ->select('ia_destino')
            ->distinct()
            ->orderBy('ia_destino')
            ->pluck('ia_destino');

        return view('prompts.index', compact('prompts', 'categorias', 'iasDestino', 'userId'));
    }


    /**
     * Formulario crear prompt.
     */
    public function create()
    {
        $categorias = Categoria::query()
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        $etiquetas = Etiqueta::query()
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        return view('prompts.create', compact('categorias', 'etiquetas'));
    }

    /**
     * Guardar prompt.
     * - user_id = auth
     * - veces_usado = 0
     * - version_actual = 1
     * - sync etiquetas en prompt_tag
     */
    public function store(StorePromptRequest $request)
    {
        $data = $request->validated();

        $prompt = Prompt::create([
            'user_id' => Auth::id(),
            'categoria_id' => $data['categoria_id'],
            'titulo' => $data['titulo'],
            'contenido' => $data['contenido'],
            'descripcion' => $data['descripcion'] ?? null,
            'ia_destino' => $data['ia_destino'],
            'es_favorito' => $data['es_favorito'] ?? false,
            'es_publico' => $data['es_publico'] ?? false,
            'veces_usado' => 0,
            'version_actual' => 1,
        ]);

        // Etiquetas N:M (prompt_tag). Si no viene nada, se queda vacío.
        $prompt->etiquetas()->sync($data['etiquetas'] ?? []);

        // ✅ Auditoría: actividad "crear"
        ActividadLogger::log(
            'crear_prompt',
            "Creó el prompt: \"{$prompt->titulo}\" (IA: {$prompt->ia_destino}).",
            $prompt->id
        );

        return redirect()
            ->route('prompts.show', $prompt)
            ->with('status', 'Prompt creado correctamente.');
    }


    /**
     * Mostrar un prompt propio.
     */
    public function show(Prompt $prompt)
    {
        $this->authorizeOwner($prompt);

        $prompt->load([
            'categoria:id,nombre',
            'etiquetas:id,nombre',
        ]);

        return view('prompts.show', compact('prompt'));
    }

    /**
     * Form editar prompt.
     */
    public function edit(Prompt $prompt)
    {
        $this->authorizeOwner($prompt);

        $categorias = Categoria::query()
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        $etiquetas = Etiqueta::query()
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        // ids seleccionados en pivot
        $etiquetasSeleccionadas = $prompt->etiquetas()
            ->pluck('etiquetas.id')
            ->all();

        return view('prompts.edit', compact('prompt', 'categorias', 'etiquetas', 'etiquetasSeleccionadas'));
    }

    /**
     * Actualizar prompt.
     * - NO incrementar version_actual aquí.
     * - sync etiquetas
     */
    public function update(UpdatePromptRequest $request, Prompt $prompt)
    {
        $this->authorizeOwner($prompt);

        $data = $request->validated();

        DB::transaction(function () use ($prompt, $data) {
            // Refresca por seguridad (evita version_actual stale)
            $prompt->refresh();

            // 1) Guardar versión ANTES de actualizar
            Version::create([
                'prompt_id' => $prompt->id,
                'numero_version' => $prompt->version_actual,     // = version_actual actual
                'contenido_anterior' => $prompt->contenido,      // contenido antes del update
                'motivo_cambio' => $data['motivo_cambio'],       // obligatorio
            ]);

            // 2) Actualizar prompt y aumentar version_actual (+1)
            $prompt->update([
                'categoria_id' => $data['categoria_id'],
                'titulo' => $data['titulo'],
                'contenido' => $data['contenido'],
                'descripcion' => $data['descripcion'] ?? null,
                'ia_destino' => $data['ia_destino'],
                'es_favorito' => $data['es_favorito'] ?? false,
                'es_publico' => $data['es_publico'] ?? false,
                'version_actual' => $prompt->version_actual + 1,
            ]);

            // 3) Sync etiquetas
            $prompt->etiquetas()->sync($data['etiquetas'] ?? []);
        });

        // ✅ Actividad: editar (DESPUÉS del commit)
        ActividadLogger::log(
            'editar_prompt',
            "Editó el prompt: \"{$prompt->titulo}\". Motivo: {$data['motivo_cambio']}.",
            $prompt->id
        );

        return redirect()
            ->route('prompts.show', $prompt)
            ->with('status', 'Prompt actualizado. Versión anterior guardada en historial.');
    }


    /**
     * Eliminar prompt propio.
     */
    public function destroy(Prompt $prompt)
    {
        $this->authorizeOwner($prompt);

        // Guardar datos antes de eliminar (recomendado)
        $titulo = $prompt->titulo;

        // ✅ Actividad: eliminar
        ActividadLogger::log(
            'eliminar_prompt',
            "Eliminó el prompt: \"{$titulo}\".",
            $prompt->id
        );

        $prompt->delete();

        return redirect()
            ->route('prompts.index')
            ->with('status', 'Prompt eliminado correctamente.');
    }


    /**
     * Autorización segura sin Policies: verifica ownership.
     * (No cambia esquema. Cumple: el usuario solo gestiona sus prompts).
     */
    private function authorizeOwner(Prompt $prompt): void
    {
        if ((int) $prompt->user_id !== (int) Auth::id()) {
            abort(403, 'No tienes permiso para acceder a este prompt.');
        }
    }
}
