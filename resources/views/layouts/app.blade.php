<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Buku Tamu Digital SMK PESAT')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- QR Code Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body class="h-full font-sans antialiased text-slate-800 flex flex-col min-h-screen">
    
    <!-- Navbar -->
    <header class="bg-slate-900 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo & Title -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-500 to-orange-600 flex items-center justify-center text-white font-extrabold text-xl shadow-lg group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-address-book"></i>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="font-bold text-lg tracking-wide text-white">SMK PESAT</span>
                            <span class="bg-orange-500/20 text-orange-400 text-xs font-semibold px-2 py-0.5 rounded-full border border-orange-500/30">Official Portal</span>
                        </div>
                        <p class="text-xs text-slate-400">Sistem Buku Tamu Digital & Digital Pass</p>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('guest.register') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('guest.register') || request()->routeIs('home') ? 'bg-orange-600 text-white shadow' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <i class="fa-solid fa-user-plus mr-1.5 text-xs"></i> Registrasi Tamu
                    </a>
                    <a href="{{ route('ticket.lookup') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('ticket.lookup') ? 'bg-orange-600 text-white shadow' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <i class="fa-solid fa-ticket mr-1.5 text-xs"></i> Cek Tiket / Status
                    </a>
                    <a href="{{ route('guest.checkout') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('guest.checkout') ? 'bg-orange-600 text-white shadow' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <i class="fa-solid fa-right-from-bracket mr-1.5 text-xs"></i> Selesai / Check-Out
                    </a>
                </nav>

                <!-- Admin Action -->
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 px-4 py-2 rounded-lg text-sm font-medium flex items-center space-x-2 transition-all">
                            <i class="fa-solid fa-gauge-high text-orange-400"></i>
                            <span>Dashboard Admin</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white border border-slate-700 px-3.5 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all">
                            <i class="fa-solid fa-lock mr-1.5"></i> Petugas Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-xmark text-rose-600 text-lg"></i>
                    <p class="text-sm font-medium text-rose-800">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-sm flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-info text-blue-600 text-lg"></i>
                    <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 text-xs py-6 mt-auto border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <span class="font-semibold text-slate-300">SMK PESAT Kota Bogor</span>
                <span>&bull;</span>
                <span>Sekolah Informatika & Multimedia</span>
            </div>
            <div class="text-slate-500 text-center md:text-right">
                &copy; {{ date('Y') }} Buku Tamu Digital. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
