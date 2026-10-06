<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->role === 'teacher' ? 'teacher.schedules.index' : 'admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(
                Auth::user()->role === 'teacher' ? route('teacher.schedules.index') : route('admin.dashboard')
            )->with('success', 'Selamat datang kembali, '.Auth::user()->name);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    public function teacherLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route(
                Auth::user()->role === 'teacher' ? 'teacher.schedules.index' : 'admin.dashboard'
            );
        }

        return view('auth.teacher_login');
    }

    public function teacherLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if ($user->role !== 'teacher') {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun ini bukan akun guru.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('teacher.schedules.index'))
                ->with('success', 'Selamat datang kembali, '.$user->name);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }
}
