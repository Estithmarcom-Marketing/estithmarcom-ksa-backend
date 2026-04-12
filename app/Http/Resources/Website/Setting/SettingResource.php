<?php

namespace App\Http\Resources\Website\Setting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'facebook' => $this->facebook,
            'x' => $this->x,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'whatsapp' => $this->whatsapp,
            'snapchat' => $this->snapchat,
            'tiktok' => $this->tiktok
        ];
    }
}
