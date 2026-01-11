<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $categoriaId = $this->route('categoria')?->id;

        return [
            'nombre' => ['required', 'string', 'max:120', Rule::unique('categorias', 'nombre')->ignore($categoriaId)],
            'descripcion' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:20'],
            'icono' => ['nullable', 'string', 'max:60'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Ya existe una categoría con ese nombre.',
        ];
    }
}
