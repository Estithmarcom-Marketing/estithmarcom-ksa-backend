<?php

namespace App\Services\V1\Admin\StaticPage;

use App\Models\StaticPage;


class StaticPageService
{
    public function list()
    {
        return StaticPage::select(['id', 'title_ar', 'slug_ar', 'created_at'])
            ->latest()
            ->paginate(10);
    }
    public function show(StaticPage $staticPage)
    {
        return $staticPage;
    }
    public function store(array $data)
    {
        $data['slug_ar'] = $data['slug_ar'] ?? make_slug($data['title_ar'], 'ar', StaticPage::class, 'slug_ar');
        $data['slug_en'] = $data['slug_en'] ?? make_slug($data['title_en'], 'en', StaticPage::class, 'slug_en');
        return StaticPage::create($data);
    }
    public function update(StaticPage $staticPage, array $data)
    {
        $staticPage->update($data);
        return $staticPage->refresh();
    }
    public function destroy(StaticPage $staticPage)
    {
        return $staticPage->delete();
    }
}
