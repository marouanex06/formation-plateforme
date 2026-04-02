<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Message - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <a href="{{ route('admin.messages.index') }}" class="text-gray-600 hover:text-blue-600">← Retour</a>
</nav>

<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="bg-white rounded-xl shadow p-8">
        <h2 class="text-xl font-bold mb-6">{{ $message->subject }}</h2>
        <p class="text-sm text-gray-500 mb-1"><strong>De :</strong> {{ $message->name }} ({{ $message->email }})</p>
        <p class="text-sm text-gray-500 mb-6"><strong>Date :</strong> {{ $message->created_at->format('d/m/Y H:i') }}</p>
        <div class="bg-gray-50 rounded-lg p-4 text-gray-700">
            {{ $message->message }}
        </div>

        <div class="mt-6 flex gap-3">
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}">
                @csrf
                @method('DELETE')
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 text-sm">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>