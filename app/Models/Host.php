<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Host extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'nip_nik',
        'name',
        'position',
        'email',
        'phone',
        'status',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function guestVisits(): HasMany
    {
        return $this->hasMany(GuestVisit::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'available' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'busy' => 'bg-amber-100 text-amber-800 border-amber-300',
            'away' => 'bg-blue-100 text-blue-800 border-blue-300',
            'leave' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'Ada di Tempat',
            'busy' => 'Sedang Sibuk',
            'away' => 'Dinas Luar',
            'leave' => 'Cuti / Izin',
            default => 'Tidak Diketahui',
        };
    }
}
