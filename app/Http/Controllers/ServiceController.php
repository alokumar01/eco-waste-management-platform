<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Auth::user()->services;
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'required|string',
            'detailed_description' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'what_we_accept' => 'nullable|string',
            'what_we_dont_accept' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'additional_areas' => 'nullable|string|max:255',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['images']);

        $uploaded = $request->file('images', []);
        $paths = [];
        for ($i = 0; $i < 5; $i++) {
            if (isset($uploaded[$i]) && $uploaded[$i]->isValid()) {
                $paths[] = $uploaded[$i]->store('services', 'public');
            }
        }
        $data['image_path'] = !empty($paths) ? json_encode($paths) : null;

        Auth::user()->services()->create($data);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $this->authorize('update', $service);
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'required|string',
            'detailed_description' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'what_we_accept' => 'nullable|string',
            'what_we_dont_accept' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'additional_areas' => 'nullable|string|max:255',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $existingImages = $request->input('existing_images', []);
        $newUploaded = $request->file('images', []);
        
        $finalPaths = [];
        
        // Loop over the 5 potential slots
        for ($i = 0; $i < 5; $i++) {
            // Check if a new file was uploaded for this slot
            if (isset($newUploaded[$i]) && $newUploaded[$i]->isValid()) {
                // Save the new file
                $finalPaths[] = $newUploaded[$i]->store('services', 'public');
                
                // If there was an old image in this slot, delete it from storage
                $oldPathInSlot = $existingImages[$i] ?? null;
                if ($oldPathInSlot && \Storage::disk('public')->exists($oldPathInSlot)) {
                    \Storage::disk('public')->delete($oldPathInSlot);
                }
            } else {
                // Keep the existing image path if it wasn't replaced
                if (!empty($existingImages[$i])) {
                    $finalPaths[] = $existingImages[$i];
                }
            }
        }
        
        $data['image_path'] = !empty($finalPaths) ? json_encode($finalPaths) : null;

        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        if ($service->image_path) {
            if (str_starts_with($service->image_path, '[') && str_ends_with($service->image_path, ']')) {
                $oldImages = json_decode($service->image_path, true) ?: [];
                foreach ($oldImages as $oldPath) {
                    if (\Storage::disk('public')->exists($oldPath)) {
                        \Storage::disk('public')->delete($oldPath);
                    }
                }
            } else {
                if (\Storage::disk('public')->exists($service->image_path)) {
                    \Storage::disk('public')->delete($service->image_path);
                }
            }
        }
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    /**
     * Display a listing of all active services for customers.
     */
    public function list(Request $request)
    {
        $query = Service::where('status', 'active')->with('user');

        if ($request->filled('city')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('city', 'like', '%' . $request->city . '%');
            });
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category') && $request->category !== 'All Categories') {
            $query->where('category', $request->category);
        }

        if ($request->filled('service_type')) {
            $types = is_array($request->service_type) ? $request->service_type : [$request->service_type];
            $query->whereIn('type', $types);
        }

        if ($request->filled('price_range')) {
            $range = $request->price_range;
            if ($range === 'under-200') {
                $query->where('price', '<', 200);
            } elseif ($range === '200-500') {
                $query->whereBetween('price', [200, 500]);
            } elseif ($range === '500-1000') {
                $query->whereBetween('price', [500, 1000]);
            } elseif ($range === 'above-1000') {
                $query->where('price', '>', 1000);
            }
        }

        // Filter by verification status if tab pill is active
        if ($request->filled('verified') && $request->verified == '1') {
            $query->whereHas('user', function($q) {
                $q->where('is_verified', true);
            });
        }

        // Filter by rating status if tab pill is active
        if ($request->filled('top_rated') && $request->top_rated == '1') {
            // We will filter in collection below
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'popular');
        if ($sortBy === 'price-low') {
            $query->orderBy('price', 'asc');
        } elseif ($sortBy === 'price-high') {
            $query->orderBy('price', 'desc');
        } elseif ($sortBy === 'newest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->latest();
        }

        $services = $query->get();

        // Robust PHP Collection filters for rating & top_rated to ensure 100% database driver compatibility
        if ($request->filled('rating')) {
            $ratingThreshold = intval($request->rating);
            $services = $services->filter(function($service) use ($ratingThreshold) {
                return round($service->user->averageRating()) >= $ratingThreshold;
            });
        }

        if ($request->filled('top_rated') && $request->top_rated == '1') {
            $services = $services->filter(function($service) {
                return round($service->user->averageRating()) >= 4;
            });
        }

        // Calculate counts dynamically for categories
        $categoriesList = [
            'All Categories' => Service::where('status', 'active')->count(),
            'Composting' => Service::where('status', 'active')->where('category', 'Composting')->count(),
            'Recycling' => Service::where('status', 'active')->where('category', 'Recycling')->count(),
            'E-Waste' => Service::where('status', 'active')->where('category', 'E-Waste')->count(),
            'Organic Waste' => Service::where('status', 'active')->where('category', 'Organic Waste')->count(),
            'Garden Waste' => Service::where('status', 'active')->where('category', 'Garden Waste')->count(),
            'Commercial Waste' => Service::where('status', 'active')->where('category', 'Commercial Waste')->count(),
        ];

        // Type counts
        $typeCounts = [
            'Pickup Service' => Service::where('status', 'active')->where('type', 'Pickup Service')->count(),
            'On-site Service' => Service::where('status', 'active')->where('type', 'On-site Service')->count(),
            'Consultation' => Service::where('status', 'active')->where('type', 'Consultation')->count(),
        ];

        return view('services.list', compact('services', 'categoriesList', 'typeCounts'));
    }
}
