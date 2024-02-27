<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenDataPemohon extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function belongsToDataPemohon(): BelongsTo
    {
        return $this->belongsTo(DataPemohon::class);
    }

    public function belongsToUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
