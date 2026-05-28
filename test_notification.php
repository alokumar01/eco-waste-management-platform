<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$booking = App\Models\Booking::first();
if (!$booking) {
    echo "No booking found";
    exit;
}

try {
    $booking->customer->notifyNow(new App\Notifications\BookingStatusChangedNotification($booking, 'pending', 'confirmed'));
    echo "Notification sent successfully";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
