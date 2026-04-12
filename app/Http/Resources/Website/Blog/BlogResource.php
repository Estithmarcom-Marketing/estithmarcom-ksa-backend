<?php

namespace App\Http\Resources\Website\Blog;

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
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'slug' => $this->slug,
            'short_content' => $this->short_content,
            'content' => $this->content,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'image' => $this->whenLoaded('media', fn() => $this->getFirstMediaUrl('blog'), ''),
        ];
    }
}
