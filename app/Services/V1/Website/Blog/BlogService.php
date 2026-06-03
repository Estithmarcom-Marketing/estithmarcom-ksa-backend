<?php

namespace App\Services\V1\Website\Blog;

use App\Models\Blog;

class BlogService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;
        $locale = app()->getLocale();
        $search = $data['search'] ?? null;

        return Blog::select(['id', "title_$locale as title", "slug_$locale as slug", "short_content_$locale as short_content", 'created_at'])
            ->when(filled($data['category_id'] ?? null), fn($q) => $q->filterByCategory($data['category_id']))
            ->with('media')
            ->published(true)
            ->when($search, fn($q, $v) => $q->search($v))
            ->latest()
            ->paginate($per_page);
    }
    public function show($identifier)
    {
        $locale = app()->getLocale();
        return Blog::select(
            [
                'id',
                "title_$locale as title",
                "subtitle_$locale as subtitle",
                "slug_$locale as slug",
                "short_content_$locale as short_content",
                "content_$locale as content",
                "meta_title_$locale as meta_title",
                "meta_description_$locale as meta_description",
                "category_id",
                "created_at"
            ]
        )
            ->with([
                'media',
                'category:id,' . "name_$locale as name"
            ])
            ->published(true)
            ->where(function ($query) use ($identifier) {
                $query->where('slug_en', $identifier)
                    ->orWhere('slug_ar', $identifier)
                    ->orWhere('id', $identifier);
            })
            ->first();
    }
}
