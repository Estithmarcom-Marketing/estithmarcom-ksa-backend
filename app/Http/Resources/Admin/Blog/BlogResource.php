<?php

namespace App\Http\Resources\Admin\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'subtitle_ar' => $this->subtitle_ar,
            'subtitle_en' => $this->subtitle_en,
            'slug_ar' => $this->slug_ar,
            'slug_en' => $this->slug_en,
            'image' => $this->whenLoaded('media', $this->getFirstMediaUrl('blog')),
            'short_content_ar' => $this->short_content_ar,
            'short_content_en' => $this->short_content_en,
            'content_ar' => $this->content_ar,
            'content_en' => $this->content_en,
            'published' => (bool) $this->published,
            'meta_title_ar' => $this->meta_title_ar,
            'meta_title_en' => $this->meta_title_en,
            'meta_description_ar' => $this->meta_description_ar,
            'meta_description_en' => $this->meta_description_en,
            'created_at' => $this->created_at,
        ];
    }
}
