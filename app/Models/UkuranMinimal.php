<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkuranMinimal extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_sub_jenis_rencana_id',
        'sub_jenis_rencana_id',
        'keterangan',
        'kategori',
        'tipe'
    ];
}
