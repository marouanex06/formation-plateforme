<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Category;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $formations = Formation::published()
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::withCount('formations')->get();

        $blogs = Blog::where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        return view('public.home', compact('formations', 'categories', 'blogs'));
    }
}