<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromptRequest extends FormRequest
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

            // checkboxes: si no vienen, se setean false en controller
            'es_favorito' => ['nullable', 'boolean'],
            'es_publico' => ['nullable', 'boolean'],

            // etiquetas (N:M): array de IDs existentes
            'etiquetas' => ['nullable', 'array'],
            'etiquetas.*' => ['integer', 'distinct', 'exists:etiquetas,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Convierte checkbox "on" a boolean.
        $this->merge([
            'es_favorito' => $this->boolean('es_favorito'),
            'es_publico' => $this->boolean('es_publico'),
        ]);
    }

    public function messages(): array
    {
        return [
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'etiquetas.*.exists' => 'Una de las etiquetas seleccionadas no existe.',
        ];
    }
}
