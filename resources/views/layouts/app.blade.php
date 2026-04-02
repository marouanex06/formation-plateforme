<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
            <a href="{{ route('home', ['lang' => app()->getLocale()]) }}" class="text-2xl font-bold text-blue-600">
                FormaPro
            </a>
            <div class="hidden md:flex space-x-6 text-sm font-medium">
                <a href="{{ route('home', ['lang' => app()->getLocale()]) }}" class="hover:text-blue-600">{{ __('ui.nav.home') }}</a>
                <a href="{{ route('formations.index', ['lang' => app()->getLocale()]) }}" class="hover:text-blue-600">{{ __('ui.nav.formations') }}</a>
                <a href="{{ route('blog.index', ['lang' => app()->getLocale()]) }}" class="hover:text-blue-600">{{ __('ui.nav.blog') }}</a>
                <a href="{{ route('contact.index', ['lang' => app()->getLocale()]) }}" class="hover:text-blue-600">{{ __('ui.nav.contact') }}</a>
            </div>
            <div class="flex items-center space-x-3 text-sm">
                <a href="{{ route('lang.switch', ['lang' => 'fr']) }}"
                   class="{{ app()->getLocale() === 'fr' ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-blue-600' }}">FR</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('lang.switch', ['lang' => 'en']) }}"
                   class="{{ app()->getLocale() === 'en' ? 'text-blue-600 font-semibold' : 'text-gray-500 hover:text-blue-600' }}">EN</a>
                @auth
                    <a href="{{ route('participant.dashboard') }}" class="text-blue-600 hover:underline">{{ __('ui.nav.my_space') }}</a>
                    @if(auth()->user()->hasRole(['super-admin', 'admin']))
                        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">{{ __('ui.nav.admin') }}</a>
                    @endif
                    <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
                        @csrf
                        <button class="bg-red-500 text-white px-4 py-1.5 rounded hover:bg-red-600">{{ __('ui.nav.logout') }}</button>
                    </form>
                @else
                    <a href="{{ route('login', ['lang' => app()->getLocale()]) }}" class="text-blue-600 hover:underline">{{ __('ui.nav.login') }}</a>
                    <a href="{{ route('register', ['lang' => app()->getLocale()]) }}" class="bg-blue-600 text-white px-4 py-1.5 rounded hover:bg-blue-700">{{ __('ui.nav.register') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 mt-16 py-10">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white font-bold text-lg mb-3">FormaPro</h3>
                <p class="text-sm">{{ __('ui.footer.tagline') }}</p>
            </div>
            <div>
                <h3 class="text-white font-bold text-lg mb-3">{{ __('ui.footer.links') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('formations.index', ['lang' => app()->getLocale()]) }}" class="hover:text-white">{{ __('ui.nav.formations') }}</a></li>
                    <li><a href="{{ route('blog.index', ['lang' => app()->getLocale()]) }}" class="hover:text-white">{{ __('ui.nav.blog') }}</a></li>
                    <li><a href="{{ route('contact.index', ['lang' => app()->getLocale()]) }}" class="hover:text-white">{{ __('ui.nav.contact') }}</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-bold text-lg mb-3">{{ __('ui.footer.contact') }}</h3>
                <p class="text-sm">contact@formapro.com</p>
            </div>
        </div>
    </footer>

</body>
</html>
