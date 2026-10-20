<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Host;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminHostController extends Controller
{
    public function index()
    {
        $hosts = Host::with(['department', 'user'])->orderBy('name')->get();
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

        $email = $validated['email'] ?? (Str::slug($validated['name'], '.').'@pesat.sch.id');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $validated['name'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]
        );

        $validated['email'] = $email;
        $validated['user_id'] = $user->id;

        Host::create($validated);

        return back()->with('success', 'Data Akun Guru/Staf berhasil ditambahkan.');
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

        if (! empty($validated['email'])) {
            $user = User::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'password' => Hash::make('password'),
                    'role' => 'teacher',
                ]
            );
            $validated['user_id'] = $user->id;
        }

        $host->update($validated);

        return back()->with('success', 'Data Akun Guru/Staf berhasil diperbarui.');
    }

    public function destroy(Host $host)
    {
        $host->delete();

        return back()->with('success', 'Data Guru/Staf berhasil dihapus.');
    }
}
