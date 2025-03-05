<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/AdminIndex', ['admins' => User::latest('id')->get()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|lowercase|regex:/^[a-zA-Z0-9-]+$/|max:255|unique:'.User::class.',username',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('admins.index');
    }

    public function destroy(User $admin)
    {
        $admin->delete();

        return redirect()->route('admins.index');
    }
}
