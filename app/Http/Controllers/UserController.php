<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10)->withQueryString();
        return Inertia::render('User/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'phone_number' => ['required', 'numeric'],
            'email' => ['required', 'email', 'unique:users,email']
        ]);
        $validated['password'] = Hash::make('password');
        User::create($validated);

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
        $user = User::findOrFail($id);
        return Inertia::render('User/Edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['nullable'],
            'last_name' => ['required'],
            'phone_number' => ['required', 'numeric'],
            'email' => ['required', 'email', 'unique:users,email,' . $id]
        ]);
        $user = User::findOrFail($id);
        $user->update($validated);

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
