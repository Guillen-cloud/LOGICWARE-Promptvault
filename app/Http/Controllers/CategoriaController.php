<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::query()
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(StoreCategoriaRequest $request)
    {
        Categoria::create($request->validated());

        return redirect()
            ->route('categorias.index')
            ->with('status', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update($request->validated());

        return redirect()
            ->route('categorias.index')
            ->with('status', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        // Si está usada por prompts, MySQL rechazará por FK RESTRICT.
        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('status', 'Categoría eliminada.');
    }
}
