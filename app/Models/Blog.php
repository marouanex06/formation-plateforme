<?php
// app/Models/Blog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;
use App\Traits\HasSeo;

class Blog extends Model
{
    use HasSlug, HasSeo;

    protected $fillable = [
        'user_id', 'category_id',
        'title_fr', 'title_en',
        'slug_fr', 'slug_en',
        'content_fr', 'content_en',
        'status', 'published_at',
        'seo_title_fr', 'seo_title_en',
        'meta_desc_fr', 'meta_desc_en',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getTitle(): string
    {
        return app()->getLocale() === 'fr' ? $this->title_fr : $this->title_en;
    }

    public function getSlug(): string
    {
        return app()->getLocale() === 'fr' ? $this->slug_fr : $this->slug_en;
    }
}