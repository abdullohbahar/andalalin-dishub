<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penolakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_id',
        'parent_id',
        'tipe',
        'alasan',
        'is_revisied',
    ];
}
