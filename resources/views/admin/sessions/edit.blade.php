<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Session - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <div class="flex gap-4 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
        <a href="{{ route('admin.sessions.index') }}" class="text-gray-600 hover:text-blue-600">Sessions</a>
        <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
            @csrf
            <button class="text-red-500 hover:text-red-700">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Modifier la session</h2>
        <a href="{{ route('admin.sessions.index') }}" class="text-sm text-gray-500 hover:underline">← Retour</a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6">
        <form method="POST" action="{{ route('admin.sessions.update', $session) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Formation -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Formation</label>
                    <select name="formation_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Choisir une formation --</option>
                        @foreach($formations as $formation)
                            <option value="{{ $formation->id }}"
                                {{ old('formation_id', $session->formation_id) == $formation->id ? 'selected' : '' }}>
                                {{ $formation->title_fr }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Formateur -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Formateur</label>
                    <select name="user_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Aucun formateur --</option>
                        @foreach($formateurs as $formateur)
                            <option value="{{ $formateur->id }}"
                                {{ old('user_id', $session->user_id) == $formateur->id ? 'selected' : '' }}>
                                {{ $formateur->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date début -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                    <input type="date" name="start_date" required
                           value="{{ old('start_date', \Carbon\Carbon::parse($session->start_date)->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Date fin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                    <input type="date" name="end_date" required
                           value="{{ old('end_date', \Carbon\Carbon::parse($session->end_date)->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Capacité -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Capacité (places)</label>
                    <input type="number" name="capacity" min="1" required
                           value="{{ old('capacity', $session->capacity) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Mode -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mode</label>
                    <select name="mode" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($modes as $mode)
                            <option value="{{ $mode->value }}"
                                {{ old('mode', $session->mode instanceof \BackedEnum ? $session->mode->value : $session->mode) == $mode->value ? 'selected' : '' }}>
                                {{ $mode->value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Ville -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ville <span class="text-gray-400 text-xs">(optionnel)</span></label>
                    <input type="text" name="city"
                           value="{{ old('city', $session->city) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ex: Casablanca">
                </div>

                <!-- Lien réunion -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lien réunion <span class="text-gray-400 text-xs">(optionnel)</span></label>
                    <input type="url" name="meeting_link"
                           value="{{ old('meeting_link', $session->meeting_link) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://meet.google.com/...">
                </div>

            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                    Enregistrer
                </button>
                <a href="{{ route('admin.sessions.index') }}"
                   class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 text-sm">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>