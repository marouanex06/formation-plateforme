@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-12">
    @php
        $content = app()->getLocale() === 'fr' ? $blog->content_fr : $blog->content_en;
    @endphp

    <div class="bg-white rounded-xl shadow p-8">
        <div class="text-xs text-gray-400 mb-2">{{ $blog->created_at->format('d/m/Y') }}</div>
        <h1 class="text-3xl font-bold mb-4">{{ $blog->getTitle() }}</h1>
        <div class="prose max-w-none text-gray-700">
            {!! nl2br(e($content)) !!}
        </div>
    </div>

    @if($recentBlogs->count())
    <div class="mt-10">
        <h2 class="text-xl font-semibold mb-4">{{ __('ui.home.latest_articles') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($recentBlogs as $recent)
            <a href="{{ route('blog.show', ['lang' => app()->getLocale(), 'slug' => $recent->getSlug() ?: $recent->id]) }}"
               class="bg-white rounded-lg shadow p-4 hover:shadow-md transition">
                <p class="text-sm text-gray-500">{{ $recent->created_at->format('d/m/Y') }}</p>
                <p class="font-semibold mt-1">{{ $recent->getTitle() }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</section>
@endsection
