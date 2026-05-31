<?php

namespace App\Http\Resources\Admin\Residency;

use App\Http\Resources\Admin\Country\CountryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResidencyResource extends JsonResource
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
            'published' => $this->published,
            'description_ar' => $this->description_ar,
            'description_en' => $this->description_en,
            'image' => $this->whenLoaded('media', fn() => $this->getFirstMediaUrl('residency'), ''),
            'country' => $this->whenLoaded('country', fn() => CountryResource::make($this->country)),
            'meta_title_ar' => $this->meta_title_ar,
            'meta_title_en' => $this->meta_title_en,
            'meta_description_ar' => $this->meta_description_ar,
            'meta_description_en' => $this->meta_description_en,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
