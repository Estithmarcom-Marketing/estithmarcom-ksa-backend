<?php

namespace App\Services\V1\Website\Highlight;

use App\Models\Highlight;

class HighlightService
{
    public function list()
    {
        $locale = app()->getLocale() ?? 'ar';

        return Highlight::select(['id',
            "label_{$locale} as label",
            "value_{$locale} as value"])
            ->latest()
            ->limit(4)
            ->get();
    }
}
