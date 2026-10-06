@extends('layouts.app')

@section('title', 'Tiket Kunjungan ' . $visit->ticket_code . ' - SMK PESAT')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Print Hide Container -->
    <div class="space-y-6">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-6 text-white shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        <i class="fa-solid fa-circle-check mr-1"></i> Pass Digital Aktif
                    </span>
                    <span class="text-xs text-slate-400">Dibuat {{ $visit->created_at->diffForHumans() }}</span>
                </div>
                <h1 class="text-xl font-bold mt-1">Kartu Pass Kunjungan Tamu</h1>
                <p class="text-xs text-slate-300">Tunjukkan bukti registrasi ini ke petugas resepsionis/keamanan SMK PESAT.</p>
            </div>
            
            <div class="flex items-center space-x-2">
                <button onclick="window.print()" class="px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-md flex items-center space-x-2 transition-all">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Pass</span>
                </button>
                @if($visit->status === 'checked_in' || $visit->status === 'approved')
                    <a href="{{ route('guest.checkout', ['code' => $visit->ticket_code]) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold shadow-md flex items-center space-x-2 transition-all">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Check-Out Sekarang</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Ticket Pass Badge Component (Print Friendly) -->
        <div id="printable-card" class="bg-white rounded-2xl shadow-md border-2 border-slate-200 overflow-hidden">
            
            <!-- Card Header -->
            <div class="bg-slate-900 text-white p-6 border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-500 text-white flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-id-badge"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-base tracking-wide">SMK PESAT KOTA BOGOR</h2>
                        <p class="text-xs text-slate-400">Kartu Tamu / Visitor Pass Digital</p>
                    </div>
                </div>

                <!-- Status Badge -->
                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $visit->status_badge }}">
                    {{ $visit->status_label }}
                </span>
            </div>

            <!-- Card Content Grid -->
            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                
                <!-- Left: Ticket Code & QR Code -->
                <div class="md:col-span-5 bg-slate-50 p-6 rounded-xl border border-slate-200 text-center flex flex-col items-center justify-center">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">KODE TIKET KUNJUNGAN</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-orange-600 tracking-wider font-mono mb-4">
                        {{ $visit->ticket_code }}
                    </div>

                    <!-- QR Code Canvas -->
                    <div id="qrcode" class="p-3 bg-white border border-slate-200 rounded-xl shadow-xs inline-block mb-3"></div>
                    <p class="text-[11px] text-slate-500">Scan QR Code ini untuk verifikasi petugas</p>
                </div>

                <!-- Right: Detailed Information -->
                <div class="md:col-span-7 space-y-4">
                    
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 block font-semibold">Nama Tamu:</span>
                            <span class="font-bold text-slate-900 text-sm block">{{ $visit->guest_name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-semibold">Instansi / Asal:</span>
                            <span class="font-semibold text-slate-800 block">{{ $visit->institution }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-xs pt-3 border-t border-slate-100">
                        <div>
                            <span class="text-slate-400 block font-semibold">Keperluan:</span>
                            <span class="font-medium text-slate-800 block">{{ $visit->purpose }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-semibold">Departemen Tujuan:</span>
                            <span class="font-medium text-slate-800 block">{{ $visit->department->name ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-xs pt-3 border-t border-slate-100">
                        <div>
                            <span class="text-slate-400 block font-semibold">Guru / Staf yang Ditemui:</span>
                            <span class="font-semibold text-orange-600 block">{{ $visit->host->name ?? 'Frontdesk / Petugas' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-semibold">Tanggal & Jam:</span>
                            <span class="font-semibold text-slate-800 block">
                                {{ $visit->visit_date ? $visit->visit_date->format('d/m/Y') : '' }} @ {{ substr($visit->scheduled_time, 0, 5) }} WIB
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-xs pt-3 border-t border-slate-100">
                        <div>
                            <span class="text-slate-400 block font-semibold">Jumlah Tamu:</span>
                            <span class="font-semibold text-slate-800 block">{{ $visit->guest_count }} Orang</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-semibold">Plat Kendaraan:</span>
                            <span class="font-semibold text-slate-800 block">{{ $visit->vehicle_number ?: '-' }}</span>
                        </div>
                    </div>

                    @if($visit->rejection_reason)
                        <div class="p-3 bg-rose-50 border border-rose-200 rounded-lg text-xs text-rose-800 mt-2">
                            <strong class="block font-bold mb-1">Alasan Penolakan:</strong>
                            {{ $visit->rejection_reason }}
                        </div>
                    @endif

                    @if($visit->notes)
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-600 mt-2">
                            <span class="font-bold text-slate-700">Catatan:</span> {{ $visit->notes }}
                        </div>
                    @endif
                </div>

            </div>

            <!-- Card Footer -->
            <div class="bg-slate-50 p-4 border-t border-slate-200 text-center text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <span>Harap selalu memakai Kartu Tamu selama berada di area sekolah.</span>
                <span class="font-semibold text-slate-700">SMK PESAT Kota Bogor &bull; (0251) 8328700</span>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('guest.register') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold flex items-center space-x-2 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Registrasi Tamu Baru</span>
            </a>

            <a href="{{ route('ticket.lookup') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-semibold flex items-center space-x-2 transition-colors">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Cari Status Tiket Lain</span>
            </a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate QR Code
        const qrcodeContainer = document.getElementById('qrcode');
        if (qrcodeContainer) {
            new QRCode(qrcodeContainer, {
                text: "{{ route('ticket.show', $visit->ticket_code) }}",
                width: 120,
                height: 120,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }
    });
</script>
<style>
    @media print {
        header, footer, nav, button, a { display: none !important; }
        body { background: white !important; }
        #printable-card { border: none !important; shadow: none !important; }
    }
</style>
@endpush
