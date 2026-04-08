<?php

namespace App\Http\Resources\Admin\RequestService;

use App\Http\Resources\Admin\Country\CountryResource;
use App\Http\Resources\Admin\Service\ServiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestServiceResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'additional_info' => $this->additional_info,
            'service' => ServiceResource::make($this->whenLoaded('service', fn() => $this->service)),
            'country' => CountryResource::make($this->whenLoaded('country', fn() => $this->country)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
