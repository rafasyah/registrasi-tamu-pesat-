@extends('layouts.admin')

@section('title', 'Laporan & Rekapitulasi - Buku Tamu PESAT')
@section('page_title', 'Laporan & Rekapitulasi Kunjungan')
@section('page_subtitle', 'Analisis statistik, rekapitulasi data bertamu, dan ekspor laporan ke format Excel/CSV.')

@section('content')
<div class="space-y-6">

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-200">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full p-2 bg-slate-50 border border-slate-300 rounded-xl text-xs">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full p-2 bg-slate-50 border border-slate-300 rounded-xl text-xs">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Departemen</label>
                <select name="department_id" class="w-full p-2 bg-slate-50 border border-slate-300 rounded-xl text-xs">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $departmentId == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Maksud / Keperluan</label>
                <select name="purpose" class="w-full p-2 bg-slate-50 border border-slate-300 rounded-xl text-xs">
                    <option value="">Semua Keperluan</option>
                    <option value="Dinas / Kedinasan" {{ $purpose == 'Dinas / Kedinasan' ? 'selected' : '' }}>Dinas / Kedinasan</option>
                    <option value="Wali Murid" {{ $purpose == 'Wali Murid' ? 'selected' : '' }}>Wali Murid</option>
                    <option value="Vendor / Kerjasama" {{ $purpose == 'Vendor / Kerjasama' ? 'selected' : '' }}>Vendor / Kerjasama</option>
                    <option value="Alumni" {{ $purpose == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                    <option value="Kunjungan Studi / Field Trip" {{ $purpose == 'Kunjungan Studi / Field Trip' ? 'selected' : '' }}>Kunjungan Studi</option>
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit" class="flex-1 py-2 bg-slate-900 text-white font-bold rounded-xl text-xs shadow-xs hover:bg-slate-800 transition-colors">
                    <i class="fa-solid fa-filter mr-1"></i> Terapkan
                </button>

                <a href="{{ route('admin.reports.export', request()->query()) }}" class="py-2 px-3 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs shadow-xs transition-colors flex items-center shrink-0" title="Export Excel / CSV">
                    <i class="fa-solid fa-file-excel mr-1"></i> Export CSV
                </a>
            </div>

        </form>
    </div>

    <!-- Stats Summaries Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase">Total Kunjungan</p>
            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalVisits }}</h3>
            <span class="text-[11px] text-slate-400">Periode terpilih</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase">Total Disetujui / Hadir</p>
            <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $totalApproved }}</h3>
            <span class="text-[11px] text-slate-400">Persentase: {{ $totalVisits > 0 ? round(($totalApproved / $totalVisits) * 100, 1) : 0 }}%</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase">Total Ditolak</p>
            <h3 class="text-2xl font-extrabold text-rose-600 mt-1">{{ $totalRejected }}</h3>
            <span class="text-[11px] text-slate-400">Permohonan ditolak</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase">Rata-rata Rating Kepuasan</p>
            <h3 class="text-2xl font-extrabold text-amber-500 mt-1">
                {{ $avgRating ? number_format($avgRating, 1) : '-' }} <span class="text-xs font-semibold text-slate-400">/ 5.0</span>
            </h3>
            <span class="text-[11px] text-slate-400">Dari ulasan pengunjung</span>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-200 flex items-center justify-between">
            <h4 class="font-bold text-slate-900 text-sm">Rekapitulasi Data Tamu Periode ({{ $startDate }} s/d {{ $endDate }})</h4>
            <span class="text-xs text-slate-500 font-mono">{{ $visits->count() }} Records</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4">No Tiket</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Nama Tamu & Instansi</th>
                        <th class="py-3 px-4">Keperluan</th>
                        <th class="py-3 px-4">Tujuan (Host/Dept)</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Rating</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($visits as $visit)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-orange-600">{{ $visit->ticket_code }}</td>
                            <td class="py-3 px-4 font-medium">{{ $visit->visit_date ? $visit->visit_date->format('d/m/Y') : '' }}</td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900">{{ $visit->guest_name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $visit->institution }}</div>
                            </td>
                            <td class="py-3 px-4 font-medium">{{ $visit->purpose }}</td>
                            <td class="py-3 px-4">
                                {{ $visit->host->name ?? ($visit->department->name ?? '-') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $visit->status_badge }}">
                                    {{ $visit->status_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center font-bold text-amber-500">
                                @if($visit->rating)
                                    <i class="fa-solid fa-star text-[10px]"></i> {{ $visit->rating }}/5
                                @else
                                    <span class="text-slate-300 font-normal">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">Tidak ada data rekapitulasi untuk filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
