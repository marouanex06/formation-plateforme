<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Category;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::where('status', 'publie')
            ->with('category')
            ->when(request('category'), fn($q) =>
                $q->whereHas('category', fn($q) =>
                    $q->where('slug_fr', request('category'))
                      ->orWhere('slug_en', request('category'))
                )
            )
            ->when(request('search'), fn($q) =>
                $q->where('title_fr', 'like', '%' . request('search') . '%')
                  ->orWhere('title_en', 'like', '%' . request('search') . '%')
            )
            ->paginate(12);

        $categories = Category::withCount('formations')->get();

        return view('public.formations.index', compact('formations', 'categories'));
    }

    public function show(string $lang, string $slug)
    {
        $formation = Formation::where('slug_fr', $slug)
            ->orWhere('slug_en', $slug)
            ->orWhere('id', $slug)
            ->with('category')
            ->firstOrFail();

        return view('public.formations.show', compact('formation'));
    }
}
