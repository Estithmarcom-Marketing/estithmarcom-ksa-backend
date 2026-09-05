<?php

namespace App\Http\Resources\Website\Service;

use App\Http\Resources\Website\Country\CountryResource;
use App\Http\Resources\Website\Faq\FaqResource;
use App\Http\Resources\Website\ServiceFeature\ServiceFeatureResource;
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
            'chat_target_type' => $this->chat_target_type,
            'chat_target_id' => $this->chat_target_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'feature_description' => $this->feature_description,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'image' => $this->whenLoaded('media', fn () => $this->getFirstMediaUrl('service'), ''),
            'countries' => CountryResource::collection($this->whenLoaded('countries', fn () => $this->countries, [])),
            'faqs' => $this->whenLoaded('faqs', fn () => FaqResource::collection($this->faqs), []),
            'features' => $this->whenLoaded('features', fn () => ServiceFeatureResource::collection($this->features), []),

        ];
    }
}
