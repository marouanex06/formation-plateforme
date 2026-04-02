<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 text-white flex flex-col">

        {{-- Logo --}}
        <div class="h-16 flex items-center justify-center border-b border-gray-700">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-400">
                FormaPro Admin
            </a>
        </div>

        {{-- Menu --}}
        <nav class="flex-1 px-4 py-6 space-y-2 text-sm">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                📊 Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                👥 Utilisateurs
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}">
                📁 Catégories
            </a>

            <a href="{{ route('admin.formations.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.formations.*') ? 'bg-gray-700' : '' }}">
                🎓 Formations
            </a>

            <a href="{{ route('admin.sessions.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.sessions.*') ? 'bg-gray-700' : '' }}">
                📅 Sessions
            </a>

            <a href="{{ route('admin.inscriptions.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.inscriptions.*') ? 'bg-gray-700' : '' }}">
                📝 Inscriptions
            </a>

            <a href="{{ route('admin.blogs.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.blogs.*') ? 'bg-gray-700' : '' }}">
                ✍️ Blog
            </a>

            <a href="{{ route('admin.messages.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.messages.*') ? 'bg-gray-700' : '' }}">
                💬 Messages
            </a>

        </nav>

        {{-- User + Logout --}}
        <div class="border-t border-gray-700 px-4 py-4">
            <p class="text-xs text-gray-400 mb-2">{{ auth()->user()->name }}</p>
            <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
                @csrf
                <button class="w-full text-left text-sm text-red-400 hover:text-red-300">
                    🚪 Déconnexion
                </button>
            </form>
        </div>

    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-auto">

        {{-- Top Bar --}}
        <header class="h-16 bg-white shadow flex items-center justify-between px-6">
            <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
            <span class="text-sm text-gray-500">
                {{ auth()->user()->name }} —
                {{ auth()->user()->getRoleNames()->first() }}
            </span>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mx-6 mt-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 mt-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>