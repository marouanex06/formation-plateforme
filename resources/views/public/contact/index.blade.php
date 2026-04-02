@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Contactez-nous</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('contact.store', ['lang' => app()->getLocale()]) }}"
          class="bg-white rounded-xl shadow p-8 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Nom</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Message</label>
            <textarea name="message" rows="5"
                      class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('message') }}</textarea>
            @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">
            Envoyer
        </button>
    </form>
</div>
@endsection