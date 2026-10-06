<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_code',
        'guest_name',
        'institution',
        'phone',
        'email',
        'purpose',
        'department_id',
        'host_id',
        'visit_date',
        'scheduled_time',
        'guest_count',
        'photo_path',
        'vehicle_number',
        'notes',
        'status',
        'rejection_reason',
        'check_in_at',
        'check_out_at',
        'rating',
        'feedback_comment',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'check_in_at' => 'datetime',
        'check_out_at' => 'datetime',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(Host::class);
    }

    public static function generateTicketCode(): string
    {
        $prefix = 'JTT-'.date('Ymd').'-';
        $latest = static::where('ticket_code', 'LIKE', $prefix.'%')
            ->orderBy('id', 'desc')
            ->first();

        if (! $latest) {
            return $prefix.'0001';
        }

        $number = (int) substr($latest->ticket_code, -4);
        $next = str_pad($number + 1, 4, '0', STR_PAD_LEFT);

        return $prefix.$next;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'approved' => 'Disetujui',
            'checked_in' => 'Sedang Berkunjung',
            'checked_out' => 'Selesai Kunjungan',
            'rejected' => 'Ditolak',
            default => 'Unknown',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
            'approved' => 'bg-blue-100 text-blue-800 border-blue-300',
            'checked_in' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'checked_out' => 'bg-slate-100 text-slate-700 border-slate-300',
            'rejected' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-gray-100 text-gray-800 border-gray-300',
        };
    }
}
