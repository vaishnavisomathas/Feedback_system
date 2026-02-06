<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
  public function index()
    {
        $counters = Counter::latest()->get();
        return view('admin.counter.index', compact('counters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'district' => 'required|string|max:255',
            'division_name' => 'required|string|max:255',
            'counter_name' => 'required|string|max:255',
        ]);

        Counter::create($request->all());

        return redirect()->back()->with('success', 'Counter created successfully.');
    }

    public function update(Request $request, Counter $counter)
    {
        $request->validate([
            'district' => 'required|string|max:255',
            'division_name' => 'required|string|max:255',
            'counter_name' => 'required|string|max:255',
        ]);

        $counter->update($request->all());

        return redirect()->back()->with('success', 'Counter updated successfully.');
    }

    public function destroy(Counter $counter)
    {
        $counter->delete();
        return redirect()->back()->with('success', 'Counter deleted successfully.');
    }
}
