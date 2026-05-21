<?php

namespace App\Http\Resources\Admin\FreeZone;

use App\Http\Resources\Admin\Faq\FaqResource;
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
            'title_ar' => $this->title_ar,
            'title_en' => $this->title_en,
            'slug_ar' => $this->slug_ar,
            'slug_en' => $this->slug_en,
            'active' => (bool) $this->active,
            'image' => $this->whenLoaded('media', fn() => $this->getFirstMediaUrl('free_zone'), ''),
            'content_ar' => $this->content_ar,
            'content_en' => $this->content_en,
            'faqs' => $this->whenLoaded('faqs', fn() => FaqResource::collection($this->faqs), []),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
