@extends('layouts.app')

@section('title', 'Login Petugas - Buku Tamu SMK PESAT')

@section('content')
<div class="max-w-md mx-auto px-4 py-12">

    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8 space-y-6">
        
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-slate-900 text-orange-500 flex items-center justify-center font-extrabold text-2xl mx-auto shadow-md">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Login Petugas / Admin</h1>
            <p class="text-xs text-slate-500">Masuk untuk mengelola data kunjungan tamu SMK PESAT.</p>
        </div>

        <!-- Demo Account Helper Box -->
        <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 space-y-1">
            <div class="font-bold flex items-center">
                <i class="fa-solid fa-key mr-1.5 text-amber-600"></i> Akun Demo Sistem:
            </div>
            <div class="flex justify-between font-mono">
                <span>Email Admin:</span>
                <strong>admin@pesat.sch.id</strong>
            </div>
            <div class="flex justify-between font-mono">
                <span>Password:</span>
                <strong>password</strong>
            </div>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Email Petugas <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email', 'admin@pesat.sch.id') }}" required
                        placeholder="admin@pesat.sch.id"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                </div>
                @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Password <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-key"></i>
                    </span>
                    <input type="password" name="password" value="password" required
                        placeholder="••••••••"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                </div>
                @error('password') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs text-slate-600">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center space-x-2">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>MASUK KE DASHBOARD</span>
            </button>
        </form>

    </div>

</div>
@endsection
