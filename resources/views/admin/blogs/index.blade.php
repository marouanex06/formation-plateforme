<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-600">FormaPro Admin</a>
    <div class="flex gap-4 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
        <a href="{{ route('admin.blogs.index') }}" class="text-gray-600 hover:text-blue-600">Blog</a>
        <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
            @csrf
            <button class="text-red-500 hover:text-red-700">Deconnexion</button>
        </form>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Articles</h2>
        <a href="{{ route('admin.blogs.create') }}"
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
                    <th class="px-4 py-3 text-left">Categorie</th>
                    <th class="px-4 py-3 text-left">Auteur</th>
                    <th class="px-4 py-3 text-left">Statut</th>
                    <th class="px-4 py-3 text-left">Cree le</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($blogs as $blog)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $blog->title_fr }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $blog->category?->name_fr ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $blog->author?->name ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @php
                            $colors = [
                                'draft' => 'bg-yellow-100 text-yellow-700',
                                'published' => 'bg-green-100 text-green-700',
                            ];
                            $color = $colors[$blog->status] ?? 'bg-gray-100 text-gray-600';
                            $label = $blog->status === 'published' ? 'Publie' : 'Brouillon';
                        @endphp
                        <span class="text-xs px-2 py-1 rounded {{ $color }}">{{ $label }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $blog->created_at?->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 flex gap-2 flex-wrap">
                        <a href="{{ route('admin.blogs.edit', $blog) }}"
                           class="text-blue-600 hover:underline text-xs">Modifier</a>
                        <button onclick="deleteBlog({{ $blog->id }})"
                                class="text-red-500 hover:underline text-xs">Supprimer</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $blogs->links() }}</div>
</div>

<script>
function deleteBlog(id) {
    if (!confirm('Confirmer la suppression ?')) return;
    fetch(`/admin/blogs/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => { if (data.success !== false) location.reload(); });
}
</script>

</body>
</html>
