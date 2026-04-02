<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (!empty($model->title_fr) && empty($model->slug_fr)) {
                $model->slug_fr = Str::slug($model->title_fr);
            }
            if (!empty($model->title_en) && empty($model->slug_en)) {
                $model->slug_en = Str::slug($model->title_en);
            }
            // Pour Category (name_fr / name_en)
            if (!empty($model->name_fr) && empty($model->slug_fr)) {
                $model->slug_fr = Str::slug($model->name_fr);
            }
            if (!empty($model->name_en) && empty($model->slug_en)) {
                $model->slug_en = Str::slug($model->name_en);
            }
        });

        static::updating(function ($model) {
            if (!empty($model->title_fr)) {
                $model->slug_fr = Str::slug($model->title_fr);
            }
            if (!empty($model->title_en)) {
                $model->slug_en = Str::slug($model->title_en);
            }
            if (!empty($model->name_fr)) {
                $model->slug_fr = Str::slug($model->name_fr);
            }
            if (!empty($model->name_en)) {
                $model->slug_en = Str::slug($model->name_en);
            }
        });
    }
}