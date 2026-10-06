<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Guru Dashboard - Buku Tamu PESAT')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="h-full font-sans antialiased text-slate-800 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 min-h-screen border-r border-slate-800 shadow-xl">
        <!-- Sidebar Brand -->
        <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-950/40">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg bg-orange-600 text-white flex items-center justify-center font-bold text-lg shadow-md">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <h1 class="font-bold text-sm text-white tracking-wide">GURU PANEL</h1>
                    <p class="text-[11px] text-orange-400 font-medium">Buku Tamu SMK PESAT</p>
                </div>
            </div>
        </div>

        <!-- Teacher Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <div class="px-3 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Utama</div>

            <a href="{{ route('teacher.schedules.index') }}" class="flex items-center px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('teacher.schedules*') ? 'bg-orange-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i class="fa-solid fa-calendar-days w-6 text-center mr-2"></i> Jadwal Pertemuan
            </a>

            <a href="{{ route('teacher.schedules.create') }}" class="flex items-center px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all text-slate-400 hover:text-white hover:bg-slate-800">
                <i class="fa-solid fa-plus w-6 text-center mr-2"></i> Buat Jadwal Baru
            </a>
        </nav>

        <!-- User Info & Logout -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/60 flex items-center justify-between">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="w-8 h-8 rounded-full bg-slate-700 text-slate-200 flex items-center justify-center font-bold text-xs shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                </div>
                <div class="truncate">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Guru' }}</p>
                    <p class="text-[10px] text-slate-400 capitalize">{{ Auth::user()->role ?? 'Teacher' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" title="Logout" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- Topbar -->
        <header class="bg-white border-b border-slate-200 h-20 flex items-center justify-between px-8 shadow-xs sticky top-0 z-30">
            <div>
                <h2 class="text-xl font-bold text-slate-800">@yield('page_title', 'Jadwal Guru')</h2>
                <p class="text-xs text-slate-500">@yield('page_subtitle', 'Kelola jadwal pertemuan dan kunjungan tamu secara real-time.')</p>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Notification Bell -->
                <div class="relative">
                    <button onclick="toggleNotifications()" class="relative p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors" aria-label="Notifikasi">
                        <i class="fa-solid fa-bell text-lg"></i>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center animate-pulse">
                                {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                            </span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-slate-200 z-50 overflow-hidden">
                        <div class="p-4 border-b border-slate-200 flex items-center justify-between">
                            <h3 class="font-bold text-sm text-slate-800">Notifikasi</h3>
                            <button onclick="toggleNotifications()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div class="max-h-80 overflow-y-auto" id="notifications-list">
                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                                @php
                                    $notifications = \App\Models\Notification::where('user_id', auth()->id())->unread()->latest()->take(10)->get();
                                @endphp
                                @foreach($notifications as $notification)
                                    <a href="{{ $notification->action_url ?? '#' }}" class="block p-3 hover:bg-slate-50 border-b border-slate-100 transition-colors" wire:navigate.hover>
                                        <div class="flex items-start space-x-3">
                                            <div class="w-2 h-2 mt-2 bg-orange-500 rounded-full flex-shrink-0"></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-slate-900">{{ $notification->title }}</p>
                                                <p class="text-xs text-slate-600 mt-0.5 line-clamp-2">{{ $notification->message }}</p>
                                                <p class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="p-6 text-center text-slate-400">
                                    <i class="fa-solid fa-bell-slash text-3xl mb-2 block"></i>
                                    <p class="text-sm">Tidak ada notifikasi baru</p>
                                </div>
                            @endif
                        </div>
                        <div class="p-3 border-t border-slate-200 text-right">
                            <a href="{{ route('teacher.notifications') }}" class="text-xs font-semibold text-orange-600 hover:text-orange-800">Lihat semua notifikasi</a>
                        </div>
                    </div>
                </div>

                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200 flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>System Active &bull; {{ date('d M Y') }}</span>
                </span>
            </div>
        </header>

        <!-- Flash Banners -->
        <div class="p-8 pb-0">
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-xs flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-xs flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-circle-xmark text-rose-600 text-lg"></i>
                        <p class="text-sm font-medium text-rose-800">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
        </div>

        <main class="p-8 flex-1">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        function toggleNotifications() {
            const dropdown = document.getElementById('notifications-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('notifications-dropdown');
            const bell = e.target.closest('button[aria-label="Notifikasi"]');
            if (!bell && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>