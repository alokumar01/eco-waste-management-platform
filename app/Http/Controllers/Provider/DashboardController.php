<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\CompostingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $provider = $request->user();

        $services = $provider->compostingServices()
            ->latest()
            ->take(5)
            ->get();

        return view('provider.dashboard', [
            'provider' => $provider,
            'services' => $services,
            'stats' => [
                'total' => $provider->compostingServices()->count(),
                'published' => $provider->compostingServices()->published()->count(),
                'pending' => $provider->compostingServices()
                    ->where('approval_status', CompostingService::STATUS_PENDING)
                    ->count(),
                'approved' => $provider->compostingServices()
                    ->where('approval_status', CompostingService::STATUS_APPROVED)
                    ->count(),
            ],
        ]);
    }
}
