@extends('layouts.admin')

@section('title', 'Dashboard Petugas - Buku Tamu PESAT')
@section('page_title', 'Dashboard Monitoring Tamu')
@section('page_subtitle', 'Kelola pendaftaran, konfirmasi persetujuan, check-in & check-out secara real-time.')

@section('content')
<div class="space-y-6">

    <!-- Metrics Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Today -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Tamu Hari Ini</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalToday }}</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Semua status kunjungan</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Pending Approval -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Konfirmasi</p>
                <h3 class="text-2xl font-extrabold text-amber-600 mt-1">{{ $totalPending }}</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Perlu tindakan petugas</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xl">
                <i class="fa-solid fa-hourglass-half animate-pulse"></i>
            </div>
        </div>

        <!-- Currently Active -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sedang di Lokasi</p>
                <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $totalActive }}</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Sudah Check-In aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xl">
                <i class="fa-solid fa-person-walking-luggage"></i>
            </div>
        </div>

        <!-- Completed Today -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Selesai Hari Ini</p>
                <h3 class="text-2xl font-extrabold text-slate-700 mt-1">{{ $totalCompleted }}</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Sudah Check-Out</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-200 space-y-4">
        
        <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col lg:flex-row items-center justify-between gap-4">
            
            <!-- Filter Tabs -->
            <div class="flex flex-wrap items-center gap-1.5 w-full lg:w-auto">
                <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['status' => 'all'])) }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ ($statusFilter === 'all' || !$statusFilter) ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Status
                </a>
                <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['status' => 'pending'])) }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'pending' ? 'bg-amber-500 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Menunggu Konfirmasi ({{ $totalPending }})
                </a>
                <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['status' => 'approved'])) }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'approved' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Disetujui
                </a>
                <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['status' => 'checked_in'])) }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'checked_in' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Sedang Berkunjung ({{ $totalActive }})
                </a>
                <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['status' => 'checked_out'])) }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'checked_out' ? 'bg-slate-700 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Selesai
                </a>
                <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['status' => 'rejected'])) }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'rejected' ? 'bg-rose-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Ditolak
                </a>
            </div>

            <!-- Search & Date Range -->
            <div class="flex items-center space-x-2 w-full lg:w-auto">
                <input type="date" name="date" value="{{ $dateFilter }}" onchange="this.form.submit()"
                    class="py-1.5 px-3 bg-slate-50 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-orange-500">
                
                <div class="relative flex-1 lg:w-64">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, tiket, instansi..."
                        class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400 text-xs">
                        <i class="fa-solid fa-search"></i>
                    </span>
                </div>

                <button type="submit" class="px-3 py-1.5 bg-slate-800 text-white rounded-lg text-xs font-semibold hover:bg-slate-700 transition-colors">
                    Filter
                </button>
            </div>

        </form>
    </div>

    <!-- Visits Data Table -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">Kode Tiket</th>
                        <th class="py-3.5 px-4">Nama Tamu & Instansi</th>
                        <th class="py-3.5 px-4">Keperluan & Tujuan</th>
                        <th class="py-3.5 px-4">Waktu Kunjungan</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi & Kontrol</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($visits as $visit)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            
                            <!-- Ticket Code -->
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                <div class="flex items-center space-x-2">
                                    @if($visit->photo_path)
                                        <img src="{{ asset('storage/' . $visit->photo_path) }}" class="w-7 h-7 rounded-full object-cover border border-slate-300">
                                    @else
                                        <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-[10px] font-bold">
                                            {{ strtoupper(substr($visit->guest_name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="text-orange-600">{{ $visit->ticket_code }}</span>
                                </div>
                            </td>

                            <!-- Guest Name & Institution -->
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $visit->guest_name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $visit->institution }} &bull; <i class="fa-solid fa-phone text-[10px] text-slate-400"></i> {{ $visit->phone }}</div>
                            </td>

                            <!-- Purpose & Host/Dept -->
                            <td class="py-3.5 px-4">
                                <span class="font-medium text-slate-800 block">{{ $visit->purpose }}</span>
                                <span class="text-[11px] text-slate-500 block">
                                    Tujuan: <strong class="text-slate-700">{{ $visit->host->name ?? ($visit->department->name ?? '-') }}</strong>
                                </span>
                            </td>

                            <!-- Date & Time -->
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ $visit->visit_date ? $visit->visit_date->format('d/m/Y') : '-' }}</div>
                                <div class="text-[11px] text-slate-500">Jam: {{ substr($visit->scheduled_time, 0, 5) }} WIB</div>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $visit->status_badge }}">
                                    {{ $visit->status_label }}
                                </span>
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end space-x-1.5">
                                    
                                    <!-- Detail Modal Trigger -->
                                    <button onclick="openDetailModal({{ json_encode($visit) }})" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs transition-colors" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <!-- Print Badge -->
                                    <a href="{{ route('admin.visits.print_badge', $visit->id) }}" target="_blank" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs transition-colors" title="Cetak Pass ID Card">
                                        <i class="fa-solid fa-print"></i>
                                    </a>

                                    <!-- Status Workflows -->
                                    @if($visit->status === 'pending')
                                        <form action="{{ route('admin.visits.update_status', $visit->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="px-2.5 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-bold transition-colors">
                                                Setujui
                                            </button>
                                        </form>

                                        <button onclick="openRejectModal({{ $visit->id }}, '{{ $visit->ticket_code }}')" class="px-2.5 py-1 bg-rose-600 hover:bg-rose-500 text-white rounded-lg text-xs font-bold transition-colors">
                                            Tolak
                                        </button>
                                    @endif

                                    @if($visit->status === 'approved')
                                        <form action="{{ route('admin.visits.update_status', $visit->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="checked_in">
                                            <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-bold transition-colors">
                                                Check-In
                                            </button>
                                        </form>
                                    @endif

                                    @if($visit->status === 'checked_in')
                                        <form action="{{ route('admin.visits.update_status', $visit->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="checked_out">
                                            <button type="submit" class="px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-xs font-bold transition-colors">
                                                Check-Out
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-4xl mb-3 block text-slate-300"></i>
                                Tidak ada data kunjungan tamu yang sesuai kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-200">
            {{ $visits->links() }}
        </div>

    </div>

