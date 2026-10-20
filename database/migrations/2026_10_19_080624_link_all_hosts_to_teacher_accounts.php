<?php

use App\Models\Department;
use App\Models\Host;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hosts = Host::all();

        foreach ($hosts as $host) {
            $email = $host->email;
            if (empty($email)) {
                $email = Str::slug($host->name, '.').'@pesat.sch.id';
                $host->email = $email;
            }

            // Find or create User teacher account
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $host->name,
                    'password' => Hash::make('password'),
                    'role' => 'teacher',
                ]
            );

            if ($user->role !== 'admin' && $user->role !== 'teacher') {
                $user->role = 'teacher';
                $user->save();
            }

            $host->user_id = $user->id;
            $host->save();
        }

        // Also ensure any teacher user accounts without a host profile get a host created
        $teachersWithoutHost = User::where('role', 'teacher')->doesntHave('host')->get();
        $defaultDept = Department::first();

        foreach ($teachersWithoutHost as $teacher) {
            Host::create([
                'user_id' => $teacher->id,
                'department_id' => $defaultDept?->id ?? 1,
                'name' => $teacher->name,
                'position' => 'Guru / Pengajar',
                'email' => $teacher->email,
                'status' => 'available',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No destructive reverse needed
    }
};
