@extends('layouts.teacher')

@section('title', 'Notifikasi - Guru')
@section('page_title', 'Notifikasi')
@section('page_subtitle', 'Lihat dan kelola semua notifikasi Anda.')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Notifikasi</h2>
            <p class="text-sm text-slate-500 mt-1">Riwayat notifikasi jadwal dan kunjungan tamu</p>
        </div>
        <form action="{{ route('teacher.notifications.read_all') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-3 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-bold transition-colors">
                <i class="fa-solid fa-check-double mr-1"></i> Tandai Semua Dibaca
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
        @if($notifications->isNotEmpty())
            <div class="divide-y divide-slate-100">
                @foreach($notifications as $notification)
                    <a href="{{ $notification->action_url ?? '#' }}"
                        class="block p-5 hover:bg-slate-50 transition-colors {{ $notification->is_read ? '' : 'bg-orange-50/30' }}"
                        wire:navigate.hover>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                @if(! $notification->is_read)
                                    <div class="w-2.5 h-2.5 bg-orange-500 rounded-full mt-1.5"></div>
                                @else
                                    <div class="w-2.5 h-2.5 bg-slate-300 rounded-full mt-1.5"></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900 {{ $notification->is_read ? '' : 'font-bold' }}">{{ $notification->title }}</p>
                                        <p class="text-sm text-slate-600 mt-1 line-clamp-2">{{ $notification->message }}</p>
                                    </div>
                                    <span class="text-[10px] text-slate-400 whitespace-nowrap ml-2">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="p-4 border-t border-slate-200">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <i class="fa-solid fa-bell-slash text-5xl text-slate-300 mb-4 block"></i>
                <h3 class="text-lg font-semibold text-slate-600">Belum Ada Notifikasi</h3>
                <p class="text-slate-400 mt-1">Notifikasi akan muncul di sini saat ada jadwal baru atau tamu terhubung.</p>
            </div>
        @endif
    </div>

</div>
@endsection