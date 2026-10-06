<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function hosts(): HasMany
    {
        return $this->hasMany(Host::class);
    }

    public function guestVisits(): HasMany
    {
        return $this->hasMany(GuestVisit::class);
    }
}