</div>

<!-- Rejection Modal -->
<div id="reject-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <h3 class="font-bold text-lg text-slate-900">Tolak Kunjungan Tamu</h3>
        <p class="text-xs text-slate-500" id="reject-ticket-text"></p>

        <form id="reject-form" method="POST" class="space-y-4">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="rejected">

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Alasan Penolakan <span class="text-rose-500">*</span>
                </label>
                <textarea name="rejection_reason" required rows="3" placeholder="Masukkan alasan penolakan..."
                    class="w-full p-3 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-bold shadow-md">
                    Konfirmasi Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Visit Detail Modal -->
<div id="detail-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center pb-3 border-b border-slate-200">
            <h3 class="font-bold text-base text-slate-900">Detail Kunjungan Tamu</h3>
            <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600 text-lg"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div id="detail-content" class="space-y-4 text-xs">
            <!-- Dynamic Content populated via JS -->
        </div>

        <div class="pt-4 border-t border-slate-200 text-right">
            <button onclick="closeDetailModal()" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-semibold">
                Tutup
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openRejectModal(id, ticketCode) {
        document.getElementById('reject-ticket-text').textContent = 'Tiket: ' + ticketCode;
        const form = document.getElementById('reject-form');
        form.action = '/admin/visits/' + id + '/status';
        document.getElementById('reject-modal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('reject-modal').classList.add('hidden');
    }

    function openDetailModal(visit) {
        const content = document.getElementById('detail-content');
        
        let photoHtml = '';
        if (visit.photo_path) {
            photoHtml = `<img src="/storage/${visit.photo_path}" class="w-full h-48 object-cover rounded-xl border border-slate-200 mb-3">`;
        }

        content.innerHTML = `
            ${photoHtml}
            <div class="grid grid-cols-2 gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
                <div><span class="text-slate-400 block">Kode Tiket:</span> <strong class="text-orange-600 text-sm font-mono">${visit.ticket_code}</strong></div>
                <div><span class="text-slate-400 block">Status:</span> <strong class="text-slate-800 uppercase">${visit.status}</strong></div>
                <div><span class="text-slate-400 block">Nama Tamu:</span> <strong class="text-slate-800">${visit.guest_name}</strong></div>
                <div><span class="text-slate-400 block">Instansi:</span> <span>${visit.institution}</span></div>
                <div><span class="text-slate-400 block">No Telepon:</span> <span>${visit.phone}</span></div>
                <div><span class="text-slate-400 block">Email:</span> <span>${visit.email || '-'}</span></div>
                <div><span class="text-slate-400 block">Keperluan:</span> <span>${visit.purpose}</span></div>
                <div><span class="text-slate-400 block">Jumlah Tamu:</span> <span>${visit.guest_count} Orang</span></div>
                <div><span class="text-slate-400 block">Guru/Staf:</span> <span>${visit.host ? visit.host.name : '-'}</span></div>
                <div><span class="text-slate-400 block">Departemen:</span> <span>${visit.department ? visit.department.name : '-'}</span></div>
                <div><span class="text-slate-400 block">Tanggal Kunjungan:</span> <span>${visit.visit_date}</span></div>
                <div><span class="text-slate-400 block">Plat Kendaraan:</span> <span>${visit.vehicle_number || '-'}</span></div>
            </div>
            ${visit.notes ? `<div class="p-3 bg-amber-50 rounded-xl text-amber-900"><strong>Catatan:</strong> ${visit.notes}</div>` : ''}
            ${visit.rating ? `<div class="p-3 bg-emerald-50 rounded-xl text-emerald-900"><strong>Rating:</strong> ${visit.rating}/5 &bull; <em>"${visit.feedback_comment || ''}"</em></div>` : ''}
        `;

        document.getElementById('detail-modal').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detail-modal').classList.add('hidden');
    }
</script>
@endpush
