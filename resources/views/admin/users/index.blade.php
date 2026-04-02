<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utilisateurs - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <div class="flex gap-4 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
        <a href="{{ route('admin.messages.index') }}" class="text-gray-600 hover:text-blue-600">Messages</a>
        <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
            @csrf
            <button class="text-red-500 hover:text-red-700">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Utilisateurs</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.create', ['role' => 'formateur']) }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                + Formateur
            </a>
            <a href="{{ route('admin.users.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                + Ajouter
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nom</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Rôle</th>
                    <th class="px-4 py-3 text-left">Statut</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">
                            {{ $user->roles->first()?->name ?? 'Aucun' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <button onclick="toggleActive({{ $user->id }}, this)"
                                class="text-xs px-2 py-1 rounded {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-500' }}">
                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                        </button>
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="text-blue-600 hover:underline text-xs">Modifier</a>
                        <button onclick="deleteUser({{ $user->id }})"
                                class="text-red-500 hover:underline text-xs">Supprimer</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</div>

<script>
function toggleActive(userId, btn) {
    fetch(`/admin/users/${userId}/toggle-active`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (data.is_active) {
                btn.textContent = 'Actif';
                btn.className = 'text-xs px-2 py-1 rounded bg-green-100 text-green-700';
            } else {
                btn.textContent = 'Inactif';
                btn.className = 'text-xs px-2 py-1 rounded bg-red-100 text-red-500';
            }
        }
    });
}

function deleteUser(userId) {
    if (!confirm('Confirmer la suppression ?')) return;
    fetch(`/admin/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) location.reload();
    });
}
</script>

</body>
</html>
