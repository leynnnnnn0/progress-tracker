<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\SubTarget;
use App\Models\User;
use App\Models\UsersOffices;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $search = request('search');
        $query = User::query();
        if ($search)
            $query->whereAny(['first_name', 'last_name'], 'like', "%$search%");
        $users = $query->latest()->paginate(10)->withQueryString();
        return Inertia::render('User/Index', [
            'users' => $users,
            'filters' => request()->only(['search'])
        ]);
    }

    public function create()
    {
        $offices = Office::getOptions();

        return Inertia::render('User/Create', [
            'offices' => $offices
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'middle_name' => ['nullable', 'string', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'last_name' => ['required', 'string', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'phone_number' => [
                'required',
                'numeric',
                'digits:11',
                'regex:/^09\d{9}$/'
            ],
            'is_admin' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'assignedOffices' => ['required', 'array']
        ], [
            'is_admin.required' => 'The role field is required.'
        ]);
        $validated['password'] = Hash::make('password');

        DB::beginTransaction();
        $user = User::create(Arr::except($validated, 'assignedOffices'));
        foreach ($validated['assignedOffices'] as $officeId) {
            UsersOffices::create([
                'user_id' => $user->id,
                'office_id' => $officeId
            ]);
        }
        DB::commit();

        return to_route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return to_route('users.index');
    }

    public function edit($id)
    {
        $user = User::with('offices')->findOrFail($id);
        $offices = Office::getOptions();
        return Inertia::render('User/Edit', [
            'user' => $user,
            'offices' => $offices
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'middle_name' => ['nullable', 'string', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'last_name' => ['required', 'string', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'phone_number' => [
                'required',
                'digits:10',
                // 'regex:/^09\d{9}$/'
            ],
            'is_admin' => ['required'],
            'is_active' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'assignedOffices' => ['required', 'array']
        ], [
            'is_admin.required' => 'The role field is required.',
            'is_active.required' => 'The is account active field is required.'
        ]);
        $user = User::findOrFail($id);
        DB::beginTransaction();
        $user->update(Arr::except($validated, 'assignedOffices'));

        $currentOfficeIds = $user->offices()->pluck('office_id')->toArray();

        $officesToAdd = array_diff($validated['assignedOffices'], $currentOfficeIds);
        $officesToRemove = array_diff($currentOfficeIds, $validated['assignedOffices']);

        UsersOffices::where('user_id', $user->id)
            ->whereIn('office_id', $officesToRemove)
            ->delete();

        foreach ($officesToAdd as $officeId) {
            UsersOffices::create([
                'user_id' => $user->id,
                'office_id' => $officeId
            ]);
        }
        DB::commit();

        return to_route('users.index');
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('User/Show', [
            'user' => $user
        ]);
    }
}
