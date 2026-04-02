<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug; // notre trait pour générer les slugs auto

class Category extends Model
{
    use HasSlug; // slug_fr et slug_en générés automatiquement

    protected $fillable = [
        'name_fr',
        'name_en',
        'slug_fr',
        'slug_en',
    ];

    // Une catégorie peut avoir plusieurs formations
    public function formations()
    {
        return $this->hasMany(Formation::class);
    }

    // Retourne le nom selon la langue active
    public function getName(): string
    {
        return app()->getLocale() === 'fr'
            ? $this->name_fr
            : $this->name_en;
    }

    // Retourne le slug selon la langue active (pour les URLs)
    public function getSlug(): string
    {
        return app()->getLocale() === 'fr'
            ? $this->slug_fr
            : $this->slug_en;
    }
}