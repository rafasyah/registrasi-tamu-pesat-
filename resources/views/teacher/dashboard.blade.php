@extends('layouts.teacher')

@section('title', 'Dashboard Guru - Buku Tamu PESAT')
@section('page_title', 'Jadwal & Pertemuan Guru')
@section('page_subtitle', 'Lihat jadwal pertemuan, kunjungan tamu, dan aktivitas terkini Anda.')

@section('content')
<div class="space-y-6">

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Jadwal</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $stats['total'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center font-bold text-xl">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Dijadwalkan</p>
                <h3 class="text-2xl font-extrabold text-blue-600 mt-1">{{ $stats['scheduled'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Berlanjut</p>
                <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $stats['ongoing'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xl">
                <i class="fa-solid fa-spinner-third animate-spin-slow"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Selesai</p>
                <h3 class="text-2xl font-extrabold text-slate-700 mt-1">{{ $stats['completed'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Dibatalkan</p>
                <h3 class="text-2xl font-extrabold text-rose-600 mt-1">{{ $stats['cancelled'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xl">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
        </div>

    </div>

    <!-- Schedule List -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">

        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">Daftar Jadwal Pertemuan</h3>
            <a href="{{ route('teacher.schedules.create') }}" class="px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold transition-colors flex items-center space-x-2">
                <i class="fa-solid fa-plus"></i>
                <span>Buat Jadwal</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">Jadwal</th>
                        <th class="py-3.5 px-4">Lokasi</th>
                        <th class="py-3.5 px-4">Departemen</th>
                        <th class="py-3.5 px-4">Tamu Terhubung</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($schedules as $schedule)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $schedule->title }}</div>
                                <div class="text-[11px] text-slate-500">
                                    <i class="fa-solid fa-calendar mr-1"></i>
                                    {{ $schedule->scheduled_date->format('d/m/Y') }}
                                    <i class="fa-solid fa-clock mr-1 ml-2"></i>
                                    {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-sm text-slate-700">{{ $schedule->location ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-orange-50 text-orange-700 border border-orange-200">
                                    {{ $schedule->department->name ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($schedule->guestVisits->isNotEmpty())
                                    <div class="flex items-center space-x-1">
                                        <span class="text-slate-700">{{ $schedule->guestVisits->count() }}</span>
                                        <span class="text-[10px] text-slate-500">tamu</span>
                                    </div>
                                @else
                                    <span class="text-slate-400 text-[10px]">Belum ada tamu</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $schedule->status_badge }}">
                                    {{ $schedule->status_label }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <a href="{{ route('teacher.schedules.show', $schedule) }}" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs transition-colors" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('teacher.schedules.edit', $schedule) }}" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs transition-colors" title="Edit Jadwal">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('teacher.schedules.destroy', $schedule) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus jadwal ini?')" class="p-1.5 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-700 rounded-lg text-xs transition-colors" title="Hapus Jadwal">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-calendar-xmark text-4xl mb-3 block text-slate-300"></i>
                                <p class="text-sm">Belum ada jadwal pertemuan yang dibuat.</p>
                                <a href="{{ route('teacher.schedules.create') }}" class="mt-2 inline-flex items-center text-orange-600 hover:text-orange-800 text-xs font-semibold">
                                    <i class="fa-solid fa-plus mr-1"></i> Buat Jadwal Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $schedules->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
