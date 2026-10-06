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
}
