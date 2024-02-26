<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
