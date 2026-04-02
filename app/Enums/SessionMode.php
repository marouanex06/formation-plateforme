<?php
// app/Enums/SessionMode.php
// Mode de déroulement d'une session de formation

namespace App\Enums;

enum SessionMode: string
{
    case Presentiel = 'presentiel';
    case EnLigne    = 'en_ligne';
    case Hybride    = 'hybride';

    public function label(): string
    {
        return match($this) {
            self::Presentiel => 'Présentiel',
            self::EnLigne    => 'En ligne',
            self::Hybride    => 'Hybride',
        };
    }
}