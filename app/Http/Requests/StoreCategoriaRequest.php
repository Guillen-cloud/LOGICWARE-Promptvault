<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:120', 'unique:categorias,nombre'],
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
            'nombre.max' => 'El nombre no puede superar 120 caracteres.',
            'color.max' => 'El color no puede superar 20 caracteres.',
            'icono.max' => 'El icono no puede superar 60 caracteres.',
        ];
    }
}
