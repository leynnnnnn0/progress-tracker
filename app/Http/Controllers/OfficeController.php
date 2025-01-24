<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::latest()->paginate(10);

        return Inertia::render('Office/Index', [
            'offices' => $offices
        ]);
    }

    public function destroy($id)
    {
        $office = Office::findOrFail($id);
        $office->delete();

        return back();
    }

    public function create()
    {
        return Inertia::render('Office/Create');
    }

    public function edit($id)
    {
        $office = Office::findOrFail($id);
        return Inertia::render('Office/Edit', [
            'office' => $office
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:offices,name,' . $id],
            'office_code' => ['required', 'unique:offices,office_code,' . $id],
            'remarks' => ['nullable']
        ]);

        $office = Office::findOrFail($id);
        $office->update($validated);

        return to_route('offices.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:offices,name'],
            'office_code' => ['required', 'unique:offices,office_code'],
            'remarks' => ['nullable']
        ]);

        Office::create($validated);

        return to_route('offices.index');
    }
}
