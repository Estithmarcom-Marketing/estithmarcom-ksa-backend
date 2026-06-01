<?php

namespace App\Services\V1\Admin\Highlight;

use App\Models\Highlight;

class HighlightService
{
    public function list()
    {
        return Highlight::select(['id', 'label_ar', 'value_ar', 'created_at'])
            ->latest()
            ->limit(4)
            ->get();
    }

    public function show(Highlight $highlight)
    {
        return $highlight;
    }

    public function update(Highlight $highlight, array $data)
    {
        $highlight->fill($data)->save();

        return $highlight->refresh();
    }
}
