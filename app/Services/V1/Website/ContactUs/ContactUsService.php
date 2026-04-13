<?php

namespace App\Services\V1\Website\ContactUs;

use App\Models\ContactUs;

class ContactUsService
{
    public function store(array $data)
    {
        if (isset($data['phone'])) {
            $data['phone'] = $this->normalizePhone($data['phone']);
        }
        return ContactUs::create([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'message' => $data['message'],
            'contacted' => false
        ]);
    }
    private function normalizePhone($phone)
    {
        return str_replace(['+', ' ', '-'], '', $phone);
    }
}
