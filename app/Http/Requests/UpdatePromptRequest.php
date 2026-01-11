<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],

            'titulo' => ['required', 'string', 'max:180'],
            'contenido' => ['required', 'string'],
            'descripcion' => ['nullable', 'string'],

            'ia_destino' => ['required', 'string', 'max:60'],

            'es_favorito' => ['nullable', 'boolean'],
            'es_publico' => ['nullable', 'boolean'],

            'etiquetas' => ['nullable', 'array'],
            'etiquetas.*' => ['integer', 'distinct', 'exists:etiquetas,id'],

            // NUEVO: obligatorio para versionado
            'motivo_cambio' => ['required', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'es_favorito' => $this->boolean('es_favorito'),
            'es_publico' => $this->boolean('es_publico'),
        ]);
    }

    public function messages(): array
    {
        return [
            'motivo_cambio.required' => 'Debes indicar el motivo del cambio.',
        ];
    }
}
