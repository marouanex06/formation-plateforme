<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('ui.admin.dashboard') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-blue-600">FormaPro Admin</h1>
    <div class="flex gap-4 items-center">
        <a href="{{ route('admin.blogs.index') }}" class="text-gray-600 hover:text-blue-600">{{ __('ui.nav.blog') }}</a>
        <a href="{{ route('admin.messages.index') }}" class="text-gray-600 hover:text-blue-600">{{ __('ui.nav.contact') }}</a>
        <span class="text-gray-300">|</span>
        <a href="{{ route('lang.switch', ['lang' => 'fr']) }}" class="{{ app()->getLocale() === 'fr' ? 'text-blue-600 font-semibold' : 'text-gray-500' }}">FR</a>
        <a href="{{ route('lang.switch', ['lang' => 'en']) }}" class="{{ app()->getLocale() === 'en' ? 'text-blue-600 font-semibold' : 'text-gray-500' }}">EN</a>
        <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
            @csrf
            <button class="text-red-500 hover:text-red-700">{{ __('ui.nav.logout') }}</button>
        </form>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-8">{{ __('ui.admin.dashboard') }}</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('admin.users.index') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-md transition block">
            <p class="text-gray-500 text-sm">{{ __('ui.admin.users') }}</p>
            <p class="text-3xl font-bold mt-2">{{ $stats['total_users'] }}</p>
        </a>
        <a href="{{ route('admin.formations.index') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-md transition block">
            <p class="text-gray-500 text-sm">{{ __('ui.admin.formations') }}</p>
            <p class="text-3xl font-bold mt-2">{{ $stats['total_formations'] }}</p>
        </a>
        <a href="{{ route('admin.sessions.index') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-md transition block">
            <p class="text-gray-500 text-sm">{{ __('ui.admin.sessions') }}</p>
            <p class="text-3xl font-bold mt-2">{{ $stats['total_sessions'] }}</p>
        </a>
        <a href="{{ route('admin.inscriptions.index') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-md transition block">
            <p class="text-gray-500 text-sm">{{ __('ui.admin.inscriptions') }}</p>
            <p class="text-3xl font-bold mt-2">{{ $stats['total_inscriptions'] }}</p>
        </a>
        <a href="{{ route('admin.inscriptions.index') }}" class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-400 hover:shadow-md transition block">
            <p class="text-gray-500 text-sm">{{ __('ui.admin.pending_inscriptions') }}</p>
            <p class="text-3xl font-bold mt-2 text-yellow-500">{{ $stats['pending_inscriptions'] }}</p>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="bg-white rounded-xl shadow p-6 border-l-4 border-red-400 hover:shadow-md transition block">
            <p class="text-gray-500 text-sm">{{ __('ui.admin.unread_messages') }}</p>
            <p class="text-3xl font-bold mt-2 text-red-500">
                {{ $stats['unread_messages'] }}
            </p>
        </a>
    </div>
</div>

</body>
</html>

