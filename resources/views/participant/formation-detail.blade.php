<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $formation->getTitle() }} - FormaPro</title>
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

<div class="max-w-4xl mx-auto px-4 py-10">

    <a href="{{ route('participant.formations') }}" class="text-sm text-gray-500 hover:underline">{{ __('ui.actions.back_to_formations') }}</a>

    @php
        $desc = app()->getLocale() === 'fr' ? $formation->short_desc_fr : $formation->short_desc_en;
    @endphp

    <!-- Formation header -->
    <div class="bg-white rounded-xl shadow p-6 mt-4 mb-6">
        <div class="flex gap-4 items-start">
            @if($formation->image)
                <img src="{{ asset('storage/' . $formation->image) }}"
                     class="w-24 h-24 rounded-lg object-cover" alt="{{ $formation->getTitle() }}">
            @else
                <div class="w-24 h-24 rounded-lg bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-3xl">
                    
                </div>
            @endif
            <div class="flex-1">
                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded">
                    {{ $formation->category?->getName() ?? __('ui.formations.uncategorized') }}
                </span>
                <h2 class="text-2xl font-bold mt-2">{{ $formation->getTitle() }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ $desc }}</p>
                <div class="flex gap-4 mt-3 text-sm text-gray-500">
                    <span>{{ $formation->duration_hours }}{{ __('ui.formations.duration') }}</span>
                    @if($formation->price)
                        <span class="font-semibold text-gray-700">{{ formatPrice($formation->price) }}</span>
                    @else
                        <span class="text-green-600 font-semibold">{{ __('ui.formations.free') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <!-- Sessions disponibles -->
    <h3 class="text-lg font-bold mb-4">{{ __('ui.participant.sessions_available') }}</h3>

    @forelse($sessions as $session)
    @php
        $inscrit = in_array($session->id, $userInscriptions);
        $modeVal = $session->mode instanceof \BackedEnum ? $session->mode->value : $session->mode;
        $modeColors = [
            'presentiel' => 'bg-green-100 text-green-700',
            'en_ligne'   => 'bg-purple-100 text-purple-700',
            'hybride'    => 'bg-orange-100 text-orange-700',
        ];
    @endphp
    <div class="bg-white rounded-xl shadow p-5 mb-4">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex gap-2 mb-2">
                    <span class="text-xs px-2 py-1 rounded {{ $modeColors[$modeVal] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ $modeVal }}
                    </span>
                    @if($session->city)
                        <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-600">
                             {{ $session->city }}
                        </span>
                    @endif
                </div>
                <p class="font-semibold text-gray-800">
                    Du {{ \Carbon\Carbon::parse($session->start_date)->format('d/m/Y') }}
                    au {{ \Carbon\Carbon::parse($session->end_date)->format('d/m/Y') }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('ui.participant.trainer') }} : {{ $session->formateur?->name ?? __('ui.participant.to_be_defined') }}
                </p>
                @if($session->meeting_link && $modeVal !== 'presentiel')
                    <a href="{{ $session->meeting_link }}" target="_blank"
                       class="text-xs text-blue-500 hover:underline mt-1 inline-block">
                         {{ __('ui.participant.meeting_link') }}
                    </a>
                @endif
            </div>
            <div class="text-right">
                @php
                    $count = \App\Models\Inscription::where('session_id', $session->id)
                        ->whereIn('status', ['en_attente', 'confirmee'])->count();
                    $places = $session->capacity - $count;
                @endphp
                <p class="text-sm text-gray-500 mb-2">
                    <span class="{{ $places <= 3 ? 'text-red-500 font-semibold' : 'text-gray-600' }}">
                        {{ $places }} {{ __('ui.participant.places_left') }}
                    </span>
                    / {{ $session->capacity }}
                </p>

                @if($inscrit)
                    <span class="bg-green-100 text-green-700 text-xs px-3 py-2 rounded-lg">
                        {{ __('ui.participant.already_registered') }}
                    </span>
                @elseif($places <= 0)
                    <span class="bg-red-100 text-red-600 text-xs px-3 py-2 rounded-lg">
                        {{ __('ui.participant.full') }}
                    </span>
                @else
                    <form method="POST" action="{{ route('participant.inscrire', $session) }}">
                        @csrf
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                            {{ __('ui.actions.subscribe') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow p-8 text-center text-gray-400">
        {{ __('ui.participant.no_sessions') }}
    </div>
    @endforelse

</div>

</body>
</html>





