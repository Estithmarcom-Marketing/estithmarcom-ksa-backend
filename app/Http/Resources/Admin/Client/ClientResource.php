<?php

namespace App\Http\Resources\Admin\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'image' => $this->whenLoaded('media', fn() => $this->getFirstMediaUrl('client'), ''),
            'alt_ar' => $this->alt_ar,
            'alt_en' => $this->alt_en,
            'link' => $this->link,
            'created_at' => $this->created_at,
        ];
    }
}
