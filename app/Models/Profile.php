<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'nama',
        'no_ktp',
        'alamat',
        'no_telepon',
        'no_sertifikat',
        'masa_berlaku_sertifikat',
        'tingkatan',
        'sekolah_terakhir',
        'file_ktp',
        'file_sertifikat_andalalin',
        'file_cv',
        'file_sk_kepala_dinas',
        'file_sertifikat',
        'file_ijazah_terakhir',
    ];
}
