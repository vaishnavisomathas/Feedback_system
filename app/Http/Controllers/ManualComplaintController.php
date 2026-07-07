<?php

namespace App\Http\Controllers;

use App\Models\ComplainType;
use App\Models\ManualComplaint;
use App\Models\ManualComplaintSource;
use Illuminate\Http\Request;

class ManualComplaintController extends Controller
{
    private function roleKey(): string
    {
        return strtolower(trim((string) auth()->user()->role));
    }

    private function authorizeRoles(array $roles): void
    {
        if (!in_array($this->roleKey(), $roles, true)) {
            abort(403, 'Unauthorized action.');
        }
    }

    private function canManageManualEntry(): array
    {
        return ['super admin', 'admin', 'user', 'administrative officer', 'commissioner'];
    }

    private function canAddManualComplaint(): array
    {
        return ['super admin', 'admin', 'user'];
    }

    private function canManageManualAO(): array
    {
        return ['super admin', 'admin', 'administrative officer'];
    }

    private function canManageManualCommissioner(): array
    {
        return ['super admin', 'admin', 'commissioner'];
    }

    private function isAdministrativeOfficer(): bool
    {
        return in_array($this->roleKey(), ['administrative officer', 'a/o', 'ao'], true);
    }

    public function index(Request $request)
    {
        $this->authorizeRoles($this->canManageManualEntry());

        $filters = [
            'source_id' => $request->source_id,
            'status' => $request->status,
            'from' => $request->from,
            'to' => $request->to,
            'search' => $request->search,
        ];

        if ($this->isAdministrativeOfficer()) {
            $allowedAoStatuses = ['pending', 'verified', 'commissioner', 'completed'];
            if (!in_array((string) $filters['status'], $allowedAoStatuses, true)) {
                $filters['status'] = null;
            }
        }

        $manualComplaints = ManualComplaint::with(['complainType', 'enteredByUser', 'sourceSetting'])
            ->when($this->isAdministrativeOfficer(), fn($q) => $q->whereIn('status', ['pending', 'ao', 'verified', 'commissioner', 'completed']))
            ->when($filters['source_id'], fn($q) => $q->where('source_id', $filters['source_id']))
            ->when($filters['status'], function ($q) use ($filters) {
                if ($filters['status'] === 'pending') {
                    $q->whereIn('status', ['pending', 'ao']);

                    return;
                }

                $q->where('status', $filters['status']);
            })
            ->when($filters['from'], fn($q) => $q->whereDate('received_at', '>=', $filters['from']))
            ->when($filters['to'], fn($q) => $q->whereDate('received_at', '<=', $filters['to']))
            ->when($filters['search'], function ($q) use ($filters) {
                $term = $filters['search'];
                $q->where(function ($sub) use ($term) {
                    $sub->where('complainant_name', 'like', '%' . $term . '%')
                        ->orWhere('phone', 'like', '%' . $term . '%')
                        ->orWhere('complaint_email', 'like', '%' . $term . '%')
                        ->orWhere('vehicle_number', 'like', '%' . $term . '%')
                        ->orWhere('complaint', 'like', '%' . $term . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate($request->per_page ?? 10)
            ->appends($request->query());

        $sources = ManualComplaintSource::where('is_active', true)->orderBy('name')->get();
        $types = ComplainType::orderBy('name')->get();

        return view('admin.manual_complaint.index', compact('manualComplaints', 'types', 'sources', 'filters'));
    }

    public function store(Request $request)
    {
        $this->authorizeRoles($this->canAddManualComplaint());

        $data = $request->validate([
            'source_id' => 'required|exists:manual_complaint_sources,id',
            'complainant_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'complaint_email' => 'nullable|email|max:255',
            'vehicle_number' => 'nullable|string|max:20',
            'complain_type_id' => 'nullable|exists:complain_types,id',
            'complaint' => 'required|string|max:2000',
            'received_at' => 'nullable|date',
        ]);

        $selectedSource = ManualComplaintSource::find($data['source_id']);
        $data['source'] = $selectedSource?->name;
        $data['status'] = $this->isAdministrativeOfficer() ? 'commissioner' : 'pending';

        $data['entered_by'] = auth()->id();
        $data['received_at'] = $data['received_at'] ?? now()->toDateString();

        ManualComplaint::create($data);

        return back()->with('success', 'Manual complaint saved successfully.');
    }

    public function update(Request $request, ManualComplaint $manualComplaint)
    {
        $this->authorizeRoles($this->canManageManualEntry());

        $data = $request->validate([
            'source_id' => 'required|exists:manual_complaint_sources,id',
            'complainant_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'complaint_email' => 'nullable|email|max:255',
            'vehicle_number' => 'nullable|string|max:20',
            'complain_type_id' => 'nullable|exists:complain_types,id',
            'complaint' => 'required|string|max:2000',
            'received_at' => 'nullable|date',
        ]);

        $selectedSource = ManualComplaintSource::find($data['source_id']);
        $data['source'] = $selectedSource?->name;

        // Keep AO-created pending records moving forward in pipeline.
        if (($manualComplaint->status ?? null) === 'pending' && $this->isAdministrativeOfficer()) {
            $data['status'] = 'commissioner';
        }

        $manualComplaint->update($data);

        return back()->with('success', 'Manual complaint updated successfully.');
    }

    public function destroy(ManualComplaint $manualComplaint)
    {
        $this->authorizeRoles($this->canManageManualEntry());

        $manualComplaint->delete();

        return back()->with('success', 'Manual complaint deleted successfully.');
    }

    public function forwardToAO(ManualComplaint $manualComplaint)
    {
        $this->authorizeRoles($this->canManageManualEntry());

        if ($manualComplaint->status !== 'pending') {
            return back()->with('warning', 'Only pending complaints can be forwarded.');
        }

        if ($this->isAdministrativeOfficer()) {
            $manualComplaint->update(['status' => 'commissioner']);

            return back()->with('success', 'Manual complaint forwarded to Commissioner successfully.');
        }

        $manualComplaint->update(['status' => 'ao']);

        return back()->with('success', 'Manual complaint forwarded to A/O successfully.');
    }

    public function saveActionNote(Request $request, ManualComplaint $manualComplaint)
    {
        $this->authorizeRoles($this->canManageManualEntry());

        $data = $request->validate([
            'action_note' => 'required|string|max:1000',
        ]);

        $manualComplaint->update([
            'action_note' => $data['action_note'],
        ]);

        return back()->with('success', 'Action note saved successfully.');
    }

    public function aoIndex(Request $request)
    {
        $this->authorizeRoles($this->canManageManualAO());

        $filters = [
            'status' => $request->status,
            'from' => $request->from,
            'to' => $request->to,
            'search' => $request->search,
        ];

        $pendingAO = ManualComplaint::with(['sourceSetting', 'complainType', 'enteredByUser'])
            ->where('status', 'ao')
            ->when($filters['from'], fn($q) => $q->whereDate('received_at', '>=', $filters['from']))
            ->when($filters['to'], fn($q) => $q->whereDate('received_at', '<=', $filters['to']))
            ->when($filters['search'], function ($q) use ($filters) {
                $term = $filters['search'];
                $q->where(function ($sub) use ($term) {
                    $sub->where('complainant_name', 'like', '%' . $term . '%')
                        ->orWhere('phone', 'like', '%' . $term . '%')
                        ->orWhere('complaint_email', 'like', '%' . $term . '%')
                        ->orWhere('vehicle_number', 'like', '%' . $term . '%')
                        ->orWhere('complaint', 'like', '%' . $term . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10, ['*'], 'pending_page')
            ->appends($request->query());

        $closedAO = ManualComplaint::with(['sourceSetting', 'complainType', 'enteredByUser'])
            ->whereIn('status', ['commissioner', 'completed', 'rejected'])
            ->when($filters['status'], fn($q) => $q->where('status', $filters['status']))
            ->when($filters['from'], fn($q) => $q->whereDate('received_at', '>=', $filters['from']))
            ->when($filters['to'], fn($q) => $q->whereDate('received_at', '<=', $filters['to']))
            ->when($filters['search'], function ($q) use ($filters) {
                $term = $filters['search'];
                $q->where(function ($sub) use ($term) {
                    $sub->where('complainant_name', 'like', '%' . $term . '%')
                        ->orWhere('phone', 'like', '%' . $term . '%')
                        ->orWhere('complaint_email', 'like', '%' . $term . '%')
                        ->orWhere('vehicle_number', 'like', '%' . $term . '%')
                        ->orWhere('complaint', 'like', '%' . $term . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10, ['*'], 'closed_page')
            ->appends($request->query());

        return view('admin.manual_complaint.ao', compact('pendingAO', 'closedAO', 'filters'));
    }

    public function aoSave(Request $request, ManualComplaint $manualComplaint)
    {
        $this->authorizeRoles($this->canManageManualAO());

        $data = $request->validate([
            'ao_remarks' => 'nullable|string|max:1000',
            'action' => 'required|in:verify,forward,reject',
        ]);

        $manualComplaint->ao_remarks = $data['ao_remarks'];
        if ($data['action'] === 'verify') {
            $manualComplaint->status = 'verified';
        } elseif ($data['action'] === 'forward') {
            $manualComplaint->status = 'commissioner';
        } else {
            $manualComplaint->status = 'rejected';
        }
        $manualComplaint->save();

        return back()->with('success', 'Manual complaint updated by A/O successfully.');
    }

    public function commissionerAction(Request $request, ManualComplaint $manualComplaint)
    {
        $this->authorizeRoles($this->canManageManualCommissioner());

        $data = $request->validate([
            'final_remarks' => 'nullable|string|max:1000',
            'action' => 'required|in:complete,reject',
        ]);

        $manualComplaint->commissioner_remarks = $data['final_remarks'] ?? null;
        $manualComplaint->status = $data['action'] === 'complete' ? 'completed' : 'rejected';
        $manualComplaint->save();

        return back()->with('success', 'Manual complaint finalized by Commissioner.');
    }

    public function commissionerIndex(Request $request)
    {
        $this->authorizeRoles($this->canManageManualCommissioner());

        $filters = [
            'status' => $request->status,
            'from' => $request->from,
            'to' => $request->to,
            'search' => $request->search,
        ];

        $pendingCommissioner = ManualComplaint::with(['sourceSetting', 'complainType', 'enteredByUser'])
            ->where('status', 'commissioner')
            ->when($filters['from'], fn($q) => $q->whereDate('received_at', '>=', $filters['from']))
            ->when($filters['to'], fn($q) => $q->whereDate('received_at', '<=', $filters['to']))
            ->when($filters['search'], function ($q) use ($filters) {
                $term = $filters['search'];
                $q->where(function ($sub) use ($term) {
                    $sub->where('complainant_name', 'like', '%' . $term . '%')
                        ->orWhere('phone', 'like', '%' . $term . '%')
                        ->orWhere('complaint_email', 'like', '%' . $term . '%')
                        ->orWhere('vehicle_number', 'like', '%' . $term . '%')
                        ->orWhere('complaint', 'like', '%' . $term . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10, ['*'], 'pending_page')
            ->appends($request->query());

        $closedCommissioner = ManualComplaint::with(['sourceSetting', 'complainType', 'enteredByUser'])
            ->whereIn('status', ['completed', 'rejected'])
            ->when($filters['status'], fn($q) => $q->where('status', $filters['status']))
            ->when($filters['from'], fn($q) => $q->whereDate('received_at', '>=', $filters['from']))
            ->when($filters['to'], fn($q) => $q->whereDate('received_at', '<=', $filters['to']))
            ->when($filters['search'], function ($q) use ($filters) {
                $term = $filters['search'];
                $q->where(function ($sub) use ($term) {
                    $sub->where('complainant_name', 'like', '%' . $term . '%')
                        ->orWhere('phone', 'like', '%' . $term . '%')
                        ->orWhere('complaint_email', 'like', '%' . $term . '%')
                        ->orWhere('vehicle_number', 'like', '%' . $term . '%')
                        ->orWhere('complaint', 'like', '%' . $term . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10, ['*'], 'closed_page')
            ->appends($request->query());

        return view('admin.manual_complaint.commissioner', compact('pendingCommissioner', 'closedCommissioner', 'filters'));
    }

    public function commissionerClose(Request $request, ManualComplaint $manualComplaint)
    {
        $this->authorizeRoles($this->canManageManualCommissioner());

        $data = $request->validate([
            'final_remarks' => 'required|string|max:1000',
            'action' => 'required|in:complete,reject',
        ]);

        $manualComplaint->commissioner_remarks = $data['final_remarks'];
        $manualComplaint->status = $data['action'] === 'complete' ? 'completed' : 'rejected';
        $manualComplaint->save();

        return back()->with('success', 'Manual complaint finalized by Commissioner.');
    }
}
