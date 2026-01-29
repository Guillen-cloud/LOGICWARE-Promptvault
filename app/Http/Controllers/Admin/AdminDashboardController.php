<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Prompt;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Muestra el dashboard principal del administrador con estadísticas.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_prompts' => Prompt::count(),
            'total_categories' => Categoria::count(),
            'public_prompts' => Prompt::where('es_publico', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
