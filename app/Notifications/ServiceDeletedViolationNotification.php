<?php

namespace App\Notifications;

use App\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceDeletedViolationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $serviceName;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $serviceName)
    {
        $this->serviceName = $serviceName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', DatabaseChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Service Removed: Violation Notice')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line("We regret to inform you that your listed service '{$this->serviceName}' has been removed from GreenLoop due to a violation of our community standards or platform guidelines.")
                    ->line("Please review our provider terms of service. If you believe this was an error, you may contact support.")
                    ->line('Thank you for your understanding.');
    }

    /**
     * Get the array representation of the notification for our custom database channel.
     *
     * @return array<string, mixed>
     */
    public function toCustomDatabase(object $notifiable): array
    {
        return [
            'type' => 'service_deleted_violation',
            'title' => 'Service Removed: Violation Notice',
            'message' => "Your service '{$this->serviceName}' has been removed due to a policy violation.",
            'action_url' => url('/provider/dashboard'),
        ];
    }
}
