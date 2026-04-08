<?php

namespace App\Models;

use App\Enum\RequestServiceStatusEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name',
    'email',
    'phone',
    'additional_info',
    'status',
    'service_id',
    'country_id'

])]
class RequestService extends Model
{
    use SoftDeletes;
    protected function casts()
    {
        return [
            'status' => RequestServiceStatusEnum::class,
            'additional_info' => 'array',
        ];
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        return $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('email', 'like', $term)
                ->orWhere('phone', 'like', $term);
        });
    }

    public function scopeFilterByCountry($query, $country_id)
    {
        return $query->where('country_id', $country_id);
    }

    public function scopeFilterByService($query, $service_id)
    {
        return $query->where('service_id', $service_id);
    }

    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
