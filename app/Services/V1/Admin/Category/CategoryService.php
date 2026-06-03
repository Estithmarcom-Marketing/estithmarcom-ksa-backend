<?php

namespace App\Services\V1\Admin\Category;

use App\Models\Category;

class CategoryService
{
    public function list(array $data)
    {
        $perPage = $data['per_page'] ?? 10;
        $search  = $data['search'] ?? null;

        return Category::query()
            ->when(filled($search), fn($q) => $q->search($search))
            ->withCount('blogs')
            ->latest()
            ->paginate($perPage);
    }
    public function listWithoutPagination()
    {
        return Category::select(['id', 'name_ar'])
            ->latest()
            ->get();
    }
    public function show(Category $category)
    {
        return $category->loadCount('blogs');
    }
    public function store(array $data)
    {
        return Category::create($data);
    }
    public function update(Category $category, array $data)
    {
        $category->fill($data)->save();
        return $category->refresh();
    }
    public function destroy(Category $category)
    {
        return $category->delete();
    }
}
