<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AiInteraction extends Model
{
    use HasFactory;

    protected $table = 'ai_interactions';

    protected $fillable = [
        'user_id',
        'prompt_id',
        'request_json',
        'response_json',
    ];

    protected $casts = [
        'request_json' => 'array',
        'response_json' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con Prompt (si existe)
     */
    public function prompt()
    {
        return $this->belongsTo(Prompt::class)->withDefault();
    }
}
