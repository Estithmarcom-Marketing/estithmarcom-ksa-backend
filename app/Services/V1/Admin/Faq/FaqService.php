<?php

namespace App\Services\V1\Admin\Faq;

use App\Models\Faq;

class FaqService
{
    public function index(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return Faq::query()
            ->when(array_key_exists('published', $data), fn($q) => $q->published($data['published']))
            ->when(filled($data['search'] ?? null), fn($q) => $q->search($data['search']))
            ->select('id', 'question_ar', 'question_en', 'published', 'created_at')
            ->latest()
            ->paginate($per_page);
    }

    public function store(array $data)
    {
        return Faq::create($data);
    }

    public function update(Faq $faq, array $data)
    {
        $faq->update($data);

        return $faq->refresh();
    }

    public function destroy(Faq $faq)
    {
        return $faq->delete();
    }

    public function show(Faq $faq)
    {
        return $faq;
    }
}
