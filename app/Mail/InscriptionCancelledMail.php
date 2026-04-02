<?php

namespace App\Mail;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InscriptionCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Inscription $inscription
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inscription annulée',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inscription-cancelled',
            with: [
                'inscription' => $this->inscription,
                'formation'   => $this->inscription->session->formation,
                'user'        => $this->inscription->user,
            ],
        );
    }
}