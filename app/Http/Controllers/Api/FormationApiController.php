<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Http\Resources\FormationResource;

class FormationApiController extends Controller
{
    public function index()
    {
        $formations = Formation::published()->with('category')->paginate(12);
        return FormationResource::collection($formations);
    }

    public function showBySlug(string $slug)
    {
        $formation = Formation::where('slug_fr', $slug)
            ->orWhere('slug_en', $slug)
            ->with(['category', 'sessions'])
            ->firstOrFail();

        return new FormationResource($formation);
    }
}