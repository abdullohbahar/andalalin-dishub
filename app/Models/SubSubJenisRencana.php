<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubJenisRencana extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_jenis_rencana_id',
        'nama',
    ];
}
