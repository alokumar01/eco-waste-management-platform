<?php

namespace App\Http\Controllers;

use App\Models\CompostingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceCatalogController extends Controller
{
    public function index(Request $request): View
    {
        $services = CompostingService::query()
            ->with('provider')
            ->published()
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->input('category')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('services.index', [
            'services' => $services,
            'categories' => CompostingService::categories(),
        ]);
    }
}
