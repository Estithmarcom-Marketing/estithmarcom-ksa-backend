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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,
            'residencies_count' => $this->whenCounted('residencies', $this->residencies_count, null),
            'image' => $this->whenLoaded('media', fn() => $this->getFirstMediaUrl('country'), ''),
        ];
    }
}
