<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\GuestVisit;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');

        $totalToday = GuestVisit::whereDate('visit_date', $today)->count();
        $totalPending = GuestVisit::where('status', 'pending')->count();
        $totalActive = GuestVisit::where('status', 'checked_in')->count();
        $totalCompleted = GuestVisit::whereDate('visit_date', $today)->where('status', 'checked_out')->count();

        $statusFilter = $request->query('status');
        $dateFilter = $request->query('date', $today);
        $search = $request->query('search');

        $query = GuestVisit::with(['department', 'host'])
            ->orderBy('id', 'desc');

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if ($dateFilter) {
            $query->whereDate('visit_date', $dateFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('guest_name', 'LIKE', "%{$search}%")
                    ->orWhere('ticket_code', 'LIKE', "%{$search}%")
                    ->orWhere('institution', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $visits = $query->paginate(15)->withQueryString();
        $departments = Department::orderBy('name')->get();

        return view('admin.dashboard', compact(
            'totalToday',
            'totalPending',
            'totalActive',
            'totalCompleted',
            'visits',
            'statusFilter',
            'dateFilter',
            'search',
            'departments'
        ));
    }

    public function updateStatus(Request $request, GuestVisit $visit)
    {
        $request->validate([
            'status' => 'required|in:approved,checked_in,checked_out,rejected',
            'rejection_reason' => 'nullable|string',
        ]);

        $newStatus = $request->input('status');
        $data = ['status' => $newStatus];

        if ($newStatus === 'checked_in' && ! $visit->check_in_at) {
            $data['check_in_at'] = now();
        }

        if ($newStatus === 'checked_out' && ! $visit->check_out_at) {
            $data['check_out_at'] = now();
        }

        if ($newStatus === 'rejected') {
            $data['rejection_reason'] = $request->input('rejection_reason');
        }

        $visit->update($data);

        return back()->with('success', "Status kunjungan {$visit->ticket_code} berhasil diperbarui menjadi {$visit->status_label}.");
    }

    public function printBadge(GuestVisit $visit)
    {
        $visit->load(['department', 'host']);

        return view('admin.print_badge', compact('visit'));
    }
}
