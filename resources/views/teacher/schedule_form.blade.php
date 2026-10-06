@extends('layouts.teacher')

@section('title', $schedule ? 'Edit Jadwal' : 'Buat Jadwal Baru - Guru')
@section('page_title', $schedule ? 'Edit Jadwal Pertemuan' : 'Buat Jadwal Pertemuan Baru')
@section('page_subtitle', $schedule ? 'Perbarui detail jadwal pertemuan Anda' : 'Buat jadwal pertemuan baru untuk kelola kunjungan tamu')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6">

        <form action="{{ $schedule ? route('teacher.schedules.update', $schedule) : route('teacher.schedules.store') }}" method="POST" class="space-y-6">
            @csrf
            @if($schedule)
                @method('PUT')
            @endif

            <!-- Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Judul Pertemuan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title', $schedule->title ?? '') }}" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    @error('title')
                        <p class="text-[10px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Departemen
                    </label>
                    <select name="department_id"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">Pilih Departemen</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $schedule->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="text-[10px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Status
                    </label>
                    <select name="status"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="scheduled" {{ old('status', $schedule->status ?? 'scheduled') == 'scheduled' ? 'selected' : '' }}>Dijadwalkan</option>
                        <option value="ongoing" {{ old('status', $schedule->status ?? '') == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="completed" {{ old('status', $schedule->status ?? '') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ old('status', $schedule->status ?? '') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Tanggal <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="scheduled_date" value="{{ old('scheduled_date', $schedule->scheduled_date->format('Y-m-d') ?? '') }}" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    @error('scheduled_date')
                        <p class="text-[10px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                            Jam Mulai <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="start_time" value="{{ old('start_time', substr($schedule->start_time ?? '', 0, 5)) }}" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('start_time')
                            <p class="text-[10px] text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                            Jam Selesai <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="end_time" value="{{ old('end_time', substr($schedule->end_time ?? '', 0, 5)) }}" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('end_time')
                            <p class="text-[10px] text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Lokasi
                    </label>
                    <input type="text" name="location" value="{{ old('location', $schedule->location ?? '') }}"
                        placeholder="misal: Ruang Rapat A, Zoom, dll."
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    @error('location')
                        <p class="text-[10px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Deskripsi / Keperluan
                    </label>
                    <textarea name="description" rows="3"
                        placeholder="Deskripsikan tujuan pertemuan..."
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('description', $schedule->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-[10px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Catatan
                    </label>
                    <textarea name="notes" rows="2"
                        placeholder="Catatan tambahan (opsional)..."
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('notes', $schedule->notes ?? '') }}</textarea>
                    @error('notes')
                        <p class="text-[10px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-slate-200">
                <a href="{{ route('teacher.schedules.index') }}" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-md transition-colors">
                    {{ $schedule ? 'Perbarui Jadwal' : 'Simpan Jadwal' }}
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
