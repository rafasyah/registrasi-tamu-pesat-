@extends('layouts.app')

@section('title', 'Registrasi Tamu Baru - Buku Tamu Digital SMK PESAT')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Hero Header Banner -->
    <div class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-amber-950/70 rounded-3xl p-6 sm:p-10 text-white mb-8 shadow-xl border border-slate-800/80 overflow-hidden">
        <!-- Background decorative ambient circles -->
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/4 -bottom-24 w-72 h-72 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-orange-500/15 text-orange-300 border border-orange-500/30 px-3.5 py-1.5 rounded-full text-xs font-semibold tracking-wide mb-4 backdrop-blur-xs">
                <i class="fa-solid fa-school-flag text-orange-400"></i>
                <span>Buku Tamu Digital &bull; SMK PESAT Kota Bogor</span>
            </div>
            
            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
                Formulir Pendaftaran Kunjungan Tamu
            </h1>
            
            <p class="mt-3 text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl">
                Selamat datang! Silakan lengkapi formulir di bawah ini untuk mendaftarkan kunjungan Anda. Sistem akan langsung menerbitkan <strong class="text-white">Kode Tiket Digital (QR Pass)</strong> untuk ditunjukkan kepada petugas di lokasi.
            </p>

            <!-- Key Features / Highlights -->
            <div class="mt-6 flex flex-wrap items-center gap-3 pt-4 border-t border-slate-800/80 text-xs text-slate-300">
                <div class="flex items-center gap-2 bg-slate-900/60 backdrop-blur-xs px-3 py-1.5 rounded-lg border border-slate-800">
                    <i class="fa-solid fa-bolt text-amber-400"></i>
                    <span>Proses Cepat & Praktis</span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900/60 backdrop-blur-xs px-3 py-1.5 rounded-lg border border-slate-800">
                    <i class="fa-solid fa-qrcode text-orange-400"></i>
                    <span>Tiket QR Pass Digital</span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900/60 backdrop-blur-xs px-3 py-1.5 rounded-lg border border-slate-800">
                    <i class="fa-solid fa-shield-halved text-emerald-400"></i>
                    <span>Sistem Keamanan Terintegrasi</span>
                </div>
            </div>
        </div>

        <!-- Decorative background icon -->
        <div class="absolute -right-8 -bottom-8 opacity-5 pointer-events-none text-white text-[200px]">
            <i class="fa-solid fa-address-book"></i>
        </div>
    </div>

    <!-- Main Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Form Column -->
        <div class="lg:col-span-8 space-y-6">
            <form id="guestRegistrationForm" action="{{ route('guest.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- ============================================== -->
                <!-- SECTION 1: IDENTITAS & KONTAK TAMU -->
                <!-- ============================================== -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/90 overflow-hidden">
                    <div class="bg-gradient-to-r from-slate-50 to-orange-50/40 px-6 sm:px-8 py-5 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-2xl bg-orange-600 text-white font-extrabold text-sm flex items-center justify-center shadow-md shadow-orange-500/20">
                                1
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-900 tracking-tight">Identitas & Kontak Tamu</h2>
                                <p class="text-xs text-slate-500">Data pribadi tamu atau perwakilan rombongan yang berkunjung</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-semibold text-rose-500 bg-rose-50 border border-rose-200 px-2.5 py-1 rounded-full">
                            * Wajib Diisi
                        </span>
                    </div>

                    <div class="p-6 sm:p-8 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            
                            <!-- Nama Lengkap Tamu -->
                            <div class="sm:col-span-2">
                                <label for="guest_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Nama Lengkap Tamu <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-user text-sm"></i>
                                    </span>
                                    <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name') }}" required
                                        placeholder="Contoh: Budi Santoso, S.Kom."
                                        class="w-full pl-10 pr-4 py-3 bg-slate-50/70 hover:bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all">
                                </div>
                                @error('guest_name') <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>


                            <!-- No Telepon / WA -->
                            <div>
                                <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Nomor WhatsApp / HP <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-phone text-sm"></i>
                                    </span>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                        placeholder="Contoh: 081234567890"
                                        class="w-full pl-10 pr-4 py-3 bg-slate-50/70 hover:bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all">
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1.5">Untuk verifikasi dan pencarian status tiket kunjungan.</p>
                                @error('phone') <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>

                            <!-- Email Tamu -->
                            <div>
                                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Alamat Email
                                    <span class="text-slate-400 font-normal normal-case">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-envelope text-sm"></i>
                                    </span>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        placeholder="nama@email.com"
                                        class="w-full pl-10 pr-4 py-3 bg-slate-50/70 hover:bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all">
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1.5">Menerima salinan konfirmasi kunjungan secara online.</p>
                                @error('email') <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ============================================== -->
                <!-- SECTION 2: TUJUAN & RINCIAN KUNJUNGAN -->
                <!-- ============================================== -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/90 overflow-hidden">
                    <div class="bg-gradient-to-r from-slate-50 to-orange-50/40 px-6 sm:px-8 py-5 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-2xl bg-orange-600 text-white font-extrabold text-sm flex items-center justify-center shadow-md shadow-orange-500/20">
                                2
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-900 tracking-tight">Tujuan & Staf yang Ditemui</h2>
                                <p class="text-xs text-slate-500">Pilih unit kerja dan guru atau staf yang ingin Anda temui</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            
                            <!-- Departemen / Divisi Tujuan -->
                            <div>
                                <label for="department_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Departemen / Divisi Tujuan <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-sitemap text-sm"></i>
                                    </span>
                                    <select name="department_id" id="department_id" required
                                        class="w-full pl-10 pr-10 py-3 bg-slate-50/70 hover:bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl text-sm font-medium text-slate-900 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all appearance-none cursor-pointer">
                                        <option value="" disabled {{ old('department_id') ? '' : 'selected' }}>-- Pilih Departemen / Divisi --</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->name }} ({{ $dept->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </span>
                                </div>
                                @error('department_id') <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>

                            <!-- Guru yang Dituju (Akun Guru) -->
                            <div>
                                <label for="host_name_input" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Guru yang Dituju (Akun Guru)
                                    <span class="text-slate-400 font-normal normal-case">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-chalkboard-user text-sm"></i>
                                    </span>
                                    <input type="text" name="host_name" id="host_name_input" 
                                        class="w-full pl-10 pr-10 py-3 bg-slate-50/70 hover:bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all"
                                        placeholder="Cari nama guru atau email akun guru..." 
                                        autocomplete="off">
                                    <button type="button" id="host_clear_btn" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-rose-500 hidden" title="Hapus pilihan guru">
                                        <i class="fa-solid fa-circle-xmark text-sm"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="host_id" id="host_hidden" value="{{ old('host_id') }}">
                                <p class="text-[11px] text-slate-400 mt-1.5">Pilih akun guru yang ingin ditemui atau kosongkan jika kunjungan umum.</p>
                                @error('host_id') <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>

                            <!-- Status Perjanjian / Janji Temu -->
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2.5">
                                    Apakah Sudah Membuat Janji Temu Sebelumnya? <span class="text-rose-500">*</span>
                                </label>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                    <!-- Option 1: Sudah ada janji -->
                                    <label class="appointment-option group relative flex items-start gap-3.5 p-4 rounded-2xl border-2 transition-all cursor-pointer {{ old('has_appointment') === '1' ? 'border-orange-500 bg-orange-50/40 shadow-xs' : 'border-slate-200/90 bg-slate-50/50 hover:bg-white hover:border-slate-300' }}">
                                        <input type="radio" name="has_appointment" value="1" required
                                            {{ old('has_appointment') === '1' ? 'checked' : '' }}
                                            class="sr-only">
                                        <div class="radio-indicator w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 mt-0.5 transition-colors {{ old('has_appointment') === '1' ? 'border-orange-500 bg-orange-500 text-white' : 'border-slate-300 group-hover:border-slate-400' }}">
                                            <i class="fa-solid fa-check text-[10px] {{ old('has_appointment') === '1' ? 'block' : 'hidden' }}"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-bold text-slate-900 group-hover:text-orange-600 transition-colors">
                                                    Sudah Ada Janji Temu
                                                </span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                                                    Terjadwal
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                                Telah menghubungi atau memiliki janji khusus dengan pihak guru/staf terkait.
                                            </p>
                                        </div>
                                    </label>

                                    <!-- Option 2: Belum ada janji -->
                                    <label class="appointment-option group relative flex items-start gap-3.5 p-4 rounded-2xl border-2 transition-all cursor-pointer {{ old('has_appointment') === '0' ? 'border-orange-500 bg-orange-50/40 shadow-xs' : 'border-slate-200/90 bg-slate-50/50 hover:bg-white hover:border-slate-300' }}">
                                        <input type="radio" name="has_appointment" value="0" required
                                            {{ old('has_appointment') === '0' ? 'checked' : '' }}
                                            class="sr-only">
                                        <div class="radio-indicator w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 mt-0.5 transition-colors {{ old('has_appointment') === '0' ? 'border-orange-500 bg-orange-500 text-white' : 'border-slate-300 group-hover:border-slate-400' }}">
                                            <i class="fa-solid fa-check text-[10px] {{ old('has_appointment') === '0' ? 'block' : 'hidden' }}"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-bold text-slate-900 group-hover:text-orange-600 transition-colors">
                                                    Belum Membuat Janji
                                                </span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-800">
                                                    Langsung
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                                Kunjungan langsung, ketersediaan staf akan dikonfirmasi saat Anda tiba di lobi.
                                            </p>
                                        </div>
                                    </label>
                                </div>
                                @error('has_appointment') <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>

                            <!-- Maksud & Keperluan Kunjungan -->
                            <div class="sm:col-span-2">
                                <label for="purpose" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Maksud / Keperluan Kunjungan <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-clipboard-question text-sm"></i>
                                    </span>
                                    <input type="text" name="purpose" id="purpose" value="{{ old('purpose') }}" required
                                        placeholder="Contoh: Kunjungan Dinas / Konsultasi Perkembangan Siswa / Pengantaran Dokumen"
                                        class="w-full pl-10 pr-4 py-3 bg-slate-50/70 hover:bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all">
                                </div>

                                <!-- Quick Chips for Common Purposes -->
                                <div class="mt-2.5 flex flex-wrap items-center gap-1.5">
                                    <span class="text-[11px] text-slate-400 mr-1">Pilihan Cepat:</span>
                                    @php
                                        $quickPurposes = [
                                            'Kunjungan Dinas',
                                            'Konsultasi Siswa',
                                            'Pengantaran Dokumen / Paket',
                                            'Pertemuan Kerjasama / Industri',
                                            'Silaturahmi / Alumni'
                                        ];
                                    @endphp
                                    @foreach($quickPurposes as $quick)
                                        <button type="button" onclick="setQuickPurpose('{{ $quick }}')"
                                            class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-orange-100 hover:text-orange-700 text-slate-600 font-medium transition-colors border border-slate-200/60">
                                            + {{ $quick }}
                                        </button>
                                    @endforeach
                                </div>
                                @error('purpose') <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ============================================== -->
                <!-- SECTION 3: WAKTU KEDATANGAN & ROMBONGAN -->
                <!-- ============================================== -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/90 overflow-hidden">
                    <div class="bg-gradient-to-r from-slate-50 to-orange-50/40 px-6 sm:px-8 py-5 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-2xl bg-orange-600 text-white font-extrabold text-sm flex items-center justify-center shadow-md shadow-orange-500/20">
                                3
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-900 tracking-tight">Waktu & Logistik Kunjungan</h2>
                                <p class="text-xs text-slate-500">Estimasi waktu tiba, jumlah tamu, dan kendaraan yang digunakan</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            
                            <!-- Tanggal Kunjungan -->
                            <div>
                                <label for="visit_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Tanggal Kunjungan <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-calendar-days text-sm"></i>
                                    </span>
                                    <input type="date" name="visit_date" id="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" required
                                        class="w-full pl-10 pr-3 py-3 bg-slate-50/70 hover:bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl text-sm font-medium text-slate-900 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all">
                                </div>
                                @error('visit_date') <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>

                            <!-- Jam Kedatangan -->
                            <div>
                                <label for="scheduled_time" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Perkiraan Jam Tiba <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-clock text-sm"></i>
                                    </span>
                                    <input type="time" name="scheduled_time" id="scheduled_time" value="{{ old('scheduled_time', date('H:i')) }}" required
                                        class="w-full pl-10 pr-3 py-3 bg-slate-50/70 hover:bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl text-sm font-medium text-slate-900 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all">
                                </div>
                                @error('scheduled_time') <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>

                            <!-- Jumlah Tamu -->
                            <div>
                                <label for="guest_count" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Jumlah Tamu <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative flex items-center">
                                    <button type="button" onclick="adjustGuestCount(-1)" class="w-11 h-11 rounded-l-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold border border-r-0 border-slate-200 flex items-center justify-center transition-colors shrink-0">
                                        <i class="fa-solid fa-minus text-xs"></i>
                                    </button>
                                    <input type="number" name="guest_count" id="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="100" required
                                        class="w-full py-3 bg-slate-50/70 border border-slate-200 focus:border-orange-500 focus:bg-white text-center text-sm font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all">
                                    <button type="button" onclick="adjustGuestCount(1)" class="w-11 h-11 rounded-r-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold border border-l-0 border-slate-200 flex items-center justify-center transition-colors shrink-0">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                    </button>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1.5">Minimal 1 orang.</p>
                                @error('guest_count') <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                            </div>

                            <!-- Catatan / Rincian Tambahan -->
                            <div class="sm:col-span-3">
                                <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Catatan / Pesan Tambahan
                                    <span class="text-slate-400 font-normal normal-case">(Opsional)</span>
                                </label>
                                <textarea name="notes" id="notes" rows="3"
                                    placeholder="Tuliskan keterangan detail lainnya mengenai kunjungan Anda, ruang yang dibutuhkan, atau hal penting lainnya..."
                                    class="w-full p-4 bg-slate-50/70 hover:bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl text-sm font-medium text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all">{{ old('notes') }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>



                <!-- ============================================== -->
                <!-- SUBMIT ACTION BAR -->
                <!-- ============================================== -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/90 space-y-4">
                    <div class="flex items-start gap-3 text-xs text-slate-500">
                        <i class="fa-solid fa-shield-halved text-orange-500 text-base shrink-0 mt-0.5"></i>
                        <p class="leading-relaxed">
                            Dengan menekan tombol di bawah, Anda menyatakan bahwa data kunjungan yang diisi adalah benar dan menyetujui seluruh tata tertib tamu yang berlaku di lingkungan SMK PESAT Kota Bogor.
                        </p>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center gap-3">
                        <button type="submit" id="submitBtn" class="w-full sm:flex-1 py-4 bg-gradient-to-r from-orange-600 via-orange-500 to-amber-600 hover:from-orange-500 hover:to-amber-500 text-white font-extrabold text-sm sm:text-base rounded-2xl shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 active:scale-[0.99] transition-all flex items-center justify-center gap-2.5 cursor-pointer">
                            <i class="fa-solid fa-paper-plane text-base"></i>
                            <span id="submitBtnText">Kirim Pendaftaran & Terbitkan Tiket</span>
                        </button>
                        
                        <button type="reset" onclick="resetEntireForm()" class="w-full sm:w-auto px-5 py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-2xl transition-colors cursor-pointer">
                            Reset Form
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <!-- Right: Info & Status Sidebar -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Card 1: Live Status Kunjungan Terkini -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/90">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-clipboard-list text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm leading-tight">Status Tiket Terkini</h3>
                            <p class="text-[11px] text-slate-400">Aktivitas kunjungan di sekolah</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Live
                    </span>
                </div>

                @if(isset($recentVisits) && $recentVisits->count() > 0)
                    <div class="divide-y divide-slate-100 space-y-3.5">
                        @foreach($recentVisits as $visit)
                            <div class="pt-3.5 first:pt-0">
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <span class="font-mono text-xs font-bold text-slate-900 tracking-tight flex items-center gap-1.5">
                                        <i class="fa-solid fa-ticket text-orange-500 text-[11px]"></i>
                                        {{ $visit->ticket_code }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold border {{ $visit->status_badge }}">
                                        {{ $visit->status_label }}
                                    </span>
                                </div>

                                <div class="text-xs text-slate-800 font-semibold truncate mb-1">
                                    <i class="fa-solid fa-user text-slate-400 mr-1 text-[10px]"></i>
                                    {{ $visit->guest_name }}
                                    @if($visit->institution)
                                        <span class="text-slate-400 font-normal">({{ $visit->institution }})</span>
                                    @endif
                                </div>

                                <div class="bg-slate-50/80 rounded-xl p-2.5 text-[11px] text-slate-600 space-y-1 border border-slate-100">
                                    <div class="flex items-start justify-between gap-2">
                                        <span class="text-slate-400 whitespace-nowrap">Guru Penerima:</span>
                                        <span class="font-semibold text-right text-slate-800">
                                            @if($visit->receivedByHost)
                                                <span class="text-emerald-700 font-bold flex items-center justify-end gap-1">
                                                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                                                    {{ $visit->receivedByHost->name }}
                                                </span>
                                            @elseif($visit->host)
                                                <span>{{ $visit->host->name }}</span>
                                            @else
                                                <span class="text-slate-400 italic">Frontdesk / Resepsionis</span>
                                            @endif
                                        </span>
                                    </div>
                                    @if($visit->department)
                                        <div class="flex items-center justify-between text-[10px] text-slate-400 pt-0.5">
                                            <span>Tujuan:</span>
                                            <span class="text-slate-600 font-medium">{{ $visit->department->name }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-slate-400">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-400 text-lg">
                            <i class="fa-regular fa-folder-open"></i>
                        </div>
                        <p class="text-xs font-medium">Belum ada aktivitas kunjungan terbaru.</p>
                    </div>
                @endif
            </div>

            <!-- Card 2: Panduan Alur Kunjungan -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/90 space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-route text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-sm">Panduan Alur Bertamu</h3>
                        <p class="text-[11px] text-slate-400">Tata tertib kunjungan di SMK PESAT</p>
                    </div>
                </div>

                <div class="space-y-4 relative pl-6 before:content-[''] before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    <!-- Step 1 -->
                    <div class="relative text-xs">
                        <div class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-orange-600 text-white font-bold flex items-center justify-center text-[10px] ring-4 ring-white">
                            1
                        </div>
                        <h4 class="font-bold text-slate-800">Isi Formulir Online</h4>
                        <p class="text-slate-500 mt-0.5 text-[11px] leading-relaxed">
                            Lengkapi data diri dan tujuan Anda pada formulir di halaman ini.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative text-xs">
                        <div class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-orange-600 text-white font-bold flex items-center justify-center text-[10px] ring-4 ring-white">
                            2
                        </div>
                        <h4 class="font-bold text-slate-800">Dapatkan Tiket QR Digital</h4>
                        <p class="text-slate-500 mt-0.5 text-[11px] leading-relaxed">
                            Simpan kode tiket atau unduh kartu tamu digital di layar Anda.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative text-xs">
                        <div class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-orange-600 text-white font-bold flex items-center justify-center text-[10px] ring-4 ring-white">
                            3
                        </div>
                        <h4 class="font-bold text-slate-800">Check-In di Pos / Lobi</h4>
                        <p class="text-slate-500 mt-0.5 text-[11px] leading-relaxed">
                            Tunjukkan tiket kepada petugas keamanan untuk mendapatkan kartu fisik visitor.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative text-xs">
                        <div class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] ring-4 ring-white">
                            4
                        </div>
                        <h4 class="font-bold text-slate-800">Selesai & Check-Out</h4>
                        <p class="text-slate-500 mt-0.5 text-[11px] leading-relaxed">
                            Lakukan check-out via ponsel atau di meja resepsionis sebelum meninggalkan sekolah.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Jam Operasional & Layanan Cepat -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/90 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-clock text-orange-500"></i>
                        <span>Jam Layanan Kunjungan</span>
                    </h3>
                    <span id="schoolStatusBadge" class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                        Buka
                    </span>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Senin - Jumat:</span>
                        <span class="font-bold text-slate-800">07:00 - 15:30 WIB</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Sabtu:</span>
                        <span class="font-bold text-slate-800">08:00 - 12:00 WIB</span>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <span class="text-slate-500 font-medium">Minggu / Libur Nasional:</span>
                        <span class="font-bold text-rose-600">Tutup</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 space-y-2">
                    <h4 class="font-bold text-slate-900 text-xs">Sudah Pernah Mendaftar?</h4>
                    <a href="{{ route('ticket.lookup') }}" class="w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-xs font-bold flex items-center justify-center gap-2 transition-colors shadow-xs">
                        <i class="fa-solid fa-magnifying-glass text-orange-400"></i>
                        <span>Cek Status / Cetak Ulang Tiket</span>
                    </a>
                </div>

                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 text-[11px] text-slate-500 flex items-center gap-2.5">
                    <i class="fa-solid fa-phone text-orange-500 text-sm shrink-0"></i>
                    <div>
                        <span class="font-bold text-slate-700 block">Layanan Informasi Resepsionis</span>
                        <span>(0251) 8328700 &bull; info@smkpesat.sch.id</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Quick chips for purpose input
    function setQuickPurpose(text) {
        const input = document.getElementById('purpose');
        if (input) {
            input.value = text;
            input.focus();
        }
    }

    // Guest count increment / decrement
    function adjustGuestCount(delta) {
        const input = document.getElementById('guest_count');
        if (input) {
            let val = parseInt(input.value, 10) || 1;
            val = Math.max(1, Math.min(100, val + delta));
            input.value = val;
        }
    }

    // Interactive radio appointment options
    document.addEventListener('DOMContentLoaded', function () {
        const appointmentOptions = document.querySelectorAll('.appointment-option');
        
        appointmentOptions.forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            
            card.addEventListener('click', function () {
                appointmentOptions.forEach(c => {
                    c.classList.remove('border-orange-500', 'bg-orange-50/40', 'shadow-xs');
                    c.classList.add('border-slate-200/90', 'bg-slate-50/50');
                    const ind = c.querySelector('.radio-indicator');
                    if (ind) {
                        ind.classList.remove('border-orange-500', 'bg-orange-500', 'text-white');
                        ind.classList.add('border-slate-300');
                        const icon = ind.querySelector('i');
                        if (icon) icon.classList.add('hidden');
                    }
                });

                radio.checked = true;
                card.classList.remove('border-slate-200/90', 'bg-slate-50/50');
                card.classList.add('border-orange-500', 'bg-orange-50/40', 'shadow-xs');
                
                const ind = card.querySelector('.radio-indicator');
                if (ind) {
                    ind.classList.remove('border-slate-300');
                    ind.classList.add('border-orange-500', 'bg-orange-500', 'text-white');
                    const icon = ind.querySelector('i');
                    if (icon) icon.classList.remove('hidden');
                }
            });
        });

        // Determine school open/closed status badge
        const statusBadge = document.getElementById('schoolStatusBadge');
        if (statusBadge) {
            const now = new Date();
            const day = now.getDay(); // 0 = Sunday, 6 = Saturday
            const hour = now.getHours();
            const min = now.getMinutes();
            const time = hour + min / 60;

            let isOpen = false;
            if (day >= 1 && day <= 5) {
                // Senin - Jumat 07:00 - 15:30
                isOpen = (time >= 7.0 && time <= 15.5);
            } else if (day === 6) {
                // Sabtu 08:00 - 12:00
                isOpen = (time >= 8.0 && time <= 12.0);
            }

            if (isOpen) {
                statusBadge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800';
                statusBadge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse mr-1"></span> Buka Sekarang';
            } else {
                statusBadge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600';
                statusBadge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1"></span> Sedang Tutup';
            }
        }

        // ==========================================
        // TEACHER / HOST AUTOCOMPLETE WITH DEPARTMENT
        // ==========================================
        const hostInput = document.getElementById('host_name_input');
        const hostHidden = document.getElementById('host_hidden');
        const hostClearBtn = document.getElementById('host_clear_btn');
        const departmentSelect = document.getElementById('department_id');

        // Master host options from PHP
        const hostData = @json($hostList ?? []);

        if (hostInput && hostHidden) {
            // Suggestion container
            const suggestionsDiv = document.createElement('div');
            suggestionsDiv.id = 'host-suggestions';
            suggestionsDiv.className = 'absolute top-full left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-2xl shadow-xl max-h-72 overflow-y-auto z-50 hidden divide-y divide-slate-100';
            hostInput.parentElement.style.position = 'relative';
            hostInput.parentElement.appendChild(suggestionsDiv);

            function updateClearBtn() {
                if (hostClearBtn) {
                    if (hostInput.value.trim() !== '') {
                        hostClearBtn.classList.remove('hidden');
                    } else {
                        hostClearBtn.classList.add('hidden');
                    }
                }
            }

            if (hostClearBtn) {
                hostClearBtn.addEventListener('click', function () {
                    hostInput.value = '';
                    hostHidden.value = '';
                    updateClearBtn();
                    suggestionsDiv.classList.add('hidden');
                });
            }

            // Show suggestions
            function showSuggestions(query) {
                suggestionsDiv.innerHTML = '';
                const q = query.trim().toLowerCase();
                const selectedDeptId = departmentSelect ? departmentSelect.value : null;

                let filtered = hostData;
                if (q.length > 0) {
                    filtered = hostData.filter(h => 
                        h.name.toLowerCase().includes(q) || 
                        (h.email && h.email.toLowerCase().includes(q)) || 
                        h.department_name.toLowerCase().includes(q)
                    );
                }

                if (filtered.length === 0) {
                    const emptyItem = document.createElement('div');
                    emptyItem.className = 'px-4 py-3 text-xs text-slate-400 text-center flex items-center justify-center gap-1.5';
                    emptyItem.innerHTML = '<i class="fa-solid fa-circle-exclamation text-amber-500"></i> Akun guru tidak ditemukan';
                    suggestionsDiv.appendChild(emptyItem);
                    suggestionsDiv.classList.remove('hidden');
                    return;
                }

                filtered.forEach(h => {
                    const isDeptMatch = selectedDeptId && String(h.department_id) === String(selectedDeptId);
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'w-full text-left px-4 py-3 hover:bg-orange-50/70 transition-colors flex items-center justify-between gap-3 group';
                    btn.innerHTML = `
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-chalkboard-user text-xs"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="font-bold text-xs text-slate-800 group-hover:text-orange-600 truncate">${h.name}</div>
                                <div class="text-[11px] text-slate-500 truncate flex items-center gap-1.5 mt-0.5">
                                    <span class="text-orange-600 font-mono text-[10px] bg-orange-50 px-1.5 py-0.5 rounded border border-orange-200/50">${h.email || 'Akun Guru'}</span>
                                    <span>&bull;</span>
                                    <span class="text-slate-400">${h.department_name}</span>
                                </div>
                            </div>
                        </div>
                        ${isDeptMatch ? '<span class="text-[10px] font-semibold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full shrink-0">Sesuai Divisi</span>' : ''}
                    `;

                    btn.addEventListener('click', function () {
                        hostInput.value = h.name;
                        hostHidden.value = h.id;
                        updateClearBtn();
                        suggestionsDiv.classList.add('hidden');

                        // Automatically sync department if available and not selected
                        if (departmentSelect && h.department_id) {
                            departmentSelect.value = h.department_id;
                        }
                    });

                    suggestionsDiv.appendChild(btn);
                });

                suggestionsDiv.classList.remove('hidden');
            }

            hostInput.addEventListener('input', function () {
                hostHidden.value = '';
                updateClearBtn();
                showSuggestions(this.value);
            });

            hostInput.addEventListener('focus', function () {
                showSuggestions(this.value);
            });

            document.addEventListener('click', function (e) {
                if (!hostInput.contains(e.target) && !suggestionsDiv.contains(e.target) && !hostClearBtn?.contains(e.target)) {
                    suggestionsDiv.classList.add('hidden');
                }
            });
        }

        // ==========================================
        // SUBMIT FORM HANDLING (PREVENT DOUBLE POST)
        // ==========================================
        const form = document.getElementById('guestRegistrationForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitBtnText = document.getElementById('submitBtnText');

        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
                submitBtnText.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Sedang Menyimpan Data & Menerbitkan Tiket...';
            });
        }
    });

    function resetEntireForm() {
        const hostHidden = document.getElementById('host_hidden');
        if (hostHidden) hostHidden.value = '';
        const hostClearBtn = document.getElementById('host_clear_btn');
        if (hostClearBtn) hostClearBtn.classList.add('hidden');
        
        // Reset appointment options styling
        const appointmentOptions = document.querySelectorAll('.appointment-option');
        appointmentOptions.forEach(c => {
            c.classList.remove('border-orange-500', 'bg-orange-50/40', 'shadow-xs');
            c.classList.add('border-slate-200/90', 'bg-slate-50/50');
            const ind = c.querySelector('.radio-indicator');
            if (ind) {
                ind.classList.remove('border-orange-500', 'bg-orange-500', 'text-white');
                ind.classList.add('border-slate-300');
                const icon = ind.querySelector('i');
                if (icon) icon.classList.add('hidden');
            }
        });
    }
</script>
@endpush
