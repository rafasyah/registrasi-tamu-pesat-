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

    @unless(request()->routeIs('teacher.schedules.index'))
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
    @endunless

    <!-- Validasi Ajuan Jadwal Kunjungan Orang Tua / Tamu -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-user-check text-orange-600"></i>
                    <span>Ajuan Jadwal Kunjungan Orang Tua & Tamu</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">Validasi, setujui, ubah jam/tanggal, atau tolak ajuan jadwal kunjungan yang ditujukan ke Anda.</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800">
                {{ isset($parentVisits) ? $parentVisits->count() : 0 }} Ajuan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">No Tiket & Tamu</th>
                        <th class="py-3.5 px-4">Keperluan / Kategori</th>
                        <th class="py-3.5 px-4">Ajuan Tanggal & Jam</th>
                        <th class="py-3.5 px-4">Janji Temu</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Validasi Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($parentVisits as $pVisit)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                    <i class="fa-solid fa-ticket text-orange-500 text-xs"></i>
                                    {{ $pVisit->ticket_code }}
                                </div>
                                <div class="font-medium text-slate-800 mt-0.5">{{ $pVisit->guest_name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $pVisit->institution ?: 'Wali Murid / Orang Tua' }} &bull; {{ $pVisit->phone }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-semibold text-slate-800 block">{{ $pVisit->purpose }}</span>
                                @if($pVisit->notes)
                                    <span class="text-[11px] text-slate-500 block truncate max-w-xs" title="{{ $pVisit->notes }}">Catatan: {{ $pVisit->notes }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">
                                    <i class="fa-regular fa-calendar mr-1 text-slate-400"></i>
                                    {{ $pVisit->visit_date ? $pVisit->visit_date->format('d/m/Y') : '-' }}
                                </div>
                                <div class="text-[11px] text-slate-500 mt-0.5">
                                    <i class="fa-regular fa-clock mr-1 text-slate-400"></i>
                                    Pukul: {{ substr($pVisit->scheduled_time, 0, 5) }} WIB
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($pVisit->has_appointment)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-check mr-1 text-[9px]"></i> Sudah Buat Janji
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-800">
                                        Belum Ada Janji
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $pVisit->status_badge }}">
                                    {{ $pVisit->status_label }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end space-x-1.5">
                                    @if($pVisit->status === 'pending')
                                        <!-- Terima Langsung -->
                                        <button type="button" onclick="openConfirmApproveModal({{ $pVisit->id }}, '{{ $pVisit->ticket_code }}', '{{ addslashes($pVisit->guest_name) }}', '{{ $pVisit->visit_date ? $pVisit->visit_date->format('Y-m-d') : '' }}', '{{ substr($pVisit->scheduled_time, 0, 5) }}')" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-bold transition-colors shadow-xs" title="Setujui Sesuai Jadwal Ajuan">
                                            <i class="fa-solid fa-check mr-1"></i> Terima
                                        </button>

                                        <!-- Ubah Jam/Tanggal (Reschedule) -->
                                        <button
                                            type="button"
                                            onclick="openValidateScheduleModal({{ json_encode($pVisit) }})"
                                            class="px-2.5 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-bold transition-colors shadow-xs"
                                            title="Ubah Tanggal/Jam & Validasi"
                                        >
                                            <i class="fa-solid fa-calendar-pen mr-1"></i> Sesuaikan
                                        </button>

                                        <!-- Tolak Ajuan -->
                                        <button
                                            type="button"
                                            onclick="openTeacherRejectModal({{ $pVisit->id }}, '{{ $pVisit->ticket_code }}', '{{ addslashes($pVisit->guest_name) }}')"
                                            class="px-2 py-1 bg-rose-600 hover:bg-rose-500 text-white rounded-lg text-xs font-bold transition-colors"
                                            title="Tolak Ajuan"
                                        >
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    @else
                                        <!-- Edit/Ubah Kembali Jadwal -->
                                        <button
                                            type="button"
                                            onclick="openValidateScheduleModal({{ json_encode($pVisit) }})"
                                            class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition-colors"
                                            title="Ubah Jadwal Kunjungan"
                                        >
                                            <i class="fa-solid fa-clock-rotate-left mr-1"></i> Ubah Jam
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                <i class="fa-solid fa-inbox text-3xl mb-2 block text-slate-300"></i>
                                <p class="text-xs">Belum ada ajuan kunjungan dari orang tua atau tamu yang ditujukan ke Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Validasi / Sesuaikan Jam & Tanggal Kunjungan -->
<div id="validate-schedule-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-lg">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <h3 class="font-bold text-base text-slate-900">Validasi / Sesuaikan Jadwal</h3>
                <p class="text-xs text-slate-500" id="val-guest-name"></p>
            </div>
        </div>

        <form id="validate-schedule-form" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="action" value="reschedule">

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Tanggal Kunjungan Disepakati <span class="text-rose-500">*</span>
                </label>
                <input type="date" name="visit_date" id="val-visit-date" required
                    class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Jam Pertemuan Disepakati <span class="text-rose-500">*</span>
                </label>
                <input type="time" name="scheduled_time" id="val-scheduled-time" required
                    class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none">
                <p class="text-[11px] text-slate-400 mt-1">Tentukan jam luang Anda untuk menerima orang tua siswa.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Catatan Konfirmasi dari Guru (Opsional)
                </label>
                <textarea name="notes" rows="2" placeholder="Contoh: Bertemu di ruang BK / Guru setelah jam istirahat..."
                    class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-orange-500 focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeValidateScheduleModal()" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold transition-colors">
                    Simpan & Setujui Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Terima Ajuan -->
<div id="teacher-confirm-approve-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div>
                <h3 class="font-bold text-base text-slate-900">Konfirmasi Persetujuan</h3>
                <p class="text-xs text-slate-500" id="confirm-approve-guest-name"></p>
            </div>
        </div>

        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 text-xs space-y-2">
            <p class="text-slate-700">Apakah Anda yakin dapat menerima kunjungan ini sesuai jadwal yang diajukan?</p>
            <div class="pt-2 border-t border-slate-200 flex flex-col gap-1">
                <div class="flex justify-between">
                    <span class="text-slate-500">Tanggal:</span>
                    <span class="font-semibold text-slate-800" id="confirm-approve-date"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Jam:</span>
                    <span class="font-semibold text-slate-800" id="confirm-approve-time"></span>
                </div>
            </div>
        </div>

        <form id="teacher-confirm-approve-form" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="action" value="approve">

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Catatan Konfirmasi dari Guru (Opsional)
                </label>
                <textarea name="notes" rows="2" placeholder="Contoh: Bertemu di ruang guru, pastikan membawa berkas..."
                    class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeConfirmApproveModal()" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold transition-colors">
                    Ya, Saya Dapat Menerima
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tolak Ajuan Orang Tua -->
<div id="teacher-reject-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <h3 class="font-bold text-lg text-slate-900">Tolak Ajuan Kunjungan</h3>
        <p class="text-xs text-slate-500" id="teacher-reject-guest-name"></p>

        <form id="teacher-reject-form" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="action" value="reject">

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Alasan Penolakan <span class="text-rose-500">*</span>
                </label>
                <textarea name="rejection_reason" required rows="3" placeholder="Masukkan alasan penolakan atau halangan..."
                    class="w-full p-3 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
            </div>

            <div class="flex justify-end space-x-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeTeacherRejectModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-bold shadow-md">
                    Konfirmasi Tolak
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openValidateScheduleModal(visit) {
        document.getElementById('val-guest-name').textContent = visit.ticket_code + ' • ' + visit.guest_name;
        document.getElementById('validate-schedule-form').action = '/teacher/guest-visits/' + visit.id + '/validate';
        
        if (visit.visit_date) {
            const d = visit.visit_date.substring(0, 10);
            document.getElementById('val-visit-date').value = d;
        }
        if (visit.scheduled_time) {
            document.getElementById('val-scheduled-time').value = visit.scheduled_time.substring(0, 5);
        }

        document.getElementById('validate-schedule-modal').classList.remove('hidden');
    }

    function closeValidateScheduleModal() {
        document.getElementById('validate-schedule-modal').classList.add('hidden');
    }

    function openTeacherRejectModal(id, ticketCode, guestName) {
        document.getElementById('teacher-reject-guest-name').textContent = ticketCode + ' • ' + guestName;
        document.getElementById('teacher-reject-form').action = '/teacher/guest-visits/' + id + '/validate';
        document.getElementById('teacher-reject-modal').classList.remove('hidden');
    }

    function closeTeacherRejectModal() {
        document.getElementById('teacher-reject-modal').classList.add('hidden');
    }

    function openConfirmApproveModal(id, ticketCode, guestName, visitDate, scheduledTime) {
        document.getElementById('confirm-approve-guest-name').textContent = ticketCode + ' • ' + guestName;
        document.getElementById('confirm-approve-date').textContent = visitDate ? (visitDate.split('-').reverse().join('/')) : '-';
        document.getElementById('confirm-approve-time').textContent = scheduledTime ? (scheduledTime + ' WIB') : '-';
        document.getElementById('teacher-confirm-approve-form').action = '/teacher/guest-visits/' + id + '/validate';
        document.getElementById('teacher-confirm-approve-modal').classList.remove('hidden');
    }

    function closeConfirmApproveModal() {
        document.getElementById('teacher-confirm-approve-modal').classList.add('hidden');
    }
</script>
@endpush
@endsection
