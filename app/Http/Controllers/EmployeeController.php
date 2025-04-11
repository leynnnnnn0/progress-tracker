<?php

namespace App\Http\Controllers;

use App\Enum\Position;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index()
    {
        $search = request('search');
        $query = Employee::query();
        if ($search)
            $query->whereAny(['first_name', 'last_name'], 'like', "%$search%");

        $employees = $query->latest()->paginate(10)->withQueryString();
        return Inertia::render('Employee/Index', [
            'employees' => $employees,
            'filters' => request()->only(['search'])
        ]);
    }

    public function edit($id)
    {
        $positions = Position::options();
        $employee = Employee::findOrFail($id);
        return Inertia::render('Employee/Edit', [
            'employee' => $employee,
            'positions' => $positions,
        ]);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return Inertia::render('Employee/Show', [
            'employee' => $employee
        ]);
    }

    public function create()
    {
        $positions = Position::options();

        return Inertia::render('Employee/Create', [
            'positions' => $positions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'position' => ['required']
        ]);

        Employee::create($validated);

        return to_route('employees.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'position' => ['required']
        ]);

        Employee::findOrFail($id)->update($validated);

        return to_route('employees.index');
    }
}
