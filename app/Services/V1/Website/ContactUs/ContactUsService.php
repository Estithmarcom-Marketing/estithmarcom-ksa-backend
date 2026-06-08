<?php

namespace App\Services\V1\Website\ContactUs;

use App\Events\ContactMessageSubmitted;
use App\Models\ContactUs;

class ContactUsService
{
    public function store(array $data)
    {
        if (isset($data['phone'])) {
            $data['phone'] = $this->normalizePhone($data['phone']);
        }
        $contactUs = ContactUs::create([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'message' => $data['message'],
            'contacted' => false
        ]);
        ContactMessageSubmitted::dispatch($contactUs);

        return $contactUs;
    }
    private function normalizePhone($phone)
    {
        return str_replace(['+', ' ', '-'], '', $phone);
    }
}
