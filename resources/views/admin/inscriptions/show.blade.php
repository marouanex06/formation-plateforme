<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détail Inscription - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <div class="flex gap-4 text-sm">
        <a href="{{ route('admin.inscriptions.index') }}" class="text-gray-600 hover:text-blue-600">Inscriptions</a>
        <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
            @csrf
            <button class="text-red-500 hover:text-red-700">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Détail de l'inscription</h2>
        <a href="{{ route('admin.inscriptions.index') }}" class="text-sm text-gray-500 hover:underline">← Retour</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow p-6 space-y-4">

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Référence</p>
                <p class="font-mono font-medium">{{ $inscription->reference ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Statut</p>
                @php
                    $colors = [
                        'en_attente' => 'bg-yellow-100 text-yellow-700',
                        'confirmee'  => 'bg-green-100 text-green-700',
                        'annulee'    => 'bg-red-100 text-red-600',
                    ];
                    $statusVal = $inscription->status instanceof \BackedEnum ? $inscription->status->value : $inscription->status;
                    $color = $colors[$statusVal] ?? 'bg-gray-100 text-gray-600';
                @endphp
                <span class="text-xs px-2 py-1 rounded {{ $color }}">{{ $statusVal }}</span>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Participant</p>
                <p class="font-medium">{{ $inscription->user?->name }}</p>
                <p class="text-gray-400 text-xs">{{ $inscription->user?->email }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Date d'inscription</p>
                <p>{{ $inscription->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Formation</p>
                <p>{{ $inscription->session?->formation?->title_fr }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Session</p>
                <p>{{ \Carbon\Carbon::parse($inscription->session?->start_date)->format('d/m/Y') }}
                   → {{ \Carbon\Carbon::parse($inscription->session?->end_date)->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Formateur</p>
                <p>{{ $inscription->session?->formateur?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase mb-1">Mode</p>
                <p>{{ $inscription->session?->mode instanceof \BackedEnum ? $inscription->session->mode->value : $inscription->session?->mode }}</p>
            </div>
        </div>

        @if($statusVal === 'en_attente')
        <div class="flex gap-3 pt-4 border-t">
            <form method="POST" action="{{ route('admin.inscriptions.confirm', $inscription) }}">
                @csrf @method('PATCH')
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                    Confirmer
                </button>
            </form>
            <form method="POST" action="{{ route('admin.inscriptions.cancel', $inscription) }}">
                @csrf @method('PATCH')
                <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600">
                    Annuler
                </button>
            </form>
        </div>
        @endif

    </div>
</div>

</body>
</html>