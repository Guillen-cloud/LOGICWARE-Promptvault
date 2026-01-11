<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compartido extends Model
{
    protected $table = 'compartidos';

    protected $fillable = [
        'prompt_id',
        'nombre_destinatario',
        'email_destinatario',
        'fecha_compartido',
        'notas',
    ];

    protected $casts = [
        'fecha_compartido' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function prompt(): BelongsTo
    {
        return $this->belongsTo(Prompt::class, 'prompt_id', 'id');
    }
}
