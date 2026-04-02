@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">{{ __('ui.blog.title') }}</h1>
    @if($blogs->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($blogs as $blog)
            @php
                $content = app()->getLocale() === 'fr' ? $blog->content_fr : $blog->content_en;
            @endphp
            <div class="bg-white rounded-xl shadow p-5 hover:shadow-md transition">
                <span class="text-xs text-gray-400">{{ $blog->created_at->format('d/m/Y') }}</span>
                <h3 class="font-bold mt-1 mb-2">{{ $blog->getTitle() }}</h3>
                <p class="text-sm text-gray-500 line-clamp-3">{{ $content }}</p>
                <a href="{{ route('blog.show', ['lang' => app()->getLocale(), 'slug' => $blog->getSlug() ?: $blog->id]) }}"
                   class="inline-block mt-3 text-blue-600 text-sm hover:underline">{{ __('ui.actions.read_more') }}</a>
            </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $blogs->links() }}</div>
    @else
        <p class="text-gray-500">{{ __('ui.blog.empty') }}</p>
    @endif
</div>
@endsection
