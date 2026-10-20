<?php

namespace App\Http\Controllers;

use App\Models\GuestVisit;
use Illuminate\Http\Request;

class TicketPassController extends Controller
{
    public function show($code)
    {
        $visit = GuestVisit::with(['department', 'host'])
            ->where('ticket_code', $code)
            ->firstOrFail();

        session(['guest_ticket_code' => $visit->ticket_code]);

        return view('guest.ticket', compact('visit'));
    }

    public function lookup()
    {
        return view('guest.lookup');
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        $query = trim($request->input('query'));

        $visit = GuestVisit::where('ticket_code', $query)
            ->orWhere('phone', $query)
            ->orderBy('id', 'desc')
            ->first();

        if (! $visit) {
            return back()->with('error', 'Kode Tiket atau Nomor Telepon "'.$query.'" tidak ditemukan.');
        }

        return redirect()->route('ticket.show', $visit->ticket_code);
    }

    public function checkout(Request $request, $code)
    {
        $visit = GuestVisit::where('ticket_code', $code)->firstOrFail();

        if ($visit->status === 'checked_in') {
            $data = [
                'status' => 'checked_out',
                'check_out_at' => now(),
            ];

            if ($request->filled('meeting_result')) {
                $data['meeting_result'] = $request->input('meeting_result');
            }

            if ($request->filled('feedback_comment')) {
                $data['feedback_comment'] = $request->input('feedback_comment');
            }

            $visit->update($data);
        }

        return redirect()->route('ticket.show', $visit->ticket_code)
            ->with('success', 'Check-out berhasil. Terima kasih atas kunjungan Anda.');
    }
}
