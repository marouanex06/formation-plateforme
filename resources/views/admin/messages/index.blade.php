<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Messages - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <div class="flex gap-4">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
        <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
            @csrf
            <button class="text-red-500 hover:text-red-700">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="max-w-5xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-6">Messages de contact</h2>

    @if($messages->isEmpty())
        <div class="bg-white rounded-xl shadow p-6 text-gray-500">Aucun message reçu.</div>
    @else
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Nom</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Sujet</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Statut</th>
                        <th class="px-4 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($messages as $message)
                    <tr class="{{ $message->is_read ? '' : 'bg-blue-50 font-semibold' }}">
                        <td class="px-4 py-3">{{ $message->name }}</td>
                        <td class="px-4 py-3">{{ $message->email }}</td>
                        <td class="px-4 py-3">{{ $message->subject }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            @if($message->is_read)
                                <span class="text-green-600 text-xs">Lu</span>
                            @else
                                <span class="text-red-500 text-xs">Non lu</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.messages.show', $message) }}"
                               class="text-blue-600 hover:underline text-xs">Voir</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    @endif
</div>

</body>
</html>