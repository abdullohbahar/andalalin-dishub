<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratKesanggupan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function belongsToPengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'id');
    }

    protected function file(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/' . $value)
        );
    }
}
