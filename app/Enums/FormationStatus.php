<?php
// app/Enums/FormationStatus.php
// Enum = liste fixe de valeurs possibles pour le statut d'une formation

namespace App\Enums;

enum FormationStatus: string
{
    case Brouillon = 'brouillon';  // pas encore publié
    case Publie    = 'publie';     // visible au public
    case Archive   = 'archive';    // plus disponible

    // Retourne un label lisible pour l'affichage
    public function label(): string
    {
        return match($this) {
            self::Brouillon => 'Brouillon',
            self::Publie    => 'Publié',
            self::Archive   => 'Archivé',
        };
    }

    // Retourne une couleur CSS pour le badge
    public function color(): string
    {
        return match($this) {
            self::Brouillon => 'warning',
            self::Publie    => 'success',
            self::Archive   => 'secondary',
        };
    }
}