<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\GuestVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', date('Y-m-01'));
        $endDate = $request->query('end_date', date('Y-m-t'));
        $departmentId = $request->query('department_id');
        $purpose = $request->query('purpose');

        $query = GuestVisit::with(['department', 'host'])
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->orderBy('visit_date', 'desc');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        if ($purpose) {
            $query->where('purpose', $purpose);
        }

        $visits = $query->get();
        $departments = Department::orderBy('name')->get();

        $totalVisits = $visits->count();
        $totalApproved = $visits->whereIn('status', ['approved', 'checked_in', 'checked_out'])->count();
        $totalRejected = $visits->where('status', 'rejected')->count();
        $avgRating = $visits->whereNotNull('rating')->avg('rating');

        $purposeCounts = $visits->groupBy('purpose')->map->count();
        $deptCounts = $visits->groupBy(fn ($item) => $item->department->name ?? 'Lainnya')->map->count();

        return view('admin.reports.index', compact(
            'visits',
            'departments',
            'startDate',
            'endDate',
            'departmentId',
            'purpose',
            'totalVisits',
            'totalApproved',
            'totalRejected',
            'avgRating',
            'purposeCounts',
            'deptCounts'
        ));
    }

    public function exportCsv(Request $request)
    {
        $startDate = $request->query('start_date', date('Y-m-01'));
        $endDate = $request->query('end_date', date('Y-m-t'));
        $departmentId = $request->query('department_id');

        $query = GuestVisit::with(['department', 'host'])
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->orderBy('visit_date', 'asc');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $visits = $query->get();

        $csvFileName = 'rekap_buku_tamu_'.$startDate.'_to_'.$endDate.'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$csvFileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($visits) {
            $file = fopen('php://output', 'w');
            fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No Tiket',
                'Tanggal Kunjungan',
                'Jam Scheduled',
                'Nama Tamu',
                'Instansi / Asal',
                'No Telepon',
                'Email',
                'Keperluan',
                'Departemen Tujuan',
                'Guru/Staf yang Ditemui',
                'Jumlah Tamu',
                'Plat Kendaraan',
                'Status',
                'Waktu Check-In',
                'Waktu Check-Out',
                'Rating',
                'Ulasan',
            ]);

            foreach ($visits as $visit) {
                fputcsv($file, [
                    $visit->ticket_code,
                    $visit->visit_date ? $visit->visit_date->format('Y-m-d') : '',
                    $visit->scheduled_time,
                    $visit->guest_name,
                    $visit->institution,
                    $visit->phone,
                    $visit->email,
                    $visit->purpose,
                    $visit->department->name ?? '-',
                    $visit->host->name ?? '-',
                    $visit->guest_count,
                    $visit->vehicle_number,
                    $visit->status_label,
                    $visit->check_in_at ? $visit->check_in_at->format('Y-m-d H:i:s') : '-',
                    $visit->check_out_at ? $visit->check_out_at->format('Y-m-d H:i:s') : '-',
                    $visit->rating ? $visit->rating.'/5' : '-',
                    $visit->feedback_comment ?? '-',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
