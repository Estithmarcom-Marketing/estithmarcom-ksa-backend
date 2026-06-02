<?php

namespace App\Services\V1\Admin\Highlight;

use App\Models\Highlight;

class HighlightService
{
    public function list()
    {
        return Highlight::select(['id', 'label_ar', 'value_ar', 'created_at'])
            ->with('media')
            ->latest()
            ->limit(4)
            ->get();
    }

    public function show(Highlight $highlight)
    {
        return $highlight->load('media');
    }

    public function update(Highlight $highlight, array $data)
    {
        $highlight->fill($data)->save();
        if (isset($data['image'])) {
            $highlight->clearMediaCollection('highlight_image');
            $highlight->addMedia($data['image'])->toMediaCollection('highlight_image');
        }

        return $highlight->refresh();
    }
}
