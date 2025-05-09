<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateBeritaAcara extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function belongsToJenisRencanaPembangunan()
    {
        return $this->belongsTo(JenisRencanaPembangunan::class);
    }
}
