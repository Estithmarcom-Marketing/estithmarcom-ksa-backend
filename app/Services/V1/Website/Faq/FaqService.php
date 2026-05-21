<?php

namespace App\Services\V1\Website\Faq;

use App\Models\Faq;

class FaqService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;
        $locale = app()->getLocale();

        return Faq::select(
            [
                'id',
                "question_$locale as question",
                "answer_$locale as answer"
            ]
        )
            ->published(true)
            ->global()
            ->latest()
            ->paginate($per_page);
    }
}
