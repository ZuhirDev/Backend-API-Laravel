<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notification.private.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
