<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'admin') return redirect()->route('admin.dashboard');
            if ($user->role === 'agency') return redirect()->route('agency.dashboard');
            
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,agency'],
            'agency_name' => ['required_if:role,agency', 'nullable', 'string', 'max:255'],
            'legal_id' => ['required_if:role,agency', 'nullable', 'string', 'max:255'],
            'city' => ['required_if:role,agency', 'nullable', 'string', 'max:255'],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            if ($validated['role'] === 'agency') {
                Agency::create([
                    'user_id' => $user->id,
                    'agency_name' => $validated['agency_name'],
                    'legal_id' => $validated['legal_id'],
                    'city' => $validated['city'],
                    'phone' => $validated['phone'],
                    'address' => '',
                    'status' => 'pending',
                ]);
            }

            return $user;
        });

        Auth::login($user);
        
        if ($user->role === 'agency') {
            return redirect()->route('agency.dashboard');
        }

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
