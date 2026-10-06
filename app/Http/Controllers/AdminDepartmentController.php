<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class AdminDepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount(['hosts', 'guestVisits'])->orderBy('name')->get();

        return view('admin.departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments,code',
            'description' => 'nullable|string',
        ]);

        Department::create($validated);

        return back()->with('success', 'Departemen baru berhasil ditambahkan.');
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments,code,'.$department->id,
            'description' => 'nullable|string',
        ]);

        $department->update($validated);

        return back()->with('success', 'Data Departemen berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        if ($department->hosts()->count() > 0 || $department->guestVisits()->count() > 0) {
            return back()->with('error', 'Departemen tidak dapat dihapus karena memiliki relasi staf atau data kunjungan.');
        }

        $department->delete();

        return back()->with('success', 'Departemen berhasil dihapus.');
    }
}
