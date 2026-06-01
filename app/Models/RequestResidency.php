<?php

namespace App\Models;

use App\Enum\RequestResidencyStatusEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[
    Fillable(['name', 'email', 'phone', 'status', 'city', 'notes', 'residency_id'])
]
class RequestResidency extends Model
{
    protected function casts()
    {
        return [
            'status' => RequestResidencyStatusEnum::class
        ];
    }

    public function residency()
    {
        return $this->belongsTo(Residency::class);
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->whereAny([
            'name',
            'email',
            'phone'
        ], 'LIKE', $term);
    }
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    public function scopeFilterByResidency($query, $residency_id)
    {
        return $query->where('residency_id', $residency_id);
    }
}
