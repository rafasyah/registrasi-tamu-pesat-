@extends('layouts.app')

@section('title', 'Check-out & Rating Kunjungan - Buku Tamu SMK PESAT')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 sm:p-8 space-y-6">
        
        <!-- Title Header -->
        <div class="flex items-center space-x-3 pb-6 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xl shrink-0">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Form Check-out & Rating Kunjungan</h1>
                <p class="text-xs text-slate-500">Konfirmasi kepulangan dan berikan penilaian terhadap layanan bertamu di SMK PESAT.</p>
            </div>
        </div>

        <form action="{{ route('guest.checkout.process') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Kode Tiket Input -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Kode Tiket Kunjungan <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-ticket"></i>
                    </span>
                    <input type="text" name="ticket_code" value="{{ old('ticket_code', $code ?? ($visit->ticket_code ?? '')) }}" required
                        placeholder="Contoh: JTT-2026-0001"
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-base font-mono font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all uppercase">
                </div>
                @error('ticket_code') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Visit Details Preview if visit object loaded -->
            @if($visit)
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nama Tamu:</span>
                        <span class="font-bold text-slate-900">{{ $visit->guest_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Instansi:</span>
                        <span class="font-semibold text-slate-800">{{ $visit->institution }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tujuan Kunjungan:</span>
                        <span class="font-semibold text-orange-600">{{ $visit->host->name ?? ($visit->department->name ?? '-') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Status Saat Ini:</span>
                        <span class="font-bold text-emerald-700">{{ $visit->status_label }}</span>
                    </div>
                </div>
            @endif

            <!-- 2. Interactive Star Rating -->
            <div class="pt-4 border-t border-slate-100 text-center">
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-3">
                    Bagaimana Tingkat Kepuasan Layanan Bertamu Anda?
                </label>

                <div class="flex items-center justify-center space-x-3 my-2" id="star-rating-container">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="cursor-pointer transition-transform hover:scale-125">
                            <input type="radio" name="rating" value="{{ $i }}" class="sr-only star-input" {{ old('rating', 5) == $i ? 'checked' : '' }}>
                            <i class="fa-solid fa-star text-3xl star-icon text-slate-300 transition-colors" data-rating="{{ $i }}"></i>
                        </label>
                    @endfor
                </div>
                <p id="rating-label" class="text-xs font-semibold text-amber-600 mt-1">Sangat Puas (5 Bintang)</p>
            </div>

            <!-- 3. Feedback Comment -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Ulasan / Masukkan & Saran (Opsional)
                </label>
                <textarea name="feedback_comment" rows="3" placeholder="Tuliskan pengalaman bertamu atau masukan untuk perbaikan layanan kami..."
                    class="w-full p-3.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">{{ old('feedback_comment') }}</textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-base rounded-xl shadow-lg hover:shadow-emerald-500/25 transition-all flex items-center justify-center space-x-2">
                <i class="fa-solid fa-check-double"></i>
                <span>KONFIRMASI CHECK-OUT</span>
            </button>
        </form>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-icon');
        const inputs = document.querySelectorAll('.star-input');
        const ratingLabel = document.getElementById('rating-label');

        const ratingTexts = {
            1: 'Sangat Tidak Puas (1 Bintang)',
            2: 'Kurang Puas (2 Bintang)',
            3: 'Cukup Puas (3 Bintang)',
            4: 'Puas (4 Bintang)',
            5: 'Sangat Puas (5 Bintang)'
        };

        function updateStars(val) {
            stars.forEach(star => {
                const r = parseInt(star.dataset.rating);
                if (r <= val) {
                    star.classList.remove('text-slate-300');
                    star.classList.add('text-amber-400');
                } else {
                    star.classList.remove('text-amber-400');
                    star.classList.add('text-slate-300');
                }
            });
            ratingLabel.textContent = ratingTexts[val] || '';
        }

        // Initialize with default checked
        const checkedInput = document.querySelector('.star-input:checked');
        if (checkedInput) {
            updateStars(parseInt(checkedInput.value));
        }

        inputs.forEach(input => {
            input.addEventListener('change', function() {
                updateStars(parseInt(this.value));
            });
        });
    });
</script>
@endpush
