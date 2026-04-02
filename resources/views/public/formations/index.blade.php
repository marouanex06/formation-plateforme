@extends('layouts.app')

@section('content')

<section class="bg-blue-600 text-white py-16 px-4 text-center">
    <h1 class="text-4xl font-bold mb-2">{{ __('ui.formations.title') }}</h1>
    <p class="text-blue-100">{{ __('ui.formations.subtitle') }}</p>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">

    <form method="GET" action="{{ route('formations.index', ['lang' => app()->getLocale()]) }}"
          class="flex gap-3 mb-10">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="{{ __('ui.formations.search_placeholder') }}"
               class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            {{ __('ui.formations.search_button') }}
        </button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($formations as $formation)
        @php
            $shortDesc = app()->getLocale() === 'fr' ? $formation->short_desc_fr : $formation->short_desc_en;
        @endphp
        <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden">
            <div class="bg-blue-100 h-40 flex items-center justify-center">
                @if($formation->image)
                    <img src="{{ asset('storage/' . $formation->image) }}"
                         class="h-full w-full object-cover" alt="{{ $formation->getTitle() }}">
                @else
                    <span class="text-blue-400 text-5xl"></span>
                @endif
            </div>
            <div class="p-5">
                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">
                    {{ $formation->category?->getName() ?? __('ui.formations.uncategorized') }}
                </span>
                <h3 class="font-bold mt-2 mb-1">{{ $formation->getTitle() }}</h3>
                <p class="text-sm text-gray-500 line-clamp-2">{{ $shortDesc }}</p>
                <div class="flex items-center justify-between mt-4">
                    @if($formation->price)
                        <span class="text-blue-600 font-bold">{{ formatPrice($formation->price) }}</span>
                    @else
                        <span class="text-green-600 font-semibold">{{ __('ui.formations.free') }}</span>
                    @endif
                    <a href="{{ route('formations.show', ['lang' => app()->getLocale(), 'slug' => $formation->getSlug() ?: $formation->id]) }}"
                       class="text-sm bg-blue-600 text-white px-4 py-1.5 rounded hover:bg-blue-700">
                        {{ __('ui.actions.view') }}
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-500">
            <p class="text-xl mb-2">{{ __('ui.formations.no_formations') }}</p>
            <p class="text-sm">{{ __('ui.formations.come_back') }}</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $formations->links() }}</div>
</section>

@endsection

