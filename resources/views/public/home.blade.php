@extends('layouts.app')

@section('content')

    <section class="bg-blue-600 text-white py-24 px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ __('ui.home.hero_title') }}</h1>
        <p class="text-lg md:text-xl mb-8 text-blue-100">{{ __('ui.home.hero_subtitle') }}</p>
        <a href="{{ route('formations.index', ['lang' => app()->getLocale()]) }}"
           class="bg-white text-blue-600 font-semibold px-8 py-3 rounded-full hover:bg-blue-50 transition">
            {{ __('ui.actions.view_formations') }}
        </a>
    </section>

    @if($categories->count())
    <section class="max-w-7xl mx-auto px-4 py-16">
        <h2 class="text-2xl font-bold mb-8 text-center">{{ __('ui.home.categories') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($categories as $category)
            <a href="{{ route('formations.index', ['lang' => app()->getLocale()]) }}"
               class="bg-white rounded-xl shadow p-6 text-center hover:shadow-md transition">
                <p class="font-semibold text-gray-700">{{ $category->getName() }}</p>
                <p class="text-sm text-blue-500 mt-1">{{ __('ui.formations.count', ['count' => $category->formations_count]) }}</p>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    @if($formations->count())
    <section class="bg-gray-100 py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl font-bold mb-8 text-center">{{ __('ui.home.recent_formations') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($formations as $formation)
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
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($blogs->count())
    <section class="max-w-7xl mx-auto px-4 py-16">
        <h2 class="text-2xl font-bold mb-8 text-center">{{ __('ui.home.latest_articles') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($blogs as $blog)
            @php
                $content = app()->getLocale() === 'fr' ? $blog->content_fr : $blog->content_en;
            @endphp
            <div class="bg-white rounded-xl shadow hover:shadow-md transition p-5">
                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full">
                    {{ $blog->created_at->format('d/m/Y') }}
                </span>
                <h3 class="font-bold mt-2 mb-1">{{ $blog->getTitle() }}</h3>
                <p class="text-sm text-gray-500 line-clamp-3">{{ $content }}</p>
                <a href="{{ route('blog.show', ['lang' => app()->getLocale(), 'slug' => $blog->getSlug() ?: $blog->id]) }}"
                   class="inline-block mt-4 text-blue-600 text-sm hover:underline">
                    {{ __('ui.actions.read_more') }}
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

@endsection

