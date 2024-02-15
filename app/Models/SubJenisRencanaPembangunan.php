<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubJenisRencanaPembangunan extends Model
{
    use HasFactory;

    protected $table = 'sub_jenis_rencanas';

    protected $fillable = [
        'jenis_rencana_id',
        'nama',
    ];
}
