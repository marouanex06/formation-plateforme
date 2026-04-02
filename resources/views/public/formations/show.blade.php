@extends('layouts.app')

@section('content')

<section class="max-w-4xl mx-auto px-4 py-16">

    <a href="{{ route('formations.index', ['lang' => app()->getLocale()]) }}"
       class="text-blue-600 hover:underline text-sm mb-6 inline-block">
        {{ __('ui.actions.back_to_formations') }}
    </a>

    <div class="bg-white rounded-xl shadow p-8">
        @php
            $shortDesc = app()->getLocale() === 'fr' ? $formation->short_desc_fr : $formation->short_desc_en;
            $fullDesc = app()->getLocale() === 'fr' ? $formation->full_desc_fr : $formation->full_desc_en;
        @endphp

        @if($formation->image)
        <img src="{{ asset('storage/' . $formation->image) }}"
             class="w-full h-64 object-cover rounded-lg mb-6" alt="{{ $formation->getTitle() }}">
        @else
        <div class="w-full h-48 bg-blue-100 rounded-lg mb-6 flex items-center justify-center">
            <span class="text-blue-400 text-6xl"></span>
        </div>
        @endif

        <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">
            {{ $formation->category?->getName() ?? __('ui.formations.uncategorized') }}
        </span>

        <h1 class="text-3xl font-bold mt-4 mb-2">{{ $formation->getTitle() }}</h1>
        <p class="text-gray-500 mb-6">{{ $shortDesc }}</p>

        @if($fullDesc)
        <div class="prose max-w-none text-gray-700 mb-8 border-t pt-6">
            {!! nl2br(e($fullDesc)) !!}
        </div>
        @endif

        <div class="flex items-center justify-between border-t pt-6">
            <div>
                @if($formation->price)
                    <span class="text-2xl font-bold text-blue-600">{{ formatPrice($formation->price) }}</span>
                @else
                    <span class="text-2xl font-bold text-green-600">{{ __('ui.formations.free') }}</span>
                @endif
                @if($formation->duration)
                <span class="text-sm text-gray-500 ml-2">- {{ $formation->duration }}h</span>
                @endif
            </div>
            @auth
            <a href="#"
               class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold">
                {{ __('ui.actions.subscribe') }}
            </a>
            @else
            <a href="{{ route('login', ['lang' => app()->getLocale()]) }}"
               class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold">
                {{ __('ui.actions.login_to_subscribe') }}
            </a>
            @endauth
        </div>
    </div>
</section>

@endsection

