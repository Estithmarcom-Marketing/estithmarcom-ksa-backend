<?php

namespace App\Services\V1\Admin\Message;

use App\Models\Message;

class MessageService
{
    public function list(array $data)
    {
        $per_page = $data['per_page'] ?? 10;
        return Message::select(['id', 'name', 'phone', 'status','created_at'])
            ->when(filled($data['search'] ?? null), fn($q) => $q->search($data['search']))
            ->when(filled($data['status'] ?? null), fn($q) => $q->filterByStatus($data['status']))
            ->latest()
            ->paginate($per_page);
    }
    public function show(Message $message)
    {
        return $message;
    }
    public function update(Message $message, array $data)
    {
        $message->update($data);
        return $message->refresh();
    }
    public function destroy(Message $message)
    {
        return $message->delete();
    }
}
