<?php

namespace App\Http\Resources\Website\Residency;

use App\Http\Resources\Website\Country\CountryResource;
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'image' => $this->whenLoaded('media', fn() => $this->getFirstMediaUrl('residency'), ''),
            'country' => $this->whenLoaded('country', fn() => CountryResource::make($this->country), []),
        ];
    }
}
