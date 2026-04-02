<?php

namespace App\Traits;

trait HasSeo
{
    // Retourne le SEO title selon la langue active
    public function getSeoTitle(): string
    {
        $field = 'seo_title_' . app()->getLocale();
        $titleField = 'title_' . app()->getLocale();

        return $this->$field
            ?? $this->$titleField
            ?? '';
    }

    // Retourne la meta description selon la langue active
    public function getMetaDescription(): string
    {
        $field = 'meta_desc_' . app()->getLocale();
        $shortDesc = 'short_desc_' . app()->getLocale();

        return $this->$field
            ?? $this->$shortDesc
            ?? '';
    }
}