@extends('layouts.admin')

@section('title', 'Kelola Departemen - Buku Tamu PESAT')
@section('page_title', 'Kelola Departemen & Divisi')
@section('page_subtitle', 'Struktur organisasi dan bagian dalam lingkungan SMK PESAT.')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-900 text-lg">Daftar Departemen</h3>
            <p class="text-xs text-slate-500">Total {{ $departments->count() }} departemen terdaftar</p>
        </div>

        <button onclick="openDeptModal()" class="px-4 py-2.5 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-md flex items-center space-x-2 transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Departemen Baru</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($departments as $dept)
            <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-200 space-y-4 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 bg-orange-100 text-orange-700 font-mono font-bold rounded-lg text-xs border border-orange-200">
                            {{ $dept->code }}
                        </span>
                        <div class="flex items-center space-x-1">
                            <button onclick="editDeptModal({{ json_encode($dept) }})" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg text-xs">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus departemen ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-400 hover:text-rose-600 rounded-lg text-xs">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <h4 class="font-bold text-base text-slate-900 mt-3">{{ $dept->name }}</h4>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $dept->description ?: 'Tidak ada deskripsi.' }}</p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div><i class="fa-solid fa-user-tie text-slate-400 mr-1"></i> <strong>{{ $dept->hosts_count }}</strong> Staf</div>
                    <div><i class="fa-solid fa-address-book text-slate-400 mr-1"></i> <strong>{{ $dept->guest_visits_count }}</strong> Kunjungan</div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<!-- Dept Modal -->
<div id="dept-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <div class="flex justify-between items-center pb-3 border-b border-slate-200">
            <h3 class="font-bold text-base text-slate-900" id="modal-title">Tambah Departemen Baru</h3>
            <button onclick="closeDeptModal()" class="text-slate-400 hover:text-slate-600 text-lg"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="dept-form" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Departemen <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="dept_name" required placeholder="Contoh: Bidang Kurikulum"
                    class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kode Singkatan <span class="text-rose-500">*</span></label>
                <input type="text" name="code" id="dept_code" required placeholder="Contoh: KUR"
                    class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono uppercase focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi / Keterangan</label>
                <textarea name="description" id="dept_description" rows="3" placeholder="Penjelasan tugas departemen..."
                    class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
            </div>

            <div class="flex justify-end space-x-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeDeptModal()" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-xl text-xs font-bold shadow-md">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openDeptModal() {
        document.getElementById('modal-title').textContent = 'Tambah Departemen Baru';
        document.getElementById('form-method').value = 'POST';
        const form = document.getElementById('dept-form');
        form.action = "{{ route('admin.departments.store') }}";
        form.reset();
        document.getElementById('dept-modal').classList.remove('hidden');
    }

    function editDeptModal(dept) {
        document.getElementById('modal-title').textContent = 'Edit Departemen';
        document.getElementById('form-method').value = 'PUT';
        const form = document.getElementById('dept-form');
        form.action = '/admin/departments/' + dept.id;

        document.getElementById('dept_name').value = dept.name;
        document.getElementById('dept_code').value = dept.code;
        document.getElementById('dept_description').value = dept.description || '';

        document.getElementById('dept-modal').classList.remove('hidden');
    }

    function closeDeptModal() {
        document.getElementById('dept-modal').classList.add('hidden');
    }
</script>
@endpush
