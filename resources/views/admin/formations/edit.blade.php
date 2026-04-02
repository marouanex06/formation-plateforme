<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier formation - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <a href="{{ route('admin.formations.index') }}" class="text-gray-600 hover:text-blue-600 text-sm">← Retour</a>
</nav>

<div class="max-w-3xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-6">Modifier la formation</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-8">
        <form method="POST" action="{{ route('admin.formations.update', $formation) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                <select name="category_id" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $formation->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name_fr }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titre FR</label>
                    <input type="text" name="title_fr" value="{{ old('title_fr', $formation->title_fr) }}"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titre EN</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $formation->title_en) }}"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description courte FR</label>
                    <textarea name="short_desc_fr" rows="3"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('short_desc_fr', $formation->short_desc_fr) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description courte EN</label>
                    <textarea name="short_desc_en" rows="3"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('short_desc_en', $formation->short_desc_en) }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prix (MAD)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $formation->price) }}"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durée</label>
                    <input type="text" name="duration" value="{{ old('duration', $formation->duration) }}"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Niveau</label>
                    <input type="text" name="level" value="{{ old('level', $formation->level) }}"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="status" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" {{ $formation->status->value == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                    @if($formation->image)
                        <img src="{{ asset('storage/' . $formation->image) }}" class="h-16 mb-2 rounded">
                    @endif
                    <input type="file" name="image" accept="image/*"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                Enregistrer les modifications
            </button>
        </form>
    </div>
</div>

</body>
</html>
