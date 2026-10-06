<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Tamu {{ $visit->ticket_code }} - SMK PESAT</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        @media print {
            body { background: white; margin: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="no-print mb-6">
        <button onclick="window.print()" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-500 text-white font-bold rounded-xl text-sm shadow-md flex items-center space-x-2">
            <i class="fa-solid fa-print"></i>
            <span>Cetak Kartu Badge Tamu</span>
        </button>
    </div>

    <!-- Badge Card Container (Standard ID Card format) -->
    <div class="w-[350px] bg-white rounded-2xl shadow-xl border-2 border-slate-900 overflow-hidden text-slate-800 relative">
        
        <!-- Header -->
        <div class="bg-slate-900 text-white p-4 text-center border-b-4 border-orange-500">
            <h1 class="font-extrabold text-base tracking-wider">SMK PESAT KOTA BOGOR</h1>
            <p class="text-[10px] text-orange-400 uppercase tracking-widest font-semibold">KARTU TAMU / VISITOR PASS</p>
        </div>

        <!-- Body -->
        <div class="p-5 text-center space-y-3">
            
            <!-- Photo if present -->
            @if($visit->photo_path)
                <img src="{{ asset('storage/' . $visit->photo_path) }}" class="w-24 h-24 rounded-2xl object-cover border-2 border-slate-300 mx-auto shadow-sm">
            @else
                <div class="w-20 h-20 rounded-2xl bg-slate-200 text-slate-500 flex items-center justify-center text-3xl font-extrabold mx-auto">
                    <i class="fa-solid fa-user"></i>
                </div>
            @endif

            <div>
                <h2 class="font-extrabold text-lg text-slate-900 leading-tight uppercase">{{ $visit->guest_name }}</h2>
                <p class="text-xs font-semibold text-slate-600">{{ $visit->institution }}</p>
            </div>

            <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200 text-xs">
                <span class="text-[10px] text-slate-400 block font-bold uppercase">Bertemu Dengan:</span>
                <strong class="text-slate-800 text-sm block">{{ $visit->host->name ?? ($visit->department->name ?? '-') }}</strong>
                <span class="text-[10px] text-slate-500 block">Tujuan: {{ $visit->purpose }}</span>
            </div>

            <!-- Ticket Code & QR Code -->
            <div class="pt-2 flex flex-col items-center">
                <div class="text-lg font-extrabold font-mono text-orange-600 tracking-wider mb-2">
                    {{ $visit->ticket_code }}
                </div>
                <div id="qrcode" class="p-2 bg-white border border-slate-200 rounded-lg inline-block"></div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-slate-900 text-slate-400 text-[10px] p-2.5 text-center border-t border-slate-800 font-medium">
            Harap dikembalikan saat keluar dari SMK PESAT Kota Bogor
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new QRCode(document.getElementById('qrcode'), {
                text: "{{ route('ticket.show', $visit->ticket_code) }}",
                width: 80,
                height: 80,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.M
            });
        });
    </script>
</body>
</html>
