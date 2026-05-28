<?php

namespace App\Notifications;

use App\Channels\DatabaseChannel;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, string $oldStatus, string $newStatus)
    {
        $this->booking = $booking;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
        $serviceName = $this->booking->service ? $this->booking->service->name : 'a service';
        
        return (new MailMessage)
                    ->subject('Booking Status Updated: ' . ucfirst($this->newStatus))
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line("The status of your booking for {$serviceName} has changed from {$this->oldStatus} to {$this->newStatus}.")
                    ->action('View Booking', url('/bookings/' . $this->booking->id))
                    ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification for our custom database channel.
     *
     * @return array<string, mixed>
     */
    public function toCustomDatabase(object $notifiable): array
    {
        $serviceName = $this->booking->service ? $this->booking->service->name : 'a service';

        return [
            'type' => 'booking_status_changed',
            'booking_id' => $this->booking->id,
            'title' => 'Booking Status Updated',
            'message' => "Your booking for {$serviceName} is now {$this->newStatus}.",
            'action_url' => url('/bookings/' . $this->booking->id),
        ];
    }
}
