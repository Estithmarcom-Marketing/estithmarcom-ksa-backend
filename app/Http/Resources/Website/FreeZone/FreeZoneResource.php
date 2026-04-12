<?php

namespace App\Http\Resources\Website\FreeZone;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FreeZoneResource extends JsonResource
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
            'content' => $this->content,
            'image' => $this->whenLoaded('media', fn() => $this->getFirstMediaUrl('free_zone'), ''),
        ];
    }
}
