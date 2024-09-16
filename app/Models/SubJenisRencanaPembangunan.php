<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SubJenisRencanaPembangunan extends Model
{
    use HasFactory;

    protected $table = 'sub_jenis_rencanas';

    protected $fillable = [
        'jenis_rencana_id',
        'nama',
    ];

    public function hasOneUkuranMinimal(): HasOne
    {
        return $this->hasOne(UkuranMinimal::class, 'sub_jenis_rencana_id', 'id');
    }

    public function hasManyUkuranMinimal(): HasMany
    {
        return $this->hasMany(UkuranMinimal::class, 'sub_jenis_rencana_id', 'id');
    }

    public function hasOneSubSubJenis(): HasOne
    {
        return $this->hasOne(SubSubJenisRencana::class, 'sub_jenis_rencana_id', 'id');
    }

    public function hasManySubSubJenis(): HasMany
    {
        return $this->hasMany(SubSubJenisRencana::class, 'sub_jenis_rencana_id', 'id');
    }
}
