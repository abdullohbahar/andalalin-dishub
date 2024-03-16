<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisRencanaPembangunan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama'
    ];

    public function hasManySubJenisRencana()
    {
        return $this->hasMany(SubJenisRencanaPembangunan::class, 'jenis_rencana_id', 'id');
    }

    public function hasOneTemplateBeritaAcara()
    {
        return $this->hasOne(TemplateBeritaAcara::class, 'jenis_rencana_id', 'id');
    }
}
