<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show login form
    public function showLogin(Request $request)
    {
        $role = $request->query('role', 'pelanggan');
        return view('auth.login', compact('role'));
    }

    // Process login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,kasir,pelanggan'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Check if role matches
            if ($user->role !== $request->role) {
                Auth::logout();
                return back()->with('error', 'Role tidak sesuai!');
            }

            $request->session()->regenerate();

            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'kasir':
                    return redirect()->intended('/kasir/dashboard');
                case 'pelanggan':
                    return redirect()->intended('/pelanggan/dashboard');
                default:
                    return redirect('/');
            }
        }

        return back()->with('error', 'Email atau password salah!');
    }

    // Show register form
    public function showRegister(Request $request)
    {
        $role = $request->query('role', 'pelanggan');
        return view('auth.register', compact('role'));
    }

    // Process register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,kasir,pelanggan'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        Auth::login($user);

        // Redirect based on role
        switch ($user->role) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'kasir':
                return redirect('/kasir/dashboard');
            case 'pelanggan':
                return redirect('/pelanggan/dashboard');
            default:
                return redirect('/');
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
