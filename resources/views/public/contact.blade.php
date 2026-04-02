@extends('layouts.app')

@section('content')

<section class="max-w-2xl mx-auto px-4 py-16">
    <h1 class="text-3xl font-bold mb-8 text-center">{{ __('ui.contact.title') }}</h1>

    <div id="success-message" class="hidden bg-green-100 text-green-700 px-4 py-3 rounded mb-6">
        {{ __('ui.contact.success') }}
    </div>

    <div id="error-message" class="hidden bg-red-100 text-red-700 px-4 py-3 rounded mb-6">
        {{ __('ui.contact.error') }}
    </div>

    <div class="bg-white rounded-xl shadow p-8">
        <form id="contact-form">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.contact.name') }}</label>
                <input type="text" name="name"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-red-500 text-xs mt-1 hidden name-error"></p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.contact.email') }}</label>
                <input type="email" name="email"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-red-500 text-xs mt-1 hidden email-error"></p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.contact.phone') }}</label>
                <input type="text" name="phone"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-red-500 text-xs mt-1 hidden phone-error"></p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.contact.subject') }}</label>
                <input type="text" name="subject"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-red-500 text-xs mt-1 hidden subject-error"></p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.contact.message') }}</label>
                <textarea name="message" rows="5"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                <p class="text-red-500 text-xs mt-1 hidden message-error"></p>
            </div>

            <button type="submit" id="submit-btn"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                {{ __('ui.actions.send_message') }}
            </button>
        </form>
    </div>
</section>

<script>
document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const btn = document.getElementById('submit-btn');
    btn.textContent = '{{ __('ui.actions.sending') }}';
    btn.disabled = true;

    const formData = new FormData(this);

    fetch('{{ route("contact.store", ["lang" => app()->getLocale()]) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('success-message').classList.remove('hidden');
            document.getElementById('contact-form').reset();
        } else {
            document.getElementById('error-message').classList.remove('hidden');
        }
        btn.textContent = '{{ __('ui.actions.send_message') }}';
        btn.disabled = false;
    })
    .catch(() => {
        document.getElementById('error-message').classList.remove('hidden');
        btn.textContent = '{{ __('ui.actions.send_message') }}';
        btn.disabled = false;
    });
});
</script>

@endsection
