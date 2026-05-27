<?php

namespace App\Notifications;

use App\Channels\DatabaseChannel;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingRefundedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;
    public $refundAmount;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, float $refundAmount)
    {
        $this->booking = $booking;
        $this->refundAmount = $refundAmount;
    }

    /**
     * Get the notification's delivery channels.
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
        $serviceName = $this->booking->service ? $this->booking->service->name : 'service';
        
        return (new MailMessage)
                    ->subject('Refund Confirmation: Booking #' . $this->booking->id)
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line("We have processed a refund of ₹" . number_format($this->refundAmount, 2) . " for your booking of {$serviceName} (Booking #{$this->booking->id}) because it was cancelled.")
                    ->line('The refunded amount has been sent back to your UPI account.')
                    ->line('Thank you for choosing GreenLoop!');
    }

    /**
     * Get the array representation of the notification for our custom database channel.
     */
    public function toCustomDatabase(object $notifiable): array
    {
        $serviceName = $this->booking->service ? $this->booking->service->name : 'service';

        return [
            'type' => 'booking_refunded',
            'booking_id' => $this->booking->id,
            'title' => 'Payment Refunded',
            'message' => "Your payment of ₹" . number_format($this->refundAmount, 2) . " for {$serviceName} has been refunded to your UPI account.",
            'action_url' => url('/my-bookings'),
        ];
    }
}
