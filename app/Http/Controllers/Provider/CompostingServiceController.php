<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\StoreCompostingServiceRequest;
use App\Http\Requests\Provider\UpdateCompostingServiceRequest;
use App\Models\CompostingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CompostingServiceController extends Controller
{
    public function index(Request $request): View
    {
        return view('provider.services.index', [
            'services' => $request->user()
                ->compostingServices()
                ->latest()
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('provider.services.create', [
            'service' => new CompostingService([
                'unit' => 'service',
                'approval_status' => CompostingService::STATUS_DRAFT,
            ]),
            'categories' => CompostingService::categories(),
        ]);
    }

    public function store(StoreCompostingServiceRequest $request): RedirectResponse
    {
        $data = Arr::except($request->validated(), ['submit_for_review']);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['approval_status'] = $request->boolean('submit_for_review')
            ? CompostingService::STATUS_PENDING
            : CompostingService::STATUS_DRAFT;

        $service = $request->user()->compostingServices()->create($data);

        return redirect()
            ->route('provider.services.index')
            ->with('status', $service->approval_status === CompostingService::STATUS_PENDING
                ? 'Service submitted for admin review.'
                : 'Service saved as a draft.');
    }

    public function edit(Request $request, CompostingService $service): View
    {
        $this->authorizeProviderService($request, $service);

        return view('provider.services.edit', [
            'service' => $service,
            'categories' => CompostingService::categories(),
        ]);
    }

    public function update(UpdateCompostingServiceRequest $request, CompostingService $service): RedirectResponse
    {
        $this->authorizeProviderService($request, $service);

        $data = Arr::except($request->validated(), ['submit_for_review']);

        if ($service->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $service);
        }

        $service->fill($data);

        if ($request->boolean('submit_for_review')) {
            $service->markAsNeedingReview();
        } elseif ($service->approval_status === CompostingService::STATUS_APPROVED && $service->isDirty(array_keys($data))) {
            $service->markAsNeedingReview();
        } elseif ($service->approval_status === CompostingService::STATUS_REJECTED && $service->isDirty(array_keys($data))) {
            $service->approval_status = CompostingService::STATUS_DRAFT;
            $service->approval_notes = null;
        }

        $service->save();

        return redirect()
            ->route('provider.services.index')
            ->with('status', 'Service updated successfully.');
    }

    public function destroy(Request $request, CompostingService $service): RedirectResponse
    {
        $this->authorizeProviderService($request, $service);

        $service->delete();

        return redirect()
            ->route('provider.services.index')
            ->with('status', 'Service deleted successfully.');
    }

    public function submit(Request $request, CompostingService $service): RedirectResponse
    {
        $this->authorizeProviderService($request, $service);

        if ($service->approval_status === CompostingService::STATUS_APPROVED) {
            return back()->with('status', 'This service is already approved.');
        }

        $service->markAsNeedingReview();
        $service->save();

        return back()->with('status', 'Service submitted for admin review.');
    }

    public function publish(Request $request, CompostingService $service): RedirectResponse
    {
        $this->authorizeProviderService($request, $service);

        if (! $request->user()->hasApprovedProviderProfile()) {
            return back()->withErrors([
                'publish' => 'Your provider profile must be approved by an admin before services can be published.',
            ]);
        }

        if (! $service->canBePublished()) {
            return back()->withErrors([
                'publish' => 'This service must be approved by an admin before it can be published.',
            ]);
        }

        $service->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back()->with('status', 'Service published successfully.');
    }

    public function unpublish(Request $request, CompostingService $service): RedirectResponse
    {
        $this->authorizeProviderService($request, $service);

        $service->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return back()->with('status', 'Service unpublished successfully.');
    }

    private function authorizeProviderService(Request $request, CompostingService $service): void
    {
        abort_unless($service->provider_id === $request->user()->id, 403);
    }

    private function uniqueSlug(string $title, ?CompostingService $ignore = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (CompostingService::query()
            ->when($ignore, fn ($query) => $query->whereKeyNot($ignore->getKey()))
            ->where('slug', $slug)
            ->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
