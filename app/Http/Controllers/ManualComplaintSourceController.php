<?php

namespace App\Http\Controllers;

use App\Models\ManualComplaintSource;
use Illuminate\Http\Request;

class ManualComplaintSourceController extends Controller
{
    public function index(Request $request)
    {
        $sources = ManualComplaintSource::latest()->paginate($request->per_page ?? 10);

        return view('admin.manual_complaint_source.index', compact('sources'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:manual_complaint_sources,name',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? true);

        ManualComplaintSource::create($data);

        return back()->with('success', 'Manual complaint source created.');
    }

    public function update(Request $request, ManualComplaintSource $manualComplaintSource)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:manual_complaint_sources,name,' . $manualComplaintSource->id,
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        $manualComplaintSource->update($data);

        return back()->with('success', 'Manual complaint source updated.');
    }

    public function destroy(ManualComplaintSource $manualComplaintSource)
    {
        $manualComplaintSource->delete();

        return back()->with('success', 'Manual complaint source deleted.');
    }
}
