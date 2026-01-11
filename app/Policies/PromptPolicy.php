<?php

namespace App\Policies;

use App\Models\Prompt;
use App\Models\User;

class PromptPolicy
{
    /**
     * Ver listado.
     * Regla: por defecto el index filtra por dueño, pero el filtro "publico=1"
     * permite listar públicos. Aquí permitimos index a cualquier autenticado.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Ver un prompt.
     * - dueño siempre
     * - si es_publico=1, cualquier autenticado puede ver
     */
    public function view(User $user, Prompt $prompt): bool
    {
        if ((int) $prompt->user_id === (int) $user->id) {
            return true;
        }

        return (int) $prompt->es_publico === 1;
    }

    /**
     * Crear: cualquier autenticado puede crear prompts propios.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Update: solo dueño.
     */
    public function update(User $user, Prompt $prompt): bool
    {
        return (int) $prompt->user_id === (int) $user->id;
    }

    /**
     * Delete: solo dueño.
     */
    public function delete(User $user, Prompt $prompt): bool
    {
        return (int) $prompt->user_id === (int) $user->id;
    }

    /**
     * Share: solo dueño (módulo compartidos).
     */
    public function share(User $user, Prompt $prompt): bool
    {
        return (int) $prompt->user_id === (int) $user->id;
    }

    /**
     * Usar prompt:
     * - dueño puede
     * - si es público, cualquier autenticado puede
     */
    public function use(User $user, Prompt $prompt): bool
    {
        return (int) $prompt->user_id === (int) $user->id || (int) $prompt->es_publico === 1;
    }

    /**
     * Ver historial de versiones: solo dueño.
     */
    public function viewVersions(User $user, Prompt $prompt): bool
    {
        return (int) $prompt->user_id === (int) $user->id;
    }

    /**
     * Ver compartidos: solo dueño.
     */
    public function viewShares(User $user, Prompt $prompt): bool
    {
        return (int) $prompt->user_id === (int) $user->id;
    }
}
