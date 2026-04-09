<?php

namespace App\Services\V1\Admin\Blog;

use App\Models\Blog;

class BlogService
{
    public function index(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return Blog::query()
            ->when($data['published'] ?? null, fn($q, $v) => $q->published($v))
            ->when($data['search'] ?? null, fn($q, $v) => $q->search($v))
            ->with('media')
            ->list('id', 'title_ar', 'title_en', 'published', 'created_at')
            ->latest()
            ->paginate($per_page);
    }

    public function show(Blog $blog)
    {
        return $blog->load('media');
    }

    public function store(array $data)
    {
        $slug_ar = $data['slug_ar'] ?? make_slug($data['title_ar'], 'ar', Blog::class, 'slug_ar');
        $slug_en = $data['slug_en'] ?? make_slug($data['title_en'], 'en', Blog::class, 'slug_en');
        $blog = Blog::create([
            'title_ar' => $data['title_ar'],
            'title_en' => $data['title_en'],
            'subtitle_ar' => $data['subtitle_ar'],
            'subtitle_en' => $data['subtitle_en'],
            'slug_ar' => $slug_ar,
            'slug_en' => $slug_en,
            'short_content_ar' => $data['short_content_ar'],
            'short_content_en' => $data['short_content_en'],
            'content_ar' => $data['content_ar'],
            'content_en' => $data['content_en'],
            'published' => $data['published'],
            'meta_title_ar' => $data['meta_title_ar'],
            'meta_title_en' => $data['meta_title_en'],
            'meta_description_ar' => $data['meta_description_ar'],
            'meta_description_en' => $data['meta_description_en'],
        ]);

        if (! empty($data['image'])) {
            $blog->addMedia($data['image'])->toMediaCollection('blog');
        }

        return $blog;
    }

    public function update(Blog $blog, array $data)
    {
        $slug_ar = $data['slug_ar'] ?? $this->updateSlug($blog, $data['title_ar'] ?? $blog->title_ar, 'ar');
        $slug_en = $data['slug_en'] ?? $this->updateSlug($blog, $data['title_en'] ?? $blog->title_en, 'en');

        $blog->update([
            'title_ar' => $data['title_ar'] ?? $blog->title_ar,
            'title_en' => $data['title_en'] ?? $blog->title_en,
            'subtitle_ar' => $data['subtitle_ar'] ?? $blog->subtitle_ar,
            'subtitle_en' => $data['subtitle_en'] ?? $blog->subtitle_en,
            'slug_ar' => $slug_ar,
            'slug_en' => $slug_en,
            'short_content_ar' => $data['short_content_ar'] ?? $blog->short_content_ar,
            'short_content_en' => $data['short_content_en'] ?? $blog->short_content_en,
            'content_ar' => $data['content_ar'] ?? $blog->content_ar,
            'content_en' => $data['content_en'] ?? $blog->content_en,
            'published' => $data['published'] ?? $blog->published,
            'meta_title_ar' => $data['meta_title_ar'] ?? $blog->meta_title_ar,
            'meta_title_en' => $data['meta_title_en'] ?? $blog->meta_title_en,
            'meta_description_ar' => $data['meta_description_ar'] ?? $blog->meta_description_ar,
            'meta_description_en' => $data['meta_description_en'] ?? $blog->meta_description_en,
        ]);

        if (! empty($data['image'])) {
            $blog->clearMediaCollection('blog');
            $blog->addMedia($data['image'])->toMediaCollection('blog');
        }

        return $blog->load('media')->refresh();
    }

    private function updateSlug($blog, $new_title, $locale)
    {
        if ($new_title === $blog->{"title_$locale"}) {
            return $blog->{"slug_$locale"};
        }

        return make_slug($new_title, $locale, Blog::class, "slug_$locale");
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
    }
}
