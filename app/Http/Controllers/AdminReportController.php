<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\GuestVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;

class AdminReportController extends Controller
{
    /**
     * Menentukan rentang tanggal laporan.
     */
    private function getDateRange(Request $request): array
    {
        $period = $request->query('period', 'monthly');

        if (! in_array($period, ['weekly', 'monthly', 'custom'], true)) {
            $period = 'monthly';
        }

        $today = Carbon::today();

        if ($period === 'weekly') {
            $startDate = $today->copy()
                ->startOfWeek(Carbon::MONDAY)
                ->toDateString();

            $endDate = $today->copy()
                ->endOfWeek(Carbon::SUNDAY)
                ->toDateString();
        } elseif ($period === 'monthly') {
            $startDate = $today->copy()
                ->startOfMonth()
                ->toDateString();

            $endDate = $today->copy()
                ->endOfMonth()
                ->toDateString();
        } else {
            $startDate = $request->query(
                'start_date',
                $today->copy()->startOfMonth()->toDateString()
            );

            $endDate = $request->query(
                'end_date',
                $today->copy()->endOfMonth()->toDateString()
            );

            // Mencegah rentang tanggal terbalik.
            if ($startDate > $endDate) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }
        }

        return [$period, $startDate, $endDate];
    }

    public function index(Request $request)
    {
        [$period, $startDate, $endDate] =
            $this->getDateRange($request);

        $departmentId = $request->query('department_id');
        $purpose = $request->query('purpose');

        $query = GuestVisit::with([
            'department',
            'host',
            'receivedByHost',
        ])
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

        $totalApproved = $visits->whereIn(
            'status',
            ['approved', 'checked_in', 'checked_out']
        )->count();

        $totalRejected = $visits->where('status', 'rejected')->count();

        $avgRating = $visits->whereNotNull('rating')->avg('rating');

        $purposeCounts = $visits->groupBy('purpose')->map->count();

        $deptCounts = $visits
            ->groupBy(fn ($item) => $item->department->name ?? 'Lainnya')
            ->map->count();

        return view('admin.reports.index', compact(
            'visits',
            'departments',
            'period',
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
        [$period, $startDate, $endDate] =
            $this->getDateRange($request);

        $departmentId = $request->query('department_id');
        $purpose = $request->query('purpose');

        $query = GuestVisit::with([
            'department',
            'host',
            'receivedByHost',
        ])
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->orderBy('visit_date', 'asc');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        if ($purpose) {
            $query->where('purpose', $purpose);
        }

        $visits = $query->get();

        $csvFileName = 'rekap_buku_tamu_'
            . $startDate . '_to_' . $endDate . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' =>
                "attachment; filename=\"$csvFileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($visits) {
            $file = fopen('php://output', 'w');

            // BOM agar karakter terbaca dengan baik di Excel.
            fwrite($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

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
                'Guru/Staf yang Dituju',
                'Guru/Staf yang Menerima',
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
                    $visit->visit_date
                        ? $visit->visit_date->format('Y-m-d')
                        : '',
                    $visit->scheduled_time,
                    $visit->guest_name,
                    $visit->institution,
                    $visit->phone,
                    $visit->email,
                    $visit->purpose,
                    $visit->department->name ?? '-',
                    $visit->host->name ?? '-',
                    $visit->receivedByHost->name ?? '-',
                    $visit->guest_count,
                    $visit->vehicle_number ?? '-',
                    $visit->status_label,
                    $visit->check_in_at
                        ? $visit->check_in_at->format('Y-m-d H:i:s')
                        : '-',
                    $visit->check_out_at
                        ? $visit->check_out_at->format('Y-m-d H:i:s')
                        : '-',
                    $visit->rating ? $visit->rating . '/5' : '-',
                    $visit->feedback_comment ?? '-',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
