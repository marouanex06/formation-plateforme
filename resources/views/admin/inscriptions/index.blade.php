<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscriptions - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <div class="flex gap-4 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
        <a href="{{ route('admin.sessions.index') }}" class="text-gray-600 hover:text-blue-600">Sessions</a>
        <a href="{{ route('admin.inscriptions.index') }}" class="text-blue-600 font-semibold">Inscriptions</a>
        <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
            @csrf
            <button class="text-red-500 hover:text-red-700">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Inscriptions</h2>
        <!-- Recherche instantanée AJAX -->
        <input type="text" id="search" placeholder="Rechercher..."
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Référence</th>
                    <th class="px-4 py-3 text-left">Participant</th>
                    <th class="px-4 py-3 text-left">Formation</th>
                    <th class="px-4 py-3 text-left">Session</th>
                    <th class="px-4 py-3 text-left">Statut</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="inscriptions-table" class="divide-y divide-gray-100">
                @forelse($inscriptions as $inscription)
                <tr id="row-{{ $inscription->id }}">
                    <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $inscription->reference ?? '—' }}</td>
                    <td class="px-4 py-3 font-medium">{{ $inscription->user?->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $inscription->session?->formation?->title_fr }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs">
                        {{ \Carbon\Carbon::parse($inscription->session?->start_date)->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $colors = [
                                'en_attente' => 'bg-yellow-100 text-yellow-700',
                                'confirmee'  => 'bg-green-100 text-green-700',
                                'annulee'    => 'bg-red-100 text-red-600',
                            ];
                            $statusVal = $inscription->status instanceof \BackedEnum ? $inscription->status->value : $inscription->status;
                            $color = $colors[$statusVal] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span id="badge-{{ $inscription->id }}" class="text-xs px-2 py-1 rounded {{ $color }}">
                            {{ $statusVal }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-500">
                        {{ $inscription->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3 flex gap-2 flex-wrap">
                        @if($statusVal === 'en_attente')
                            <button type="button" data-action="confirm-inscription" data-id="{{ $inscription->id }}"
                                    class="text-green-600 hover:underline text-xs font-medium">Confirmer</button>
                            <button type="button" data-action="cancel-inscription" data-id="{{ $inscription->id }}"
                                    class="text-orange-500 hover:underline text-xs">Annuler</button>
                        @endif
                        <a href="{{ route('admin.inscriptions.show', $inscription) }}"
                           class="text-blue-600 hover:underline text-xs">Détail</a>
                        <button type="button" data-action="delete-inscription" data-id="{{ $inscription->id }}"
                                class="text-red-500 hover:underline text-xs">Supprimer</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">Aucune inscription trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $inscriptions->links() }}</div>
</div>

<script>
const csrfToken = '{{ csrf_token() }}';

// Confirmer inscription via AJAX
function confirmInscription(id) {
    fetch(`/admin/inscriptions/${id}/confirm`, {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('badge-' + id);
            badge.className = 'text-xs px-2 py-1 rounded bg-green-100 text-green-700';
            badge.textContent = 'confirmee';
            // Cacher les boutons confirmer/annuler
            location.reload();
        }
    });
}

// Annuler inscription via AJAX
function cancelInscription(id) {
    if (!confirm('Annuler cette inscription ?')) return;
    fetch(`/admin/inscriptions/${id}/cancel`, {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('badge-' + id);
            badge.className = 'text-xs px-2 py-1 rounded bg-red-100 text-red-600';
            badge.textContent = 'annulee';
            location.reload();
        }
    });
}

// Supprimer sans rechargement
function deleteInscription(id) {
    if (!confirm('Supprimer cette inscription ?')) return;
    fetch(`/admin/inscriptions/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('row-' + id).remove();
        }
    });
}

// Actions dynamiques basées sur data-action
document.querySelectorAll('[data-action]').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;
        if (!id) return;
        switch (this.dataset.action) {
            case 'confirm-inscription': return confirmInscription(id);
            case 'cancel-inscription': return cancelInscription(id);
            case 'delete-inscription': return deleteInscription(id);
        }
    });
});

// Recherche instantanée
document.getElementById('search').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    document.querySelectorAll('#inscriptions-table tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(query) ? '' : 'none';
    });
});
</script>

</body>
</html>