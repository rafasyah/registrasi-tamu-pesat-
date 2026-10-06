@extends('layouts.app')

@section('title', 'Cek Status Tiket Kunjungan - Buku Tamu SMK PESAT')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-8 text-center space-y-6">
        
        <div class="w-16 h-16 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-2xl mx-auto shadow-sm">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>

        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Cek Status Tiket Kunjungan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-md mx-auto">
                Masukkan **Kode Tiket** (contoh: <code class="bg-slate-100 px-1.5 py-0.5 rounded font-mono text-orange-600">JTT-2026-0001</code>) atau **Nomor Telepon** Anda untuk melihat status dan mencetak pass.
            </p>
        </div>

        <form action="{{ route('ticket.search') }}" method="POST" class="space-y-4">
            @csrf

            <div class="relative max-w-md mx-auto">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-ticket"></i>
                </span>
                <input type="text" name="query" value="{{ old('query') }}" required
                    placeholder="Masukkan Kode Tiket / No WhatsApp..."
                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-base font-medium focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all shadow-xs">
            </div>

            <button type="submit" class="w-full max-w-md py-3.5 bg-orange-600 hover:bg-orange-500 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-orange-500/25 transition-all flex items-center justify-center space-x-2 mx-auto">
                <i class="fa-solid fa-search"></i>
                <span>CARI TIKET KUNJUNGAN</span>
            </button>
        </form>

        <div class="pt-6 border-t border-slate-100 text-xs text-slate-400">
            Belum mendaftarkan kunjungan? 
            <a href="{{ route('guest.register') }}" class="font-bold text-orange-600 hover:underline ml-1">Daftar Tamu Baru di sini &rarr;</a>
        </div>
    </div>

</div>
@endsection
