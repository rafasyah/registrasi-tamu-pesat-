@extends('layouts.app')

@section('title', 'Profil Tamu ' . $visit->guest_name . ' - Buku Tamu PESAT')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Profil Tamu -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-6 text-white shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-2xl bg-orange-500 text-white flex items-center justify-center font-extrabold text-2xl shadow-md shrink-0">
                {{ strtoupper(substr($visit->guest_name, 0, 1)) }}
            </div>
            <div>
                <span class="bg-orange-500/20 text-orange-400 border border-orange-500/30 text-[11px] font-semibold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    <i class="fa-solid fa-id-card mr-1"></i> Profil Tamu
                </span>
                <h1 class="text-xl font-bold mt-1">{{ $visit->guest_name }}</h1>
                <p class="text-xs text-slate-300">
                    {{ $visit->institution ?: 'Tamu Pribadi' }} &bull;
                    <i class="fa-solid fa-phone mr-0.5"></i> {{ $visit->phone }}
                    @if($visit->email)
                        &bull; <i class="fa-solid fa-envelope mr-0.5"></i> {{ $visit->email }}
                    @endif
                </p>
            </div>
        </div>

        <a href="{{ route('ticket.show', $visit->ticket_code) }}" class="px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-md flex items-center space-x-2 transition-all shrink-0">
            <i class="fa-solid fa-ticket"></i>
            <span>Lihat Tiket Aktif</span>
        </a>
    </div>

    <!-- Ringkasan Riwayat -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Kunjungan</p>
            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total'] }}</h3>
            <span class="text-[11px] text-slate-400"><i class="fa-solid fa-ticket mr-1"></i> Seluruh tiket terdaftar</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Selesai</p>
            <h3 class="text-2xl font-extrabold text-slate-700 mt-1">{{ $stats['completed'] }}</h3>
            <span class="text-[11px] text-slate-400"><i class="fa-solid fa-circle-check mr-1"></i> Kunjungan tuntas</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Berlangsung</p>
            <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $stats['active'] }}</h3>
            <span class="text-[11px] text-slate-400"><i class="fa-solid fa-spinner-third mr-1"></i> Aktif / menunggu</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Ditolak</p>
            <h3 class="text-2xl font-extrabold text-rose-600 mt-1">{{ $stats['rejected'] }}</h3>
            <span class="text-[11px] text-slate-400"><i class="fa-solid fa-circle-xmark mr-1"></i> Tidak disetujui</span>
        </div>
    </div>

    <!-- Riwayat Tiket -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-orange-600"></i>
                    <span>Riwayat Tiket Kunjungan</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Seluruh tiket kunjungan Anda yang terdaftar dengan nomor HP <span class="font-semibold">{{ $visit->phone }}</span>.</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800 self-start sm:self-auto">
                {{ $history->count() }} Tiket
            </span>
        </div>

        <div class="divide-y divide-slate-100">
            @foreach($history as $item)
                <div class="p-4 sm:p-5 hover:bg-slate-50/80 transition-colors {{ $item->id === $visit->id ? 'bg-orange-50/40 border-l-4 border-orange-500' : '' }}">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">

                        <!-- Kode & Identitas -->
                        <div class="lg:w-1/4">
                            <div class="font-bold text-slate-900 font-mono text-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-ticket text-orange-500 text-xs"></i>
                                {{ $item->ticket_code }}
                            </div>
                            @if($item->id === $visit->id)
                                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-orange-600 text-white">Tiket Ini</span>
                            @endif
                        </div>

                        <!-- Jadwal -->
                        <div class="lg:w-1/4 text-xs">
                            <div class="font-semibold text-slate-800">
                                <i class="fa-regular fa-calendar mr-1 text-slate-400"></i>
                                {{ $item->visit_date ? $item->visit_date->format('d/m/Y') : '-' }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                <i class="fa-regular fa-clock mr-1 text-slate-400"></i>
                                {{ substr($item->scheduled_time, 0, 5) }} WIB
                            </div>
                        </div>

                        <!-- Keperluan & Tujuan -->
                        <div class="lg:w-2/5 text-xs">
                            <div class="font-medium text-slate-800 truncate" title="{{ $item->purpose }}">{{ $item->purpose }}</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                {{ $item->department->name ?? 'Umum' }}
                                @if($item->host)
                                    &bull; {{ $item->host->name }}
                                @endif
                            </div>
                        </div>

                        <!-- Status & Aksi -->
                        <div class="lg:w-auto flex items-center justify-between lg:justify-end gap-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border whitespace-nowrap {{ $item->status_badge }}">
                                {{ $item->status_label }}
                            </span>
                            <a href="{{ route('ticket.show', $item->ticket_code) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition-colors whitespace-nowrap" title="Lihat Detail Tiket">
                                <i class="fa-solid fa-eye mr-1"></i> Detail
                            </a>
                        </div>

                    </div>

                    @if($item->meeting_result)
                        <div class="mt-3 p-3 bg-emerald-50 border border-emerald-200 rounded-lg text-[11px] text-emerald-900">
                            <strong class="font-bold text-emerald-800"><i class="fa-solid fa-file-lines mr-1"></i> Hasil Pertemuan:</strong>
                            {{ $item->meeting_result }}
                        </div>
                    @endif

                    @if($item->rejection_reason)
                        <div class="mt-3 p-3 bg-rose-50 border border-rose-200 rounded-lg text-[11px] text-rose-800">
                            <strong class="font-bold"><i class="fa-solid fa-circle-xmark mr-1"></i> Alasan Penolakan:</strong>
                            {{ $item->rejection_reason }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Navigasi -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-3 pt-2">
        <a href="{{ route('guest.register') }}" class="w-full sm:w-auto px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold flex items-center justify-center space-x-2 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Registrasi Tamu Baru</span>
        </a>

        <a href="{{ route('ticket.lookup') }}" class="w-full sm:w-auto px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-semibold flex items-center justify-center space-x-2 transition-colors">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span>Cari Tiket Lain</span>
        </a>
    </div>

</div>
@endsection
