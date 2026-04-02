<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->getTitle(),
            'slug'        => $this->getSlug(),
            'short_desc'  => app()->getLocale() === 'fr' ? $this->short_desc_fr : $this->short_desc_en,
            'price'       => $this->price,
            'duration'    => $this->duration,
            'level'       => $this->level,
            'status'      => $this->status->value,
            'image_url'   => $this->image ? asset('storage/' . $this->image) : null,
            'category'    => $this->whenLoaded('category', fn() => [
                'id'   => $this->category->id,
                'name' => $this->category->getName(),
            ]),
            'published_at' => $this->published_at?->format('Y-m-d'),
        ];
    }
}