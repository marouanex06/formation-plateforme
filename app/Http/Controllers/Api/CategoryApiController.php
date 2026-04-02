<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('formations')->get();

        return response()->json([
            'data' => $categories->map(fn($c) => [
                'id'               => $c->id,
                'name'             => $c->getName(),
                'slug'             => $c->getSlug(),
                'formations_count' => $c->formations_count,
            ])
        ]);
    }
}