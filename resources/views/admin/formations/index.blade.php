<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formations - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <div class="flex gap-4 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-blue-600">Catégories</a>
        <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
            @csrf
            <button class="text-red-500 hover:text-red-700">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Formations</h2>
        <a href="{{ route('admin.formations.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
            + Ajouter
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Titre FR</th>
                    <th class="px-4 py-3 text-left">Catégorie</th>
                    <th class="px-4 py-3 text-left">Prix</th>
                    <th class="px-4 py-3 text-left">Statut</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($formations as $formation)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $formation->title_fr }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $formation->category?->name_fr }}</td>
                    <td class="px-4 py-3">{{ number_format($formation->price, 2) }} MAD</td>
                    <td class="px-4 py-3">
                        @php
                            $colors = [
                                'brouillon' => 'bg-yellow-100 text-yellow-700',
                                'publie'    => 'bg-green-100 text-green-700',
                                'archive'   => 'bg-gray-100 text-gray-600',
                            ];
                            $color = $colors[$formation->status->value] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="text-xs px-2 py-1 rounded {{ $color }}">
                            {{ $formation->status->label() }}
                        </span>
                    </td>
                    <td class="px-4 py-3 flex gap-2 flex-wrap">
                        @if($formation->status->value !== 'publie')
                        <button onclick="publishFormation({{ $formation->id }})"
                                class="text-green-600 hover:underline text-xs">Publier</button>
                        @endif
                        <a href="{{ route('admin.formations.edit', $formation) }}"
                           class="text-blue-600 hover:underline text-xs">Modifier</a>
                        <button onclick="deleteFormation({{ $formation->id }})"
                                class="text-red-500 hover:underline text-xs">Supprimer</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $formations->links() }}</div>
</div>

<script>
function publishFormation(id) {
    fetch(`/admin/formations/${id}/publish`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => { if (data.success) location.reload(); });
}

function deleteFormation(id) {
    if (!confirm('Confirmer la suppression ?')) return;
    fetch(`/admin/formations/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => { if (data.success) location.reload(); });
}
</script>

</body>
</html>