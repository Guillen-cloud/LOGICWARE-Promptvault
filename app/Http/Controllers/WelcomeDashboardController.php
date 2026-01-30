<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prompt;

class WelcomeDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Prompt::where('es_publico', 1)
            ->with(['categoria', 'user', 'etiquetas']);

        if ($request->filled('q')) {
            $searchTerm = $request->input('q');

            $query->where(function ($q) use ($searchTerm) {
                $q->where('titulo', 'like', '%' . $searchTerm . '%')
                    ->orWhere('descripcion', 'like', '%' . $searchTerm . '%')
                    ->orWhere('contenido', 'like', '%' . $searchTerm . '%');
            });
        }

        $prompts = $query->latest()->paginate(12)->withQueryString();

        return view('welcome-dashboard', [
            'prompts' => $prompts,
        ]);
    }
}
