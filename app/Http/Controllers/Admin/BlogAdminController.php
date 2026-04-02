<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogAdminController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category', 'author')->latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_fr'    => ['required', 'string', 'max:255'],
            'title_en'    => ['required', 'string', 'max:255'],
            'content_fr'  => ['required', 'string'],
            'content_en'  => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status'      => ['required', 'in:draft,published'],
        ]);

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        Blog::create(array_merge($data, [
            'user_id' => Auth::id(),
        ]));

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Article cree avec succes.');
    }

    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title_fr'    => ['required', 'string', 'max:255'],
            'title_en'    => ['required', 'string', 'max:255'],
            'content_fr'  => ['required', 'string'],
            'content_en'  => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status'      => ['required', 'in:draft,published'],
        ]);

        if ($data['status'] === 'published' && !$blog->published_at) {
            $data['published_at'] = now();
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Article mis a jour avec succes.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Article supprime avec succes.');
    }
}
