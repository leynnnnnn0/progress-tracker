<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Setting/Index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back();
    }
}
