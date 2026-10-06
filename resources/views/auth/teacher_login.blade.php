@extends('layouts.app')

@section('title', 'Login Guru - Buku Tamu PESAT')

@section('content')
<div class="max-w-md mx-auto py-12 px-4">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-gradient-to-tr from-orange-500 to-orange-600 flex items-center justify-center text-white font-extrabold text-2xl shadow-lg">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Panel Guru</h1>
            <p class="text-slate-500 mt-1">Masuk untuk mengelola jadwal pertemuan Anda</p>
        </div>

        <!-- Flash Messages -->
        @if(session('error'))
            <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-xmark text-rose-600 text-lg"></i>
                    <p class="text-sm font-medium text-rose-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-xmark text-rose-600 text-lg"></i>
                    <p class="text-sm font-medium text-rose-800">{{ $errors->first() }}</p>
                </div>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('teacher.login.post') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                    Email
                </label>
                <div class="relative">
                    <input type="email" name="email" id="email"
                        value="{{ old('email') }}"
                        required autofocus autocomplete="email"
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                </div>
                @error('email')
                    <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                    Password
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        required autocomplete="current-password"
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>
                @error('password')
                    <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-orange-600 border-slate-300 rounded focus:ring-orange-500">
                    <span class="text-sm text-slate-600">Ingat saya</span>
                </label>
            </div>

            <button type="submit"
                class="w-full py-3 bg-orange-600 hover:bg-orange-500 text-white rounded-xl font-bold text-sm transition-colors shadow-md hover:shadow-lg">
                <i class="fa-solid fa-sign-in-alt mr-2"></i> Masuk ke Dashboard Guru
            </button>
        </form>

        <!-- Links -->
        <div class="mt-6 text-center space-y-3">
            <a href="{{ route('login') }}"
                class="text-sm text-slate-600 hover:text-orange-600 font-medium transition-colors flex items-center justify-center space-x-1">
                <i class="fa-solid fa-user-shield"></i>
                <span>Login Petugas / Admin</span>
            </a>
            <a href="{{ route('home') }}"
                class="text-sm text-slate-600 hover:text-slate-800 font-medium transition-colors">
                <i class="fa-solid fa-house mr-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- Info -->
    <div class="mt-6 text-center">
        <p class="text-xs text-slate-400">
            <i class="fa-solid fa-circle-info mr-1"></i>
            Akses khusus untuk guru & staf yang memiliki akun <strong>role: teacher</strong>
        </p>
    </div>
</div>
@endsection