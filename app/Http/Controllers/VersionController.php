<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\Version;
use Illuminate\Support\Facades\Auth;

class VersionController extends Controller
{
    public function index(Prompt $prompt)
    {
        $this->authorizeOwner($prompt);

        $versiones = Version::query()
            ->where('prompt_id', $prompt->id)
            ->orderByDesc('numero_version')
            ->paginate(15)
            ->withQueryString();

        return view('prompts.versiones.index', compact('prompt', 'versiones'));
    }

    public function show(Prompt $prompt, Version $version)
    {
        $this->authorizeOwner($prompt);

        // Seguridad: la versión debe pertenecer al prompt
        if ((int) $version->prompt_id !== (int) $prompt->id) {
            abort(404);
        }

        return view('prompts.versiones.show', compact('prompt', 'version'));
    }

    private function authorizeOwner(Prompt $prompt): void
    {
        if ((int) $prompt->user_id !== (int) Auth::id()) {
            abort(403, 'No tienes permiso para ver el historial de este prompt.');
        }
    }
}
