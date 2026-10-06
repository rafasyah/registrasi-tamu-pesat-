@extends('layouts.app')

@section('title', 'Registrasi Tamu Baru - Buku Tamu SMK PESAT')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Hero Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-orange-950 rounded-2xl p-6 sm:p-8 text-white mb-8 shadow-xl relative overflow-hidden">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center space-x-2 bg-orange-500/20 text-orange-300 border border-orange-500/30 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-3">
                <i class="fa-solid fa-school-flag mr-1"></i> Selamat Datang di SMK PESAT Kota Bogor
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">Formulir Pendaftaran Kunjungan Tamu</h1>
            <p class="mt-2 text-sm sm:text-base text-slate-300 leading-relaxed">
                Silakan lengkapi formulir di bawah ini untuk mendaftarkan kunjungan Anda. Sistem akan memberikan Kode Tiket Digital untuk ditunjukkan saat berada di lokasi sekolah.
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none text-white text-[180px]">
            <i class="fa-solid fa-address-book"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Form Column -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
                
                <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center mr-2 text-sm font-bold">1</span>
                            Informasi Identitas & Kunjungan
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">Isi data identitas diri dan maksud kunjungan dengan benar.</p>
                    </div>
                    <span class="text-xs text-slate-400 font-medium">* Wajib diisi</span>
                </div>

                <form action="{{ route('guest.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- 1. Data Tamu -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        
                        <!-- Nama Lengkap -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Nama Lengkap Tamu <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" name="guest_name" value="{{ old('guest_name') }}" required
                                    placeholder="Masukkan nama lengkap Anda"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                            </div>
                            @error('guest_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Instansi / Asal -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Instansi / Asal Sekolah / Perusahaan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-building"></i>
                                </span>
                                <input type="text" name="institution" value="{{ old('institution') }}" required
                                    placeholder="Contoh: PT Telkom / Wali Murid / Pribadi"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                            </div>
                            @error('institution') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- No Telepon / WA -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Nomor Telepon / WhatsApp <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-phone"></i>
                                </span>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                            </div>
                            @error('phone') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Alamat Email (Opsional)
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                            </div>
                            @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Keperluan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Maksud / Keperluan Kunjungan <span class="text-rose-500">*</span>
                            </label>
                            <select name="purpose" required class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                                <option value="" disabled selected>-- Pilih Keperluan --</option>
                                <option value="Dinas / Kedinasan" {{ old('purpose') == 'Dinas / Kedinasan' ? 'selected' : '' }}>Dinas / Kedinasan</option>
                                <option value="Wali Murid" {{ old('purpose') == 'Wali Murid' ? 'selected' : '' }}>Wali Murid / Konsultasi Siswa</option>
                                <option value="Vendor / Kerjasama" {{ old('purpose') == 'Vendor / Kerjasama' ? 'selected' : '' }}>Vendor / Sales / MoU Kerjasama</option>
                                <option value="Alumni" {{ old('purpose') == 'Alumni' ? 'selected' : '' }}>Alumni / Urusan Berkas Ijazah</option>
                                <option value="Kunjungan Studi / Field Trip" {{ old('purpose') == 'Kunjungan Studi / Field Trip' ? 'selected' : '' }}>Kunjungan Studi / Field Trip</option>
                                <option value="Undangan Acara" {{ old('purpose') == 'Undangan Acara' ? 'selected' : '' }}>Undangan Acara Sekolah</option>
                                <option value="Lainnya" {{ old('purpose') == 'Lainnya' ? 'selected' : '' }}>Keperluan Lainnya</option>
                            </select>
                            @error('purpose') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- 2. Tujuan Kunjungan -->
                    <div class="pt-6 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        
                        <!-- Departemen Tujuan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Departemen / Divisi Tujuan <span class="text-rose-500">*</span>
                            </label>
                            <select name="department_id" id="department_id" required class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                                <option value="" disabled selected>-- Pilih Departemen --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }} ({{ $dept->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Guru / Staf Ditemui -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Guru / Staf yang Ingin Ditemui
                            </label>
                            <select name="host_id" id="host_id" class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                                <option value="">-- Pilih Guru/Staf (Optional) --</option>
                                @foreach($hosts as $host)
                                    <option value="{{ $host->id }}" data-dept="{{ $host->department_id }}" {{ old('host_id') == $host->id ? 'selected' : '' }}>
                                        {{ $host->name }} - {{ $host->position }}
                                    </option>
                                @endforeach
                            </select>
                            @error('host_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tanggal Kunjungan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Tanggal Kunjungan <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" required
                                class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                            @error('visit_date') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Jam Kunjungan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Perkiraan Jam Tiba <span class="text-rose-500">*</span>
                            </label>
                            <input type="time" name="scheduled_time" value="{{ old('scheduled_time', date('H:i')) }}" required
                                class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                            @error('scheduled_time') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Jumlah Tamu -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Jumlah Rombongan Tamu <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="100" required
                                class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                            @error('guest_count') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nomor Plat Kendaraan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Nomor Plat Kendaraan (Jika Ada)
                            </label>
                            <input type="text" name="vehicle_number" value="{{ old('vehicle_number') }}"
                                placeholder="Contoh: F 1234 ABC"
                                class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">
                        </div>

                        <!-- Catatan Additional -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                Catatan / Rincian Tambahan
                            </label>
                            <textarea name="notes" rows="3" placeholder="Tuliskan rincian lebih detail mengenai keperluan Anda..."
                                class="w-full py-2.5 px-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- 3. Foto Tamu Section (Webcam or Upload) -->
                    <div class="pt-6 border-t border-slate-100">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                            Foto Identitas / Tampak Muka (Opsional)
                        </label>
                        
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <div class="flex flex-col sm:flex-row items-center gap-4">
                                <!-- Webcam Preview Container -->
                                <div class="w-48 h-36 bg-slate-900 rounded-lg overflow-hidden flex items-center justify-center relative border border-slate-300 shrink-0">
                                    <video id="webcam" autoplay playsinline class="w-full h-full object-cover hidden"></video>
                                    <canvas id="canvas" class="w-full h-full object-cover hidden"></canvas>
                                    <img id="photo-preview" class="w-full h-full object-cover hidden" />
                                    <div id="webcam-placeholder" class="text-center p-3 text-slate-400">
                                        <i class="fa-solid fa-camera text-2xl mb-1"></i>
                                        <p class="text-[10px]">Kamera Mati</p>
                                    </div>
                                </div>

                                <div class="flex-1 space-y-2 text-center sm:text-left">
                                    <input type="hidden" name="captured_photo" id="captured_photo">
                                    
                                    <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                                        <button type="button" id="start-webcam-btn" onclick="startWebcam()" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-xs font-medium transition-colors inline-flex items-center">
                                            <i class="fa-solid fa-video mr-1.5"></i> Buka Kamera
                                        </button>
                                        <button type="button" id="capture-btn" onclick="takeSnapshot()" class="px-3 py-1.5 bg-orange-600 hover:bg-orange-500 text-white rounded-lg text-xs font-medium transition-colors hidden inline-flex items-center">
                                            <i class="fa-solid fa-camera-retro mr-1.5"></i> Ambil Foto
                                        </button>
                                        <button type="button" id="retake-btn" onclick="resetWebcam()" class="px-3 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-medium transition-colors hidden inline-flex items-center">
                                            <i class="fa-solid fa-rotate-left mr-1.5"></i> Foto Ulang
                                        </button>
                                    </div>

                                    <div class="text-[11px] text-slate-500">
                                        Atau unggah file foto langsung dari galeri HP/Laptop Anda:
                                    </div>
                                    <input type="file" name="photo" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-500 hover:to-amber-500 text-white font-bold text-base rounded-xl shadow-lg hover:shadow-orange-500/25 transition-all flex items-center justify-center space-x-2">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>KIRIM & DAPATKAN TIKET KUNJUNGAN</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Info Sidebar -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Petunjuk Kunjungan -->
            <div class="bg-slate-900 text-white rounded-2xl p-6 shadow-md border border-slate-800">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-500/20 text-orange-400 border border-orange-500/30 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Petunjuk Kunjungan</h3>
                        <p class="text-xs text-slate-400">Tata cara bertamu di SMK PESAT</p>
                    </div>
                </div>

                <ol class="space-y-3 text-xs text-slate-300 border-l border-slate-800 pl-4 ml-2">
                    <li class="relative">
                        <span class="absolute -left-[21px] top-0 w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                        <strong class="text-white block">1. Isi Form Online</strong>
                        Lengkapi formulir registrasi di halaman ini sebelum atau saat tiba di sekolah.
                    </li>
                    <li class="relative">
                        <span class="absolute -left-[21px] top-0 w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                        <strong class="text-white block">2. Tunjukkan Kode Tiket</strong>
                        Tunjukkan kode tiket digital (contoh: JTT-2026-0001) kepada petugas keamanan / frontdesk.
                    </li>
                    <li class="relative">
                        <span class="absolute -left-[21px] top-0 w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                        <strong class="text-white block">3. Ambil Visitor Badge</strong>
                        Petugas akan melakukan Check-In & memberikan Kartu Pengenal Tamu.
                    </li>
                    <li class="relative">
                        <span class="absolute -left-[21px] top-0 w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                        <strong class="text-white block">4. Selesai & Check-Out</strong>
                        Sebelum meninggalkan sekolah, lakukan Check-Out di meja resepsionis atau scan tiket.
                    </li>
                </ol>
            </div>

            <!-- Jam Operasional & Kontak -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 space-y-4">
                <h3 class="font-bold text-slate-900 text-sm flex items-center">
                    <i class="fa-solid fa-clock text-orange-500 mr-2"></i> Jam Layanan Resepsionis
                </h3>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Senin - Jumat:</span>
                        <span class="font-semibold text-slate-800">07:00 - 15:30 WIB</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Sabtu:</span>
                        <span class="font-semibold text-slate-800">08:00 - 12:00 WIB</span>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <span class="text-slate-500">Minggu / Libur:</span>
                        <span class="font-semibold text-rose-600">Tutup</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <h4 class="font-bold text-slate-900 text-xs mb-2">Punya Kode Tiket Sebelumnya?</h4>
                    <a href="{{ route('ticket.lookup') }}" class="w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-semibold flex items-center justify-center space-x-2 transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-slate-500"></i>
                        <span>Cek Status / Cetak Tiket</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Department Filter Host Dropdown
    document.addEventListener('DOMContentLoaded', function () {
        const deptSelect = document.getElementById('department_id');
        const hostSelect = document.getElementById('host_id');
        const allHostOptions = Array.from(hostSelect.options);

        deptSelect.addEventListener('change', function () {
            const selectedDeptId = this.value;
            
            // Clear current options except first
            hostSelect.innerHTML = '<option value="">-- Pilih Guru/Staf (Optional) --</option>';

            allHostOptions.forEach(opt => {
                if (opt.value && opt.dataset.dept === selectedDeptId) {
                    hostSelect.appendChild(opt.cloneNode(true));
                }
            });
        });
    });

    // Webcam Photo Handling
    let videoStream = null;

    function startWebcam() {
        const video = document.getElementById('webcam');
        const placeholder = document.getElementById('webcam-placeholder');
        const startBtn = document.getElementById('start-webcam-btn');
        const captureBtn = document.getElementById('capture-btn');

        navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            .then(function (stream) {
                videoStream = stream;
                video.srcObject = stream;
                video.classList.remove('hidden');
                placeholder.classList.add('hidden');
                startBtn.classList.add('hidden');
                captureBtn.classList.remove('hidden');
            })
            .catch(function (err) {
                alert('Tidak dapat mengakses kamera browser. Pastikan izin kamera aktif.');
                console.error(err);
            });
    }

    function takeSnapshot() {
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const preview = document.getElementById('photo-preview');
        const capturedInput = document.getElementById('captured_photo');
        const captureBtn = document.getElementById('capture-btn');
        const retakeBtn = document.getElementById('retake-btn');

        canvas.width = video.videoWidth || 320;
        canvas.height = video.videoHeight || 240;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/png');
        capturedInput.value = dataUrl;
        preview.src = dataUrl;

        // Stop camera stream
        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
        }

        video.classList.add('hidden');
        preview.classList.remove('hidden');
        captureBtn.classList.add('hidden');
        retakeBtn.classList.remove('hidden');
    }

    function resetWebcam() {
        const video = document.getElementById('webcam');
        const preview = document.getElementById('photo-preview');
        const capturedInput = document.getElementById('captured_photo');
        const retakeBtn = document.getElementById('retake-btn');
        const startBtn = document.getElementById('start-webcam-btn');

        capturedInput.value = '';
        preview.src = '';
        preview.classList.add('hidden');
        retakeBtn.classList.add('hidden');
        startBtn.classList.remove('hidden');
        
        startWebcam();
    }
</script>
@endpush
