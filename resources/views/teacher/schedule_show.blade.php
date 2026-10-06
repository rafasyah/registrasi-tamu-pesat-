@extends('layouts.teacher')

@section('title', 'Detail Jadwal - Guru')
@section('page_title', 'Detail Jadwal Pertemuan')
@section('page_subtitle', 'Lihat detail dan kunjungan tamu terkait jadwal ini.')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-slate-800">{{ $schedule->title }}</h3>
            <p class="text-xs text-slate-500 mt-1">
                <i class="fa-solid fa-ticket-simple mr-1"></i>
                Kode Jadwal: #{{ $schedule->id }}
            </p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="px-3 py-1.5 rounded-full text-xs font-bold border {{ $schedule->status_badge }}">
                {{ $schedule->status_label }}
            </span>
            <a href="{{ route('teacher.schedules.edit', $schedule) }}" class="px-3 py-1.5 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold transition-colors">
                <i class="fa-solid fa-pen mr-1"></i> Edit
            </a>
        </div>
    </div>

    <!-- Schedule Info Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="space-y-4">
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tanggal & Waktu</p>
                    <p class="text-sm font-bold text-slate-800 mt-1">
                        {{ $schedule->scheduled_date->format('d/m/Y') }}
                    </p>
                    <p class="text-sm text-slate-600">
                        {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                    </p>
                </div>

                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Lokasi</p>
                    <p class="text-sm text-slate-700 mt-1">{{ $schedule->location ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Departemen</p>
                    <p class="text-sm text-slate-700 mt-1">
                        @if($schedule->department)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-orange-50 text-orange-700 border border-orange-200">
                                {{ $schedule->department->name }}
                            </span>
                        @else
                            <span class="text-slate-400">Umum</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Deskripsi</p>
                    <p class="text-sm text-slate-700 mt-1">{{ $schedule->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>

                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Catatan</p>
                    <p class="text-sm text-slate-700 mt-1">{{ $schedule->notes ?? 'Tidak ada catatan.' }}</p>
                </div>

                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Guru / Host</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">{{ $schedule->host->name ?? '-' }}</p>
                    <p class="text-[11px] text-slate-500">{{ $schedule->host->position ?? '-' }}</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Guest Visits Connected -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">Kunjungan Tamu Terhubung ({{ $schedule->guestVisits->count() }})</h3>
            <button onclick="openAttachModal()" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold transition-colors">
                <i class="fa-solid fa-plus mr-1"></i> Hubungkan Tamu
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4">Nama Tamu & Instansi</th>
                        <th class="py-3 px-4">Keperluan</th>
                        <th class="py-3 px-4">Jadwal Kunjungan</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($schedule->guestVisits as $visit)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $visit->guest_name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $visit->institution }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-slate-700">{{ $visit->purpose }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-slate-700">{{ $visit->visit_date->format('d/m/Y') }}</div>
                                <div class="text-[11px] text-slate-500">Jam: {{ substr($visit->scheduled_time, 0, 5) }}</div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold border {{ $visit->status_badge }}">
                                    {{ $visit->status_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('ticket.show', $visit->ticket_code) }}" target="_blank"
                                    class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs transition-colors"
                                    title="Lihat Tiket">
                                    <i class="fa-solid fa-ticket-simple"></i>
                                </a>
                                <form action="{{ route('teacher.schedules.guest_visits.detach', [$schedule, $visit]) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Lepas tamu dari jadwal ini?')"
                                        class="p-1.5 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-700 rounded-lg text-xs transition-colors"
                                        title="Lepaskan Tamu">
                                        <i class="fa-solid fa-unlink"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                <i class="fa-solid fa-user-group-slash text-3xl mb-2 block text-slate-300"></i>
                                <p class="text-sm">Belum ada tamu yang terhubung dengan jadwal ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer Actions -->
    <div class="flex justify-between items-center pt-4">
        <a href="{{ route('teacher.schedules.index') }}" class="px-4 py-2 text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Jadwal
        </a>
        <form action="{{ route('teacher.schedules.destroy', $schedule) }}" method="POST" class="inline">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Hapus jadwal ini?')"
                class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-bold transition-colors">
                <i class="fa-solid fa-trash mr-1"></i> Hapus Jadwal
            </button>
        </form>
    </div>

</div>

<!-- Attach Guest Visit Modal -->
<div id="attach-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl">
        <div class="flex justify-between items-center pb-3 border-b border-slate-200">
            <h3 class="font-bold text-base text-slate-900">Hubungkan Tamu ke Jadwal</h3>
            <button onclick="closeAttachModal()" class="text-slate-400 hover:text-slate-600 text-lg"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="attach-form" method="POST" action="{{ route('teacher.schedules.guest_visits.attach', $schedule) }}" class="space-y-4 mt-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Cari Kunjungan Tamu
                </label>
                <input type="text" name="search" placeholder="Nama tamu, kode tiket, instansi..."
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <div class="max-h-80 overflow-y-auto border border-slate-200 rounded-xl">
                <table class="w-full text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-bold">
                        <tr>
                            <th class="py-2 px-3 text-left">Nama Tamu</th>
                            <th class="py-2 px-3 text-left">Tanggal</th>
                            <th class="py-2 px-3 text-center">Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\GuestVisit::where('host_id', $schedule->host_id)->whereNotIn('id', $schedule->guestVisits->pluck('id'))->get() as $visit)
                            <tr class="border-b border-slate-100">
                                <td class="py-2 px-3">{{ $visit->guest_name }}</td>
                                <td class="py-2 px-3">{{ $visit->visit_date->format('d/m/Y') }}</td>
                                <td class="py-2 px-3 text-center">
                                    <button type="submit" name="guest_visit_id" value="{{ $visit->id }}"
                                        class="px-2 py-1 bg-orange-600 hover:bg-orange-500 text-white rounded text-[10px] font-bold">
                                        Hubungkan
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

        <div class="pt-4 border-t border-slate-200 text-right">
            <button onclick="closeAttachModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openAttachModal() {
        document.getElementById('attach-modal').classList.remove('hidden');
    }
    function closeAttachModal() {
        document.getElementById('attach-modal').classList.add('hidden');
    }
</script>
@endpush
@endsection
