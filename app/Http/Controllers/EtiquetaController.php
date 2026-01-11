<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Http\Requests\StoreEtiquetaRequest;
use App\Http\Requests\UpdateEtiquetaRequest;

class EtiquetaController extends Controller
{
    public function index()
    {
        $etiquetas = Etiqueta::query()
            ->orderBy('nombre')
            ->paginate(20)
            ->withQueryString();

        return view('etiquetas.index', compact('etiquetas'));
    }

    public function create()
    {
        return view('etiquetas.create');
    }

    public function store(StoreEtiquetaRequest $request)
    {
        Etiqueta::create($request->validated());

        return redirect()
            ->route('etiquetas.index')
            ->with('status', 'Etiqueta creada correctamente.');
    }

    public function edit(Etiqueta $etiqueta)
    {
        return view('etiquetas.edit', compact('etiqueta'));
    }

    public function update(UpdateEtiquetaRequest $request, Etiqueta $etiqueta)
    {
        $etiqueta->update($request->validated());

        return redirect()
            ->route('etiquetas.index')
            ->with('status', 'Etiqueta actualizada correctamente.');
    }

    public function destroy(Etiqueta $etiqueta)
    {
        // Si está en pivot prompt_tag, se borrará cascada por FK (tag_id ON DELETE CASCADE).
        $etiqueta->delete();

        return redirect()
            ->route('etiquetas.index')
            ->with('status', 'Etiqueta eliminada.');
    }
}
