<?php

namespace App\Notifications;

use App\Models\Inscription;
use App\Mail\InscriptionConfirmedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class InscriptionConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Inscription $inscription
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): InscriptionConfirmedMail
    {
        return new InscriptionConfirmedMail($this->inscription);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'      => 'Votre inscription a été confirmée.',
            'formation'    => $this->inscription->session->formation->getTitle(),
            'reference'    => $this->inscription->reference,
        ];
    }
}