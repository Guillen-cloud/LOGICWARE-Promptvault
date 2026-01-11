<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEtiquetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $etiquetaId = $this->route('etiqueta')?->id;

        return [
            'nombre' => ['required', 'string', 'max:80', Rule::unique('etiquetas', 'nombre')->ignore($etiquetaId)],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la etiqueta es obligatorio.',
            'nombre.unique' => 'Ya existe una etiqueta con ese nombre.',
        ];
    }
}
