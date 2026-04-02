<?php
// app/Helpers/AppHelper.php
// Fonctions utilitaires utilisables partout dans le projet

if (!function_exists('formatPrice')) {
    // Formate un prix en MAD (ex: 1500 → "1 500,00 MAD")
    function formatPrice(float $price): string
    {
        return number_format($price, 2, ',', ' ') . ' MAD';
    }
}

if (!function_exists('activeLang')) {
    // Retourne la langue active (fr ou en)
    function activeLang(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('statusBadge')) {
    // Génère un badge HTML Bootstrap selon la couleur
    function statusBadge(string $label, string $color): string
    {
        return '<span class="badge bg-' . $color . '">' . $label . '</span>';
    }
}