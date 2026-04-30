<?php

use App\Http\Controllers\Admin\ProviderApprovalController;
use App\Http\Controllers\Admin\ServiceApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Provider\CompostingServiceController;
use App\Http\Controllers\Provider\DashboardController as ProviderDashboardController;
use App\Http\Controllers\Provider\ProviderProfileController;
use App\Http\Controllers\ServiceCatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/services', [ServiceCatalogController::class, 'index'])->name('services.index');

Route::get('/dashboard', function () {
    if (request()->user()?->isProvider()) {
        return redirect()->route('provider.dashboard');
    }

    if (request()->user()?->isAdmin()) {
        return redirect()->route('admin.services.review');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:provider'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {
        Route::get('/dashboard', ProviderDashboardController::class)->name('dashboard');
        Route::patch('/profile', [ProviderProfileController::class, 'update'])->name('profile.update');

        Route::resource('services', CompostingServiceController::class)
            ->except(['show']);
        Route::patch('/services/{service}/submit', [CompostingServiceController::class, 'submit'])
            ->name('services.submit');
        Route::patch('/services/{service}/publish', [CompostingServiceController::class, 'publish'])
            ->name('services.publish');
        Route::patch('/services/{service}/unpublish', [CompostingServiceController::class, 'unpublish'])
            ->name('services.unpublish');
    });

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/services/review', [ServiceApprovalController::class, 'index'])->name('services.review');
        Route::patch('/services/{service}/approve', [ServiceApprovalController::class, 'approve'])->name('services.approve');
        Route::patch('/services/{service}/reject', [ServiceApprovalController::class, 'reject'])->name('services.reject');
        Route::patch('/providers/{provider}/approve', [ProviderApprovalController::class, 'approve'])->name('providers.approve');
        Route::patch('/providers/{provider}/reject', [ProviderApprovalController::class, 'reject'])->name('providers.reject');
    });

require __DIR__.'/auth.php';
