<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\Compartido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\ActividadLogger;

class CompartidoController extends Controller
{
    /**
     * Listar compartidos de un prompt (solo dueño).
     */
    public function index(Prompt $prompt)
    {
        $this->authorizeOwner($prompt);

        $compartidos = Compartido::query()
            ->where('prompt_id', $prompt->id)
            ->orderByDesc('fecha_compartido')
            ->paginate(15)
            ->withQueryString();

        return view('prompts.compartidos.index', compact('prompt', 'compartidos'));
    }

    /**
     * Formulario para compartir (página).
     */
    public function create(Prompt $prompt)
    {
        $this->authorizeOwner($prompt);

        return view('prompts.compartidos.create', compact('prompt'));
    }

    /**
     * Guardar compartido.
     * - fecha_compartido = now()
     */
    public function store(Request $request, Prompt $prompt)
    {
        $this->authorizeOwner($prompt);

        $data = $request->validate([
            'nombre_destinatario' => ['required', 'string', 'max:140'],
            'email_destinatario' => ['required', 'email', 'max:160'],
            'notas' => ['nullable', 'string'],
        ], [
            'nombre_destinatario.required' => 'El nombre del destinatario es obligatorio.',
            'email_destinatario.required' => 'El email del destinatario es obligatorio.',
            'email_destinatario.email' => 'El email no tiene un formato válido.',
        ]);

        Compartido::create([
            'prompt_id' => $prompt->id,
            'nombre_destinatario' => $data['nombre_destinatario'],
            'email_destinatario' => $data['email_destinatario'],
            'fecha_compartido' => now(),
            'notas' => $data['notas'] ?? null,
        ]);

        // ✅ Actividad: compartir prompt
        ActividadLogger::log(
            'compartir_prompt',
            "Compartió el prompt \"{$prompt->titulo}\" con {$data['nombre_destinatario']} ({$data['email_destinatario']}).",
            $prompt->id
        );

        return redirect()
            ->route('prompts.compartidos.index', $prompt)
            ->with('status', 'Compartido registrado correctamente.');
    }


    /**
     * Opcional: eliminar registro de compartido (solo dueño).
     */
    public function destroy(Prompt $prompt, Compartido $compartido)
    {
        $this->authorizeOwner($prompt);

        // Seguridad: el compartido debe pertenecer al prompt
        if ((int) $compartido->prompt_id !== (int) $prompt->id) {
            abort(404);
        }

        $compartido->delete();

        return redirect()
            ->route('prompts.compartidos.index', $prompt)
            ->with('status', 'Registro de compartido eliminado.');
    }

    private function authorizeOwner(Prompt $prompt): void
    {
        if ((int) $prompt->user_id !== (int) Auth::id()) {
            abort(403, 'No tienes permiso para compartir este prompt.');
        }
    }
}
