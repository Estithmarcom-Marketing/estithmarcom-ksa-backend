<?php

namespace App\Http\Resources\Admin\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title_ar' => $this->title_ar,
            'title_en' => $this->title_en,
            'slug_ar' => $this->slug_ar,
            'slug_en' => $this->slug_en,
            'published' => (bool) $this->published,
            'image' => $this->whenLoaded('media', $this->getFirstMediaUrl('service')),
            'short_description_ar' => $this->short_description_ar,
            'short_description_en' => $this->short_description_en,
            'long_description_ar' => $this->long_description_ar,
            'long_description_en' => $this->long_description_en,
            'meta_title_ar' => $this->meta_title_ar,
            'meta_title_en' => $this->meta_title_en,
            'meta_description_ar' => $this->meta_description_ar,
            'meta_description_en' => $this->meta_description_en,
            'created_at' => $this->created_at,
        ];
    }
}
