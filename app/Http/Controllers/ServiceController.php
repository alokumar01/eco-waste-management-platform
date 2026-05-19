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
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $services = $query->latest()->get();
        return view('services.list', compact('services'));
    }
}
