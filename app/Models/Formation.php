<?php
// app/Models/Formation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;
use App\Traits\HasSeo;
use App\Enums\FormationStatus;

class Formation extends Model
{
    use HasSlug, HasSeo; // slug auto + méthodes SEO

    protected $fillable = [
        'category_id',
        'title_fr', 'title_en',
        'slug_fr', 'slug_en',
        'short_desc_fr', 'short_desc_en',
        'full_desc_fr', 'full_desc_en',
        'image', 'price', 'duration', 'level',
        'status', 'published_at',
        'seo_title_fr', 'seo_title_en',
        'meta_desc_fr', 'meta_desc_en',
    ];

    protected $casts = [
        
        // Cast automatique vers l'Enum PHP
        'status'       => FormationStatus::class,
        'published_at' => 'date',
    ];

    // Relation avec la catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Une formation peut avoir plusieurs sessions
    public function sessions()
    {
        return $this->hasMany(TrainingSession::class);
    }

    // Retourne le titre selon la langue active
    public function getTitle(): string
    {
        return app()->getLocale() === 'fr'
            ? $this->title_fr
            : $this->title_en;
    }

    // Retourne le slug selon la langue (pour les URLs publiques)
    public function getSlug(): string
    {
        return app()->getLocale() === 'fr'
            ? $this->slug_fr
            : $this->slug_en;
    }

    // Scope — filtre seulement les formations publiées
    public function scopePublished($query)
    {
        return $query->where('status', FormationStatus::Publie);
    }
    public function getRouteKeyName(): string
{
    return 'slug_fr';
}
}
