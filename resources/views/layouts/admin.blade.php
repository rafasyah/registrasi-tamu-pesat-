<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Buku Tamu PESAT')</title>
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
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <h1 class="font-bold text-sm text-white tracking-wide">PANEL PETUGAS</h1>
                    <p class="text-[11px] text-orange-400 font-medium">Buku Tamu SMK PESAT</p>
                </div>
            </div>
        </div>

        <!-- Admin Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <div class="px-3 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Utama</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-orange-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i class="fa-solid fa-gauge-high w-6 text-center mr-2"></i> Dashboard Kunjungan
            </a>

            <div class="px-3 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Master Data</div>

            <a href="{{ route('admin.hosts.index') }}" class="flex items-center px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.hosts*') ? 'bg-orange-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i class="fa-solid fa-user-tie w-6 text-center mr-2"></i> Guru & Staf (Hosts)
            </a>

            <a href="{{ route('admin.departments.index') }}" class="flex items-center px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.departments*') ? 'bg-orange-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i class="fa-solid fa-sitemap w-6 text-center mr-2"></i> Departemen / Divisi
            </a>

            <div class="px-3 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Laporan</div>

            <a href="{{ route('admin.reports.index') }}" class="flex items-center px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.reports*') ? 'bg-orange-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i class="fa-solid fa-file-invoice w-6 text-center mr-2"></i> Rekapitulasi & Export
            </a>

            <div class="px-3 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Public View</div>

            <a href="{{ route('guest.register') }}" target="_blank" class="flex items-center px-3.5 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <i class="fa-solid fa-arrow-up-right-from-square w-6 text-center mr-2"></i> Form Registration View
            </a>
        </nav>

        <!-- User Info & Logout -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/60 flex items-center justify-between">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="w-8 h-8 rounded-full bg-slate-700 text-slate-200 flex items-center justify-center font-bold text-xs shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="truncate">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-slate-400 capitalize">{{ Auth::user()->role ?? 'Petugas' }}</p>
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
                <h2 class="text-xl font-bold text-slate-800">@yield('page_title', 'Dashboard')</h2>
                <p class="text-xs text-slate-500">@yield('page_subtitle', 'Kelola data kunjungan tamu SMK PESAT secara real-time')</p>
            </div>
            <div class="flex items-center space-x-4">
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
</body>
</html>
