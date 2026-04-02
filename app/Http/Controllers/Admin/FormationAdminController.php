<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Category;
use App\Enums\FormationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormationAdminController extends Controller
{
    public function index()
    {
        $formations = Formation::with('category')->latest()->paginate(15);
        return view('admin.formations.index', compact('formations'));
    }

    public function create()
    {
        $categories = Category::all();
        $statuses   = FormationStatus::cases();
        return view('admin.formations.create', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'   => ['required', 'exists:categories,id'],
            'title_fr'      => ['required', 'string', 'max:255'],
            'title_en'      => ['required', 'string', 'max:255'],
            'short_desc_fr' => ['required', 'string'],
            'short_desc_en' => ['required', 'string'],
            'full_desc_fr'  => ['nullable', 'string'],
            'full_desc_en'  => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'duration'      => ['required', 'string', 'max:100'],
            'level'         => ['required', 'string', 'max:100'],
            'status'        => ['required', 'in:brouillon,publie,archive'],
            'image'         => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('formations', 'public');
        }

        if ($data['status'] === 'publie') {
            $data['published_at'] = now();
        }

        Formation::create($data);

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation créée avec succès.');
    }

    public function show(Formation $formation)
    {
        return view('admin.formations.show', compact('formation'));
    }

    public function edit(Formation $formation)
    {
        $categories = Category::all();
        $statuses   = FormationStatus::cases();
        return view('admin.formations.edit', compact('formation', 'categories', 'statuses'));
    }

    public function update(Request $request, Formation $formation)
    {
        $request->validate([
            'category_id'   => ['required', 'exists:categories,id'],
            'title_fr'      => ['required', 'string', 'max:255'],
            'title_en'      => ['required', 'string', 'max:255'],
            'short_desc_fr' => ['required', 'string'],
            'short_desc_en' => ['required', 'string'],
            'full_desc_fr'  => ['nullable', 'string'],
            'full_desc_en'  => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'duration'      => ['required', 'string', 'max:100'],
            'level'         => ['required', 'string', 'max:100'],
            'status'        => ['required', 'in:brouillon,publie,archive'],
            'image'         => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($formation->image) {
                Storage::disk('public')->delete($formation->image);
            }
            $data['image'] = $request->file('image')->store('formations', 'public');
        }

        if ($data['status'] === 'publie' && !$formation->published_at) {
            $data['published_at'] = now();
        }

        $formation->update($data);

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation mise à jour.');
    }

    public function destroy(Formation $formation)
    {
        if ($formation->image) {
            Storage::disk('public')->delete($formation->image);
        }
        $formation->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation supprimée.');
    }

    public function publish(Formation $formation)
    {
        $formation->update([
            'status'       => FormationStatus::Publie,
            'published_at' => now(),
        ]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Formation publiée.');
    }
}