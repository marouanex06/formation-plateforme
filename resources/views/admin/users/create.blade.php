<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creer utilisateur - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-blue-600 text-sm">Retour</a>
</nav>

<div class="max-w-2xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-6">Ajouter un utilisateur</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-8">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Telephone</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            @php
                $selectedRole = request('role');
            @endphp
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role', $selectedRole) == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Langue</label>
                <select name="language" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>Francais</option>
                    <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>

            <div class="mb-6 flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" checked id="is_active">
                <label for="is_active" class="text-sm text-gray-700">Compte actif</label>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                Creer l'utilisateur
            </button>
        </form>
    </div>
</div>

</body>
</html>
