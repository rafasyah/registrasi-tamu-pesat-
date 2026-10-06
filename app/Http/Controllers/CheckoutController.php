<?php

namespace App\Http\Controllers;

use App\Models\GuestVisit;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $code = $request->query('code');
        $visit = null;

        if ($code) {
            $visit = GuestVisit::with(['department', 'host'])
                ->where('ticket_code', $code)
                ->first();
        }

        return view('guest.checkout', compact('visit', 'code'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'feedback_comment' => 'nullable|string',
        ]);

        $code = trim($request->input('ticket_code'));
        $visit = GuestVisit::where('ticket_code', $code)->first();

        if (! $visit) {
            return back()->with('error', 'Kode Tiket tidak ditemukan.');
        }

        if ($visit->status === 'checked_out') {
            return back()->with('info', 'Tiket kunjungan ini sudah melakukan Check-out sebelumnya.');
        }

        $visit->update([
            'status' => 'checked_out',
            'check_out_at' => now(),
            'rating' => $request->input('rating'),
            'feedback_comment' => $request->input('feedback_comment'),
        ]);

        return redirect()->route('ticket.show', $visit->ticket_code)
            ->with('success', 'Check-out berhasil dicatat. Terima kasih atas kunjungan Anda di SMK PESAT!');
    }
}
