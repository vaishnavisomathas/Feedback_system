<?php

namespace App\Http\Controllers;

use App\Models\ComplainType;
use Illuminate\Http\Request;

class ComplainTypeController extends Controller
{
  public function index()
    {
        $types = ComplainType::latest()->paginate(10);
        return view('admin.complain_type.index', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:complain_types,name'
        ]);

        ComplainType::create($request->all());

        return back()->with('success','Complain type created');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:complain_types,name,'.$id
        ]);

        ComplainType::findOrFail($id)->update($request->all());

        return back()->with('success','Complain type updated');
    }

    public function destroy($id)
    {
        ComplainType::destroy($id);
        return back()->with('success','Deleted successfully');
    }
}
