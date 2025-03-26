<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;

class MessagePolicy
{
    public function update(User $user, Message $message)
    {
        return $user->id === $message->sender_id;
    }

    public function delete(User $user, Message $message)
    {
        return $user->id === $message->sender_id || $user->id === $message->receiver_id;
    }
}
