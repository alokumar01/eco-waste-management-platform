<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProviderDashboardController;
use App\Http\Controllers\ProviderProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PublicBlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog', [PublicBlogController::class, 'index'])->name('public.blog.index');
Route::get('/blog/{slug}', [PublicBlogController::class, 'show'])->name('public.blog.show');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [NotificationController::class, 'recent'])->name('notifications.recent');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroy-all');
});

Route::middleware(['auth', 'role:provider'])->group(function () {
    Route::get('provider/profile', [ProviderProfileController::class, 'edit'])->name('provider.profile.edit');
    Route::put('provider/profile', [ProviderProfileController::class, 'update'])->name('provider.profile.update');

    Route::middleware('provider.profile')->group(function () {
        Route::get('provider/dashboard', [ProviderDashboardController::class, 'index'])->name('provider.dashboard');
        Route::resource('services', ServiceController::class);
        Route::resource('bookings', \App\Http\Controllers\BookingController::class)->only(['index', 'update']);
        Route::resource('earnings', \App\Http\Controllers\TransactionController::class)->only(['index']);
        Route::resource('reviews', \App\Http\Controllers\ReviewController::class)->only(['index']);
        // Messages
        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{receiver}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('messages', [MessageController::class, 'store'])->name('messages.store');
        Route::get('messages/{receiver}/fetch', [MessageController::class, 'getMessages'])->name('messages.fetch');
    });
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('customer/dashboard', function () {
        return view('dashboard');
    })->name('customer.dashboard');
    Route::get('available-services', [ServiceController::class, 'list'])->name('services.list');
    Route::get('bookings/create/{service}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    
    // Reviews
    Route::get('reviews/create/{booking}', [\App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews/{booking}', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    // Messages for Customer
    Route::get('customer/messages', [MessageController::class, 'index'])->name('customer.messages.index');
    Route::get('customer/messages/{receiver}', [MessageController::class, 'show'])->name('customer.messages.show');
    Route::post('customer/messages', [MessageController::class, 'store'])->name('customer.messages.store');
    Route::get('customer/messages/{receiver}/fetch', [MessageController::class, 'getMessages'])->name('customer.messages.fetch');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::post('/admin/verify-provider/{user}', function (\App\Models\User $user) {
        $user->update(['is_verified' => true]);
        return back()->with('success', 'Provider verified successfully.');
    })->name('admin.verifyProvider');
});

Route::middleware(['auth', 'role:provider,admin'])->group(function () {
    Route::resource('provider/blog', \App\Http\Controllers\BlogPostController::class)->except(['show']);
});

require __DIR__.'/auth.php';

Route::get('/logout-now', function () {
    Auth::logout();
    return redirect('/');
});
