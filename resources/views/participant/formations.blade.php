<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('ui.nav.formations') }} - FormaPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="#" class="text-xl font-bold text-blue-600">FormaPro</a>
    <div class="flex gap-4 text-sm items-center">
        <a href="{{ route('participant.dashboard') }}" class="text-gray-600 hover:text-blue-600">{{ __('ui.participant.dashboard_title') }}</a>
        <a href="{{ route('participant.formations') }}" class="text-blue-600 font-semibold">{{ __('ui.nav.formations') }}</a>
        <a href="{{ route('blog.index', ['lang' => app()->getLocale()]) }}" class="text-gray-600 hover:text-blue-600">{{ __('ui.nav.blog') }}</a>
        <a href="{{ route('contact.index', ['lang' => app()->getLocale()]) }}" class="text-gray-600 hover:text-blue-600">{{ __('ui.nav.contact') }}</a>
        <span class="text-gray-400">|</span>
        <a href="{{ route('lang.switch', ['lang' => 'fr']) }}" class="{{ app()->getLocale() === 'fr' ? 'text-blue-600 font-semibold' : 'text-gray-500' }}">FR</a>
        <a href="{{ route('lang.switch', ['lang' => 'en']) }}" class="{{ app()->getLocale() === 'en' ? 'text-blue-600 font-semibold' : 'text-gray-500' }}">EN</a>
        <span class="text-gray-400">|</span>
        <span class="text-gray-700 text-xs">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
            @csrf
            <button class="text-red-500 hover:text-red-700">{{ __('ui.nav.logout') }}</button>
        </form>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-2">{{ __('ui.formations.available') }}</h2>
    <p class="text-gray-500 mb-8">{{ __('ui.formations.choose') }}</p>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($formations as $formation)
        @php
            $shortDesc = app()->getLocale() === 'fr' ? $formation->short_desc_fr : $formation->short_desc_en;
        @endphp
        <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden">
            @if($formation->image)
                <img src="{{ asset('storage/' . $formation->image) }}"
                     class="w-full h-40 object-cover" alt="{{ $formation->getTitle() }}">
            @else
                <div class="w-full h-40 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                    <span class="text-white text-4xl"></span>
                </div>
            @endif
            <div class="p-5">
                <span class="text-xs text-blue-600 font-medium bg-blue-50 px-2 py-1 rounded">
                    {{ $formation->category?->getName() ?? __('ui.formations.uncategorized') }}
                </span>
                <h3 class="font-bold text-gray-800 mt-2 mb-1">{{ $formation->getTitle() }}</h3>
                <p class="text-gray-500 text-xs mb-3 line-clamp-2">{{ $shortDesc }}</p>

                <div class="flex justify-between items-center text-xs text-gray-400 mb-4">
                    <span>{{ $formation->duration_hours }}{{ __('ui.formations.duration') }}</span>
                    <span> {{ $formation->sessions->count() }} {{ __('ui.formations.sessions') }}</span>
                    @if($formation->price)
                        <span class="font-semibold text-gray-700">{{ formatPrice($formation->price) }}</span>
                    @else
                        <span class="text-green-600 font-semibold">{{ __('ui.formations.free') }}</span>
                    @endif
                </div>

                <a href="{{ route('participant.formations.show', $formation) }}"
                   class="block text-center bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">
                    {{ __('ui.actions.view') }}
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center text-gray-400 py-12">{{ __('ui.formations.no_formations') }}</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $formations->links() }}</div>
</div>

</body>
</html>



