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

Route::view('/about', 'about')->name('public.about');
Route::view('/contact', 'contact')->name('public.contact');
Route::view('/terms', 'terms')->name('public.terms');
Route::view('/privacy', 'privacy')->name('public.privacy');
Route::view('/refund-policy', 'refund-policy')->name('public.refund-policy');
Route::view('/faqs', 'faqs')->name('public.faqs');
Route::view('/help', 'help')->name('public.help');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog', [PublicBlogController::class, 'index'])->name('public.blog.index');
Route::get('/blog/{slug}', [PublicBlogController::class, 'show'])->name('public.blog.show');
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'provider') {
        return redirect()->route('provider.dashboard');
    }
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    // Fetch stats for customer
    $totalBookings = $user->customerBookings()->count();
    $activeBookings = $user->customerBookings()->whereIn('status', ['pending', 'accepted', 'confirmed'])->count();
    $completedBookings = $user->customerBookings()->where('status', 'completed')->count();
    
    // Calculate actual eco impact metrics based on completed bookings' waste_amount
    $wasteSaved = (float) $user->customerBookings()
        ->where('status', 'completed')
        ->sum('waste_amount');
        
    $co2Offset = $wasteSaved * 0.5;
    $treesEquivalent = $co2Offset * 0.075;
    
    // Get upcoming booking (first scheduled in future)
    $upcomingBooking = $user->customerBookings()
        ->with(['service', 'provider'])
        ->whereIn('status', ['pending', 'accepted', 'confirmed'])
        ->where('scheduled_at', '>=', now())
        ->orderBy('scheduled_at', 'asc')
        ->first();
        
    // Get latest published blog posts
    $latestPosts = \App\Models\BlogPost::where('status', 'published')
        ->latest('published_at')
        ->take(3)
        ->get();
        
    return view('dashboard', compact(
        'totalBookings',
        'activeBookings',
        'completedBookings',
        'wasteSaved',
        'co2Offset',
        'treesEquivalent',
        'upcomingBooking',
        'latestPosts'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bookings detail redirect
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show')->whereNumber('booking');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show')->whereNumber('service');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [NotificationController::class, 'recent'])->name('notifications.recent');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroy-all');

    Route::get('/help-support/message-admin', function () {
        $admin = \App\Models\User::where('role', 'admin')->first();
        if (!$admin) {
            return back()->with('error', 'Admin user not found.');
        }

        if (Auth::id() === $admin->id) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::user()->role === 'provider') {
            return redirect()->route('messages.show', $admin->id);
        } else {
            return redirect()->route('customer.messages.show', $admin->id);
        }
    })->name('help.message-admin');
});

