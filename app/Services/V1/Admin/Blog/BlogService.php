<?php

namespace App\Services\V1\Admin\Blog;

use App\Models\Blog;

class BlogService
{
    public function index(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return Blog::query()
            ->when(array_key_exists('published', $data), fn($q) => $q->published($data['published']))
            ->when(filled($data['category_id'] ?? null), fn($q) => $q->filterByCategory($data['category_id']))
            ->when(filled($data['search'] ?? null), fn($q) => $q->search($data['search']))
            ->with('media')
            ->select('id', 'title_ar', 'published', 'created_at')
            ->latest()
            ->paginate($per_page);
    }

    public function show(Blog $blog)
    {
        return $blog->load(['media', 'category:id,name_ar,name_en']);
    }

    public function store(array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? make_slug($data['title_ar'], 'ar', Blog::class, 'slug_ar');
        $data['slug_en'] = $data['slug_en'] ?? make_slug($data['title_en'], 'en', Blog::class, 'slug_en');
        $blog = Blog::create($data);

        if (! empty($data['image'])) {
            $blog->addMedia($data['image'])->toMediaCollection('blog');
        }

        return $blog;
    }

    public function update(Blog $blog, array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? $this->updateSlug($blog, $data['title_ar'] ?? $blog->title_ar, 'ar');
        $data['slug_en'] = $data['slug_en'] ?? $this->updateSlug($blog, $data['title_en'] ?? $blog->title_en, 'en');

        $blog->update($data);

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
        $blog->clearMediaCollection('blog');
        $blog->delete();
    }
}
