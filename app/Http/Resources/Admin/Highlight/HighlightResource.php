<?php

namespace App\Http\Resources\Admin\Highlight;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HighlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'label_en' => $this->label_en,
            'label_ar' => $this->label_ar,
            'value_en' => (float) $this->value_en,
            'value_ar' => (float) $this->value_ar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
