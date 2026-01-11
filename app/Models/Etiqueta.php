<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Etiqueta extends Model
{
    protected $table = 'etiquetas';

    protected $fillable = [
        'nombre',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function prompts(): BelongsToMany
    {
        return $this->belongsToMany(
            Prompt::class,
            'prompt_tag',
            'tag_id',
            'prompt_id'
        );
    }
}
