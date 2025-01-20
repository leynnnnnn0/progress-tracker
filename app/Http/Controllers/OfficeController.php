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

    public function create()
    {
        return Inertia::render('Office/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:offices,name'],
            'remarks' => ['nullable']
        ]);

        Office::create($validated);

        return to_route('offices.index');
    }
}
