<?php

namespace App\Http\Controllers;

use App\Models\GuestVisit;
use Illuminate\Contracts\View\View;

class GuestProfileController extends Controller
{
    /**
     * Tampilkan profil tamu beserta riwayat tiket kunjungannya.
     * Diakses lewat kode tiket; riwayat digabung berdasarkan no. HP (dan email).
     */
    public function show(string $code): View
    {
        $currentVisit = GuestVisit::with(['department', 'host'])
            ->where('ticket_code', $code)
            ->firstOrFail();

        session(['guest_ticket_code' => $currentVisit->ticket_code]);

        $history = GuestVisit::with(['department', 'host'])
            ->where(function ($query) use ($currentVisit) {
                $query->where('phone', $currentVisit->phone);

                if ($currentVisit->email) {
                    $query->orWhere('email', $currentVisit->email);
                }
            })
            ->orderByDesc('visit_date')
            ->orderByDesc('id')
            ->get();

        $stats = [
            'total' => $history->count(),
            'completed' => $history->where('status', 'checked_out')->count(),
            'active' => $history->whereIn('status', ['pending', 'approved', 'checked_in'])->count(),
            'rejected' => $history->where('status', 'rejected')->count(),
        ];

        return view('guest.profile', [
            'visit' => $currentVisit,
            'history' => $history,
            'stats' => $stats,
        ]);
    }
}
