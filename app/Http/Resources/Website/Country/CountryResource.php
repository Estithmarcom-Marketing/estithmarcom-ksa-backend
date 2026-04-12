<?php

namespace App\Http\Resources\Website\Country;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        return [
            'id' => $this->id,
            'name' => $this->{"name_$locale"},
            'title' => $this->{"title_$locale"},
            'description' => $this->{"description_$locale"},
            'image' => $this->whenLoaded('media', $this->getFirstMediaUrl('country')),
        ];
    }
}
