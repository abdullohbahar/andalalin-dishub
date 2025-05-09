<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function hasManyDokumenDataPemohon()
    {
        return $this->hasMany(DokumenDataPemohon::class);
    }

    public function hasOneDokumenDataPemohon()
    {
        return $this->hasOne(DokumenDataPemohon::class);
    }

    protected function tanggalSuratPermohonan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y')
        );
    }
}
