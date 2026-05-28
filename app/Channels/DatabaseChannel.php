<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Models\Notification as NotificationModel;

class DatabaseChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toCustomDatabase')) {
            $data = $notification->toCustomDatabase($notifiable);
            
            NotificationModel::create([
                'user_id' => $notifiable->id,
                'type' => $data['type'] ?? get_class($notification),
                'booking_id' => $data['booking_id'] ?? null,
                'title' => $data['title'],
                'message' => $data['message'],
                'action_url' => $data['action_url'] ?? null,
            ]);
        }
    }
}
