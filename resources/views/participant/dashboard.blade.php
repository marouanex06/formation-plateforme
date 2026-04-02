<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('ui.participant.dashboard_title') }} - FormaPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="#" class="text-xl font-bold text-blue-600">FormaPro</a>
    <div class="flex gap-4 text-sm items-center">
        <a href="{{ route('participant.dashboard') }}" class="text-blue-600 font-semibold">{{ __('ui.participant.dashboard_title') }}</a>
        <a href="{{ route('participant.formations') }}" class="text-gray-600 hover:text-blue-600">{{ __('ui.nav.formations') }}</a>
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

<div class="max-w-5xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-2">{{ __('ui.participant.hello', ['name' => auth()->user()->name]) }}</h2>
    <p class="text-gray-500 mb-8">{{ __('ui.participant.overview') }}</p>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-4 mb-8">
        @php
            $total     = $inscriptions->count();
            $confirmed = $inscriptions->filter(fn($i) => (($i->status instanceof \BackedEnum ? $i->status->value : $i->status) === 'confirmee'))->count();
            $pending   = $inscriptions->filter(fn($i) => (($i->status instanceof \BackedEnum ? $i->status->value : $i->status) === 'en_attente'))->count();
        @endphp
        <a href="#inscriptions" class="bg-white rounded-xl shadow p-5 text-center hover:shadow-md transition block">
            <p class="text-3xl font-bold text-blue-600">{{ $total }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ __('ui.participant.total') }}</p>
        </a>
        <a href="#inscriptions" class="bg-white rounded-xl shadow p-5 text-center hover:shadow-md transition block">
            <p class="text-3xl font-bold text-green-600">{{ $confirmed }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ __('ui.participant.confirmed') }}</p>
        </a>
        <a href="#inscriptions" class="bg-white rounded-xl shadow p-5 text-center hover:shadow-md transition block">
            <p class="text-3xl font-bold text-yellow-500">{{ $pending }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ __('ui.participant.pending') }}</p>
        </a>
    </div>

    <!-- Inscriptions -->
    <div id="inscriptions" class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-700">{{ __('ui.participant.my_inscriptions') }}</h3>
            <a href="{{ route('participant.formations') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                + {{ __('ui.participant.subscribe') }}
            </a>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">{{ __('ui.participant.reference') }}</th>
                    <th class="px-4 py-3 text-left">{{ __('ui.participant.formation') }}</th>
                    <th class="px-4 py-3 text-left">{{ __('ui.participant.session_date') }}</th>
                    <th class="px-4 py-3 text-left">{{ __('ui.participant.status') }}</th>
                    <th class="px-4 py-3 text-left">{{ __('ui.participant.action') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($inscriptions as $inscription)
                @php
                    $statusVal = $inscription->status instanceof \BackedEnum ? $inscription->status->value : $inscription->status;
                    $colors = [
                        'en_attente' => 'bg-yellow-100 text-yellow-700',
                        'confirmee'  => 'bg-green-100 text-green-700',
                        'annulee'    => 'bg-red-100 text-red-600',
                    ];
                @endphp
                <tr>
                    <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $inscription->reference }}</td>
                    <td class="px-4 py-3 font-medium">{{ $inscription->session?->formation?->getTitle() }}</td>
                    <td class="px-4 py-3 text-gray-500">
                        {{ \Carbon\Carbon::parse($inscription->session?->start_date)->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-1 rounded {{ $colors[$statusVal] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $statusVal }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($statusVal === 'en_attente')
                        <form method="POST" action="{{ route('participant.annuler', $inscription) }}">
                            @csrf @method('PATCH')
                            <button class="text-red-500 hover:underline text-xs">{{ __('ui.actions.cancel') }}</button>
                        </form>
                        @else
                        <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                        {{ __('ui.participant.no_inscriptions') }}
                        <a href="{{ route('participant.formations') }}" class="text-blue-600 hover:underline">
                            {{ __('ui.participant.browse_formations') }}
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>



