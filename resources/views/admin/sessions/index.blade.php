<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sessions - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <div class="flex gap-4 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
        <a href="{{ route('admin.formations.index') }}" class="text-gray-600 hover:text-blue-600">Formations</a>
        <a href="{{ route('admin.sessions.index') }}" class="text-blue-600 font-semibold">Sessions</a>
        <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
            @csrf
            <button class="text-red-500 hover:text-red-700">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Sessions de formation</h2>
        <a href="{{ route('admin.sessions.create') }}"
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
                    <th class="px-4 py-3 text-left">Formation</th>
                    <th class="px-4 py-3 text-left">Formateur</th>
                    <th class="px-4 py-3 text-left">Début</th>
                    <th class="px-4 py-3 text-left">Fin</th>
                    <th class="px-4 py-3 text-left">Mode</th>
                    <th class="px-4 py-3 text-left">Capacité</th>
                    <th class="px-4 py-3 text-left">Statut</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sessions as $session)
                <tr id="session-row-{{ $session->id }}">
                    <td class="px-4 py-3 font-medium">{{ $session->formation?->title_fr }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $session->formateur?->name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($session->start_date)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($session->end_date)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700">
                            {{ $session->mode instanceof \App\Enums\SessionMode ? $session->mode->value : $session->mode }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $session->capacity }}</td>
                    <td class="px-4 py-3">
                        @php
                            $colors = [
                                'planifiee' => 'bg-yellow-100 text-yellow-700',
                                'en_cours'  => 'bg-blue-100 text-blue-700',
                                'terminee'  => 'bg-gray-100 text-gray-600',
                                'annulee'   => 'bg-red-100 text-red-600',
                            ];
                            $statusVal = $session->status instanceof \BackedEnum ? $session->status->value : $session->status;
                            $color = $colors[$statusVal] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="text-xs px-2 py-1 rounded {{ $color }}">{{ $statusVal }}</span>
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('admin.sessions.edit', $session) }}"
                           class="text-blue-600 hover:underline text-xs">Modifier</a>
                        <button data-session-id="{{ $session->id }}"
                                onclick="deleteSession(this.dataset.sessionId)"
                                class="text-red-500 hover:underline text-xs">Supprimer</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-6 text-center text-gray-400">Aucune session trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $sessions->links() }}</div>
</div>

<script>
function deleteSession(id) {
    if (!confirm('Confirmer la suppression ?')) return;
    fetch(`/admin/sessions/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('session-row-' + id).remove();
        }
    });
}
</script>

</body>
</html>