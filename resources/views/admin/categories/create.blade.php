<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer catégorie - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-blue-600 text-sm">← Retour</a>
</nav>

<div class="max-w-2xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-6">Ajouter une catégorie</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-8">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom en français</label>
                <input type="text" name="name_fr" value="{{ old('name_fr') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom en anglais</label>
                <input type="text" name="name_en" value="{{ old('name_en') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                Créer la catégorie
            </button>
        </form>
    </div>
</div>

</body>
</html>