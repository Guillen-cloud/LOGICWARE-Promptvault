<?php

namespace App\Providers;

use App\Models\Prompt;
use App\Policies\PromptPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Prompt::class => PromptPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
