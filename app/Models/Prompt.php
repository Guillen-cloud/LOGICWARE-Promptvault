<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Prompt extends Model
{
    // tabla "prompts" coincide con convención, no hace falta $table.

    protected $fillable = [
        'user_id',
        'categoria_id',
        'titulo',
        'contenido',
        'descripcion',
        'ia_destino',
        'es_favorito',
        'es_publico',
        'veces_usado',
        'version_actual',
    ];

    protected $casts = [
        'es_favorito' => 'boolean',
        'es_publico' => 'boolean',
        'veces_usado' => 'integer',
        'version_actual' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }

    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(
            Etiqueta::class,
            'prompt_tag',
            'prompt_id',
            'tag_id'
        );
    }

    public function versiones(): HasMany
    {
        return $this->hasMany(Version::class, 'prompt_id', 'id');
    }

    public function compartidos(): HasMany
    {
        return $this->hasMany(Compartido::class, 'prompt_id', 'id');
    }

    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class, 'prompt_id', 'id');
    }
}
