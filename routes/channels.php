<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//Comment Room Notification
Broadcast::channel('room-comment', 'CommentNotification@broadcastOn');

//Chat
Broadcast::channel('chat', 'Chat@broadcastOn');
Broadcast::channel('admin-chat', 'Admin\Chat@broadcastOn');
