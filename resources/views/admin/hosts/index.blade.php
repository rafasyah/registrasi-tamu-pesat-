@extends('layouts.admin')

@section('title', 'Kelola Guru & Staf - Buku Tamu PESAT')
@section('page_title', 'Kelola Data Guru & Staf (Hosts)')
@section('page_subtitle', 'Daftar personil sekolah yang dapat dijadikan tujuan bertamu oleh pengunjung.')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-900 text-lg">Daftar Guru & Staf Active</h3>
            <p class="text-xs text-slate-500">Total {{ $hosts->count() }} personil terdaftar</p>
        </div>

        <button onclick="openHostModal()" class="px-4 py-2.5 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-md flex items-center space-x-2 transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Guru / Staf Baru</span>
        </button>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">Nama Lengkap & NIP</th>
                        <th class="py-3.5 px-4">Jabatan / Role</th>
                        <th class="py-3.5 px-4">Departemen</th>
                        <th class="py-3.5 px-4">Kontak (WA & Email)</th>
                        <th class="py-3.5 px-4 text-center">Status Kehadiran</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($hosts as $host)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $host->name }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">NIP: {{ $host->nip_nik ?: '-' }}</div>
                            </td>

                            <td class="py-3.5 px-4 font-medium text-slate-800">
                                {{ $host->position }}
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md font-semibold text-[11px] border border-slate-200">
                                    {{ $host->department->name ?? '-' }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4">
                                <div><i class="fa-solid fa-phone text-slate-400 mr-1"></i> {{ $host->phone ?: '-' }}</div>
                                <div class="text-[11px] text-slate-400"><i class="fa-solid fa-envelope text-slate-400 mr-1"></i> {{ $host->email ?: '-' }}</div>
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $host->status_badge }}">
                                    {{ $host->status_label }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <button onclick="editHostModal({{ json_encode($host) }})" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs transition-colors" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <form action="{{ route('admin.hosts.destroy', $host->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus guru/staf ini?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">Belum ada data guru/staf.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Host Form Modal -->
<div id="host-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4">
        <div class="flex justify-between items-center pb-3 border-b border-slate-200">
            <h3 class="font-bold text-base text-slate-900" id="modal-title">Tambah Guru / Staf Baru</h3>
            <button onclick="closeHostModal()" class="text-slate-400 hover:text-slate-600 text-lg"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="host-form" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="host_name" required placeholder="Contoh: Drs. Ahmad Fauzi, M.Pd"
                    class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">NIP / NIK (Opsional)</label>
                    <input type="text" name="nip_nik" id="host_nip_nik" placeholder="197508122001"
                        class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Departemen <span class="text-rose-500">*</span></label>
                    <select name="department_id" id="host_department_id" required class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Jabatan / Role <span class="text-rose-500">*</span></label>
                <input type="text" name="position" id="host_position" required placeholder="Contoh: Wakasek Bid. Kurikulum"
                    class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">No Telepon / WA</label>
                    <input type="text" name="phone" id="host_phone" placeholder="081234567890"
                        class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" id="host_email" placeholder="guru@pesat.sch.id"
                        class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Status Kehadiran <span class="text-rose-500">*</span></label>
                <select name="status" id="host_status" required class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="available">Ada di Tempat</option>
                    <option value="busy">Sedang Sibuk</option>
                    <option value="away">Dinas Luar</option>
                    <option value="leave">Cuti / Izin</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeHostModal()" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-xl text-xs font-bold shadow-md">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openHostModal() {
        document.getElementById('modal-title').textContent = 'Tambah Guru / Staf Baru';
        document.getElementById('form-method').value = 'POST';
        const form = document.getElementById('host-form');
        form.action = "{{ route('admin.hosts.store') }}";
        form.reset();
        document.getElementById('host-modal').classList.remove('hidden');
    }

    function editHostModal(host) {
        document.getElementById('modal-title').textContent = 'Edit Guru / Staf';
        document.getElementById('form-method').value = 'PUT';
        const form = document.getElementById('host-form');
        form.action = '/admin/hosts/' + host.id;

        document.getElementById('host_name').value = host.name;
        document.getElementById('host_nip_nik').value = host.nip_nik || '';
        document.getElementById('host_department_id').value = host.department_id;
        document.getElementById('host_position').value = host.position;
        document.getElementById('host_phone').value = host.phone || '';
        document.getElementById('host_email').value = host.email || '';
        document.getElementById('host_status').value = host.status;

        document.getElementById('host-modal').classList.remove('hidden');
    }

    function closeHostModal() {
        document.getElementById('host-modal').classList.add('hidden');
    }
</script>
@endpush
