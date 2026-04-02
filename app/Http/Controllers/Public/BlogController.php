<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', 'published')
            ->with('category')
            ->latest()
            ->paginate(9);

        $categories = Category::all();

        return view('public.blog.index', compact('blogs', 'categories'));
    }

    public function show(string $lang, string $slug)
    {
        $blog = Blog::where('slug_fr', $slug)
            ->orWhere('slug_en', $slug)
            ->orWhere('id', $slug)
            ->with('category')
            ->firstOrFail();

        $recentBlogs = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(4)
            ->get();

        return view('public.blog.show', compact('blog', 'recentBlogs'));
    }
}
