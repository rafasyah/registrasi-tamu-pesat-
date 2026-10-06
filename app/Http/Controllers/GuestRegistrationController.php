<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\GuestVisit;
use App\Models\Host;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuestRegistrationController extends Controller
{
    public function index()
    {
        $departments = Department::with('hosts')->orderBy('name')->get();
        $hosts = Host::with('department')->orderBy('name')->get();

        return view('guest.register', compact('departments', 'hosts'));
    }

    public function getHostsByDepartment(Department $department)
    {
        return response()->json($department->hosts()->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'purpose' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'host_id' => 'nullable|exists:hosts,id',
            'visit_date' => 'required|date',
            'scheduled_time' => 'required',
            'guest_count' => 'required|integer|min:1|max:100',
            'vehicle_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'captured_photo' => 'nullable|string',
            'photo' => 'nullable|image|max:5000',
        ]);

        $ticketCode = GuestVisit::generateTicketCode();
        $photoPath = null;

        if ($request->filled('captured_photo')) {
            $imageData = $request->input('captured_photo');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);
                $imageData = base64_decode($imageData);

                if ($imageData !== false) {
                    $filename = 'guests/'.$ticketCode.'_'.time().'.'.$type;
                    Storage::disk('public')->put($filename, $imageData);
                    $photoPath = $filename;
                }
            }
        } elseif ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('guests', 'public');
        }

        $visit = GuestVisit::create([
            'ticket_code' => $ticketCode,
            'guest_name' => $validated['guest_name'],
            'institution' => $validated['institution'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'purpose' => $validated['purpose'],
            'department_id' => $validated['department_id'],
            'host_id' => $validated['host_id'] ?? null,
            'visit_date' => $validated['visit_date'],
            'scheduled_time' => $validated['scheduled_time'],
            'guest_count' => $validated['guest_count'],
            'vehicle_number' => $validated['vehicle_number'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'photo_path' => $photoPath,
            'status' => 'pending',
        ]);

        return redirect()->route('ticket.show', $visit->ticket_code)
            ->with('success', 'Registrasi kunjungan Anda berhasil dibuat! Simpan kode tiket berikut.');
    }
}
