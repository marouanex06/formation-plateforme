<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Mail\ContactMessageMail;
use App\Http\Requests\StoreContactMessageRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.contact');
    }

    // ✅ AJAX — retourne JSON
    public function store(StoreContactMessageRequest $request)
{
    // 1. Sauvegarder en BD d'abord
    $message = ContactMessage::create($request->validated());

    // 2. Envoyer le mail sans bloquer
    try {
        Mail::to(config('mail.admin_address', 'admin@example.com'))
            ->send(new ContactMessageMail($message));
    } catch (\Exception $e) {
        Log::error('Mail contact failed: ' . $e->getMessage());
    }

    // 3. Toujours retourner success
    return response()->json([
        'success' => true,
        'message' => __('contact.sent_successfully'),
    ]);
}
}