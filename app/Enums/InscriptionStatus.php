<?php
// app/Enums/InscriptionStatus.php
// Statut d'une inscription d'un participant

namespace App\Enums;

enum InscriptionStatus: string
{
    case EnAttente  = 'en_attente';
    case Confirmee  = 'confirmee';
    case Annulee    = 'annulee';

    public function label(): string
    {
        return match($this) {
            self::EnAttente => 'En attente',
            self::Confirmee => 'Confirmée',
            self::Annulee   => 'Annulée',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::EnAttente => 'warning',
            self::Confirmee => 'success',
            self::Annulee   => 'danger',
        };
    }
}