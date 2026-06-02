<?php

namespace App\Http\Resources\Website\ServiceFeature;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceFeatureResource extends JsonResource
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
            'description' => $this->description,
            'image' => $this->whenLoaded('media', fn() => $this->getFirstMediaUrl('service_feature'), ''),
        ];
    }
}
