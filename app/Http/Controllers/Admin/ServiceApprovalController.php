<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompostingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceApprovalController extends Controller
{
    public function index(): View
    {
        return view('admin.services.index', [
            'services' => CompostingService::query()
                ->with('provider')
                ->where('approval_status', CompostingService::STATUS_PENDING)
                ->oldest()
                ->paginate(10),
        ]);
    }

    public function approve(Request $request, CompostingService $service): RedirectResponse
    {
        $service->update([
            'approval_status' => CompostingService::STATUS_APPROVED,
            'approval_notes' => null,
            'approved_at' => now(),
            'approved_by' => $request->user()->id,
        ]);

        return back()->with('status', 'Service approved. The provider can publish it now.');
    }

    public function reject(Request $request, CompostingService $service): RedirectResponse
    {
        $validated = $request->validate([
            'approval_notes' => ['required', 'string', 'max:1200'],
            'approval_status' => ['nullable', Rule::in([CompostingService::STATUS_REJECTED])],
        ]);

        $service->update([
            'approval_status' => CompostingService::STATUS_REJECTED,
            'approval_notes' => $validated['approval_notes'],
            'approved_at' => null,
            'approved_by' => null,
            'is_published' => false,
            'published_at' => null,
        ]);

        return back()->with('status', 'Service rejected with feedback.');
    }
}