Route::middleware(['auth', 'verified', 'role:provider'])->group(function () {
    Route::get('provider/profile', [ProviderProfileController::class, 'edit'])->name('provider.profile.edit');
    Route::put('provider/profile', [ProviderProfileController::class, 'update'])->name('provider.profile.update');

    Route::middleware('provider.profile')->group(function () {
        Route::get('provider/dashboard', [ProviderDashboardController::class, 'index'])->name('provider.dashboard');
        Route::resource('services', ServiceController::class)->except(['show']);
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

Route::get('available-services', [ServiceController::class, 'list'])->name('services.list');

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('customer/dashboard', function () {
        return redirect()->route('dashboard');
    })->name('customer.dashboard');
    Route::get('bookings/create/{service}', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('checkout/payment', [BookingController::class, 'payment'])->name('bookings.payment');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('bookings/{booking}/pay', [BookingController::class, 'pay'])->name('bookings.pay')->whereNumber('booking');
    Route::get('my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    
    // Reviews
    Route::get('reviews/create/{booking}', [\App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews/{booking}', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    // Messages for Customer
    Route::get('customer/messages', [MessageController::class, 'index'])->name('customer.messages.index');
    Route::get('customer/messages/{receiver}', [MessageController::class, 'show'])->name('customer.messages.show');
    Route::post('customer/messages', [MessageController::class, 'store'])->name('customer.messages.store');
    Route::get('customer/messages/{receiver}/fetch', [MessageController::class, 'getMessages'])->name('customer.messages.fetch');

    // Toggle Save Provider
    Route::post('providers/{provider}/toggle-save', function (\App\Models\User $provider) {
        $user = auth()->user();
        if ($provider->role !== 'provider') {
            return response()->json(['error' => 'User is not a provider.'], 400);
        }
        $user->savedProviders()->toggle($provider->id);
        $isSaved = $user->savedProviders()->where('provider_id', $provider->id)->exists();
        return response()->json([
            'success' => true,
            'is_saved' => $isSaved,
            'message' => $isSaved ? 'Provider saved successfully.' : 'Provider removed from saved list.'
        ]);
    })->name('providers.toggle-save');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/providers', [\App\Http\Controllers\AdminDashboardController::class, 'providers'])->name('admin.providers');
    Route::get('/admin/reviews', [\App\Http\Controllers\AdminDashboardController::class, 'reviews'])->name('admin.reviews');
    Route::delete('/admin/reviews/{review}', [\App\Http\Controllers\AdminDashboardController::class, 'destroyReview'])->name('admin.reviews.destroy');
    Route::get('/admin/blog/all-articles', [\App\Http\Controllers\AdminDashboardController::class, 'allArticles'])->name('admin.blog.all-articles');
    Route::post('/admin/blog/all-articles/{blogPost}/toggle-status', [\App\Http\Controllers\AdminDashboardController::class, 'toggleArticleStatus'])->name('admin.blog.toggle-status');
    Route::get('/admin/profile', [\App\Http\Controllers\AdminDashboardController::class, 'editProfile'])->name('admin.profile.edit');
    Route::put('/admin/profile', [\App\Http\Controllers\AdminDashboardController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/admin/bookings', [\App\Http\Controllers\AdminDashboardController::class, 'bookings'])->name('admin.bookings');
    Route::get('/admin/transactions', [\App\Http\Controllers\AdminDashboardController::class, 'transactions'])->name('admin.transactions');

    Route::post('/admin/verify-provider/{user}', function (\App\Models\User $user) {
        $user->update(['is_verified' => true]);
        return back()->with('success', 'Provider verified successfully.');
    })->name('admin.verifyProvider');

    Route::post('/admin/decline-provider/{user}', function (\App\Models\User $user) {
        $user->delete();
        return back()->with('success', 'Provider registration declined.');
    })->name('admin.declineProvider');

    Route::delete('/admin/services/{service}', function (\App\Models\Service $service) {
        $provider = $service->user;
        $serviceName = $service->name;

        if ($provider) {
            $provider->notify(new \App\Notifications\ServiceDeletedViolationNotification($serviceName));
        }

        // Cancel and refund active bookings
        foreach ($service->bookings as $booking) {
            if ($booking->status !== 'cancelled' && $booking->status !== 'completed') {
                $booking->status = 'cancelled';
                if ($booking->payment_status === 'paid') {
                    $booking->payment_status = 'refunded';
                    if ($booking->transaction) {
                        $booking->transaction->update(['status' => 'refunded']);
                    }
                    $booking->customer->notify(new \App\Notifications\BookingRefundedNotification($booking, $booking->price));
                }
                $booking->save();
            }
        }

        $service->delete();

        return redirect()->route('services.list')->with('success', 'Service deleted successfully and provider has been notified.');
    })->name('admin.services.destroy');

    Route::delete('/admin/blog/{blogPost}', function (\App\Models\BlogPost $blogPost) {
        $blogPost->delete();
        return back()->with('success', 'Blog post deleted successfully.');
    })->name('admin.blog.destroy');
});

Route::middleware(['auth', 'verified', 'role:provider,admin'])->group(function () {
    Route::get('provider/blog/{id}/preview', [\App\Http\Controllers\BlogPostController::class, 'preview'])->name('provider.blog.preview');
    Route::resource('provider/blog', \App\Http\Controllers\BlogPostController::class)->except(['show']);
});

require __DIR__.'/auth.php';

Route::get('/logout-now', function () {
    Auth::logout();
    return redirect('/');
});

