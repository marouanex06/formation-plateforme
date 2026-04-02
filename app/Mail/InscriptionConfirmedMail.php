<?php

namespace App\Mail;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InscriptionConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Inscription $inscription
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inscription confirmée — ' . $this->inscription->session->formation->getTitle(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inscription-confirmed',
            with: [
                'inscription' => $this->inscription,
                'session'     => $this->inscription->session,
                'formation'   => $this->inscription->session->formation,
                'user'        => $this->inscription->user,
            ],
        );
    }
}