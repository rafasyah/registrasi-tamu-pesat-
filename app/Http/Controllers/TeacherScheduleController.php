<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\GuestVisit;
use App\Models\Notification;
use App\Models\TeacherSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherScheduleController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->load('host');

        $query = TeacherSchedule::where('host_id', $teacher->host?->id)
            ->with(['department', 'guestVisits.department', 'guestVisits.host']);

        if ($request->filled('date')) {
            $query->whereDate('scheduled_date', $request->date);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('location', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $schedules = $query->orderByDesc('scheduled_date')->orderByDesc('start_time')->paginate(15)->withQueryString();
        $departments = Department::orderBy('name')->get();

        $stats = [
            'total' => TeacherSchedule::where('host_id', $teacher->host?->id)->count(),
            'scheduled' => TeacherSchedule::where('host_id', $teacher->host?->id)->where('status', 'scheduled')->count(),
            'ongoing' => TeacherSchedule::where('host_id', $teacher->host?->id)->where('status', 'ongoing')->count(),
            'completed' => TeacherSchedule::where('host_id', $teacher->host?->id)->where('status', 'completed')->count(),
            'cancelled' => TeacherSchedule::where('host_id', $teacher->host?->id)->where('status', 'cancelled')->count(),
        ];

        $unreadNotifications = Notification::where('user_id', Auth::id())->unread()->count();

        return view('teacher.dashboard', compact(
            'schedules',
            'departments',
            'stats',
            'unreadNotifications'
        ));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $host = Auth::user()->host;

        return view('teacher.schedule_form', compact(
            'departments',
            'host'
        ));
    }

    public function store(Request $request)
    {
        $host = Auth::user()->host;

        if (! $host) {
            return back()->with('error', 'Profil host Anda belum terhubung dengan akun. Hubungi admin.');
        }

        $validated = $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'scheduled_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $schedule = TeacherSchedule::create([
            'host_id' => $host->id,
            'department_id' => $validated['department_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'scheduled_date' => $validated['scheduled_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'location' => $validated['location'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'scheduled',
        ]);

        // Create notification for the teacher
        Notification::createForTeacher(
            Auth::id(),
            'schedule_created',
            'Jadwal Baru Dibuat',
            "Jadwal pertemuan \"{$schedule->title}\" telah dibuat untuk {$schedule->scheduled_date->format('d/m/Y')}.",
            ['schedule_id' => $schedule->id],
            route('teacher.schedules.show', $schedule)
        );

        return redirect()->route('teacher.schedules.index')->with('success', 'Jadwal pertemuan berhasil dibuat.');
    }

    public function show(TeacherSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $schedule->load(['department', 'guestVisits.department', 'guestVisits.host']);

        return view('teacher.schedule_show', compact('schedule'));
    }

    public function edit(TeacherSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $departments = Department::orderBy('name')->get();

        return view('teacher.schedule_form', compact(
            'schedule',
            'departments'
        ));
    }

    public function update(Request $request, TeacherSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $validated = $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'scheduled_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $schedule->update($validated);

        return redirect()->route('teacher.schedules.index')->with('success', 'Jadwal pertemuan berhasil diperbarui.');
    }

    public function destroy(TeacherSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $schedule->delete();

        return redirect()->route('teacher.schedules.index')->with('success', 'Jadwal pertemuan berhasil dihapus.');
    }

    public function attachGuestVisit(Request $request, TeacherSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $request->validate([
            'guest_visit_id' => 'required|exists:guest_visits,id',
        ]);

        $exists = $schedule->guestVisits()->where('guest_visit_id', $request->guest_visit_id)->exists();

        if ($exists) {
            return back()->with('error', 'Tamu sudah terhubung dengan jadwal ini.');
        }

        $schedule->guestVisits()->attach($request->guest_visit_id);

        $guestVisit = GuestVisit::find($request->guest_visit_id);

        // Create notification for the teacher
        Notification::createForTeacher(
            Auth::id(),
            'guest_visit_attached',
            'Tamu Baru Terhubung',
            "Tamu \"{$guestVisit->guest_name}\" dari {$guestVisit->institution} telah ditambahkan ke jadwal \"{$schedule->title}\".",
            ['schedule_id' => $schedule->id, 'guest_visit_id' => $guestVisit->id],
            route('teacher.schedules.show', $schedule)
        );

        return back()->with('success', 'Tamu berhasil ditambahkan ke jadwal pertemuan.');
    }

    public function detachGuestVisit(TeacherSchedule $schedule, GuestVisit $guestVisit)
    {
        $this->authorizeSchedule($schedule);

        $schedule->guestVisits()->detach($guestVisit->id);

        return back()->with('success', 'Tamu berhasil dihapus dari jadwal pertemuan.');
    }

    private function authorizeSchedule(TeacherSchedule $schedule): void
    {
        $hostId = Auth::user()->host?->id;

        if ((int) $schedule->host_id !== (int) $hostId) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
        }
    }

    public function notifications(Request $request)
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('teacher.notifications', compact('notifications'));
    }

    public function markNotificationRead(Notification $notification)
    {
        if ((int) $notification->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect($notification->action_url ?? route('teacher.notifications'));
    }

    public function markAllNotificationsRead(Request $request)
    {
        Notification::where('user_id', Auth::id())->unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Semua notifikasi ditandai sebagai dibaca.');
    }
}
