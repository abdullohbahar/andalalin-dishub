<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengajuan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function belongsToUkuranMinimal(): BelongsTo
    {
        return $this->belongsTo(UkuranMinimal::class, 'ukuran_minimal_id', 'id');
    }

    public function belongsToJenisJalan(): BelongsTo
    {
        return $this->belongsTo(JenisJalan::class, 'jenis_jalan_id', 'id');
    }

    public function belongsToJenisRencana(): BelongsTo
    {
        return $this->belongsTo(JenisRencanaPembangunan::class, 'jenis_rencana_id', 'id');
    }

    public function belongsToSubJenisRencana(): BelongsTo
    {
        return $this->belongsTo(SubJenisRencanaPembangunan::class, 'sub_jenis_rencana_id', 'id');
    }

    public function belongsToSubSubJenisRencana(): BelongsTo
    {
        return $this->belongsTo(SubSubJenisRencana::class, 'sub_sub_jenis_rencana_id', 'id');
    }

    public function hasOneDataPemohon(): HasOne
    {
        return $this->hasOne(DataPemohon::class);
    }

    public function belongsToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function deadline(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y')
        );
    }
}
