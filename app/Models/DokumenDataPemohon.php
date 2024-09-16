<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected function dokumen(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/' . $value)
        );
    }
}
