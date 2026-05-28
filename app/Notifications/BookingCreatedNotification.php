<?php

namespace App\Notifications;

use App\Channels\DatabaseChannel;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
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
        $customerName = $this->booking->customer ? $this->booking->customer->name : 'A customer';
        
        return (new MailMessage)
                    ->subject('New Booking Received: ' . $serviceName)
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line("You have received a new booking for {$serviceName} from {$customerName}.")
                    ->line('Scheduled Date: ' . \Carbon\Carbon::parse($this->booking->scheduled_at)->format('M d, Y h:i A'))
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
        $customerName = $this->booking->customer ? $this->booking->customer->name : 'A customer';

        return [
            'type' => 'booking_created',
            'booking_id' => $this->booking->id,
            'title' => 'New Booking Received',
            'message' => "You have a new booking for {$serviceName} from {$customerName}.",
            'action_url' => url('/bookings/' . $this->booking->id),
        ];
    }
}
