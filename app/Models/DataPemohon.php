<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataPemohon extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function belongsToPengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function belongsToUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function belongsToConsultan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'konsultan_id', 'id');
    }
}
