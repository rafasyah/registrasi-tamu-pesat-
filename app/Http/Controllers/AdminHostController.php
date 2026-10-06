<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Host;
use Illuminate\Http\Request;

class AdminHostController extends Controller
{
    public function index()
    {
        $hosts = Host::with('department')->orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.hosts.index', compact('hosts', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|string|max:255',
            'nip_nik' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'status' => 'required|in:available,busy,away,leave',
        ]);

        Host::create($validated);

        return back()->with('success', 'Data Guru/Staf berhasil ditambahkan.');
    }

    public function update(Request $request, Host $host)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|string|max:255',
            'nip_nik' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'status' => 'required|in:available,busy,away,leave',
        ]);

        $host->update($validated);

        return back()->with('success', 'Data Guru/Staf berhasil diperbarui.');
    }

    public function destroy(Host $host)
    {
        $host->delete();

        return back()->with('success', 'Data Guru/Staf berhasil dihapus.');
    }
}
