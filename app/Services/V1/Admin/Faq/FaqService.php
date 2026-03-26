<?php

namespace App\Services\V1\Admin\Faq;

use App\Models\Faq;

class FaqService
{
    public function index(array $data)
    {
        $per_page = $data['per_page'] ?? 10;

        return Faq::latest()->paginate($per_page);
    }

    public function store(array $data)
    {
        return Faq::create([
            'question_ar' => $data['question_ar'],
            'question_en' => $data['question_en'],
            'answer_ar' => $data['answer_ar'],
            'answer_en' => $data['answer_en'],
            'published' => $data['published'],
        ]);
    }

    public function update(Faq $faq, array $data)
    {
        $faq->update([
            'question_ar' => $data['question_ar'] ?? $faq->question_ar,
            'question_en' => $data['question_en'] ?? $faq->question_en,
            'answer_ar' => $data['answer_ar'] ?? $faq->answer_ar,
            'answer_en' => $data['answer_en'] ?? $faq->answer_en,
            'published' => $data['published'] ?? $faq->published,
        ]);

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
