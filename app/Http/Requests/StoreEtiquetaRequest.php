<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtiquetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:80', 'unique:etiquetas,nombre'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la etiqueta es obligatorio.',
            'nombre.unique' => 'Ya existe una etiqueta con ese nombre.',
            'nombre.max' => 'El nombre no puede superar 80 caracteres.',
        ];
    }
}
