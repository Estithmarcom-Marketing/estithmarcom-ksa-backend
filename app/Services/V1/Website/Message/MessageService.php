<?php

namespace App\Services\V1\Website\Message;

use App\Events\ChatbotMessageSubmitted;
use App\Models\Message;

class MessageService
{
    public function store(array $data)
    {
        $message = Message::create($data);
        ChatbotMessageSubmitted::dispatch($message);
        return $message;
    }
}
