<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubSubJenisRencana extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_jenis_rencana_id',
        'nama',
    ];

    public function hasOneUkuranMinimal(): HasOne
    {
        return $this->hasOne(UkuranMinimal::class, 'sub_jenis_rencana_id', 'id');
    }

    public function hasOneTemplateBeritaAcara(): HasOne
    {
        return $this->hasOne(TemplateBeritaAcara::class, 'parent_id', 'id')->where('tipe', 'subsub');
    }
}
