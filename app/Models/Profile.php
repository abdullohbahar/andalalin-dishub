<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected function fileKtp(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/file-uploads/ktp/' . $value)
        );
    }

    protected function fileSertifikatAndalalin(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/file-uploads/sertifikat-andalalin/' . $value)
        );
    }

    protected function fileCv(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/file-uploads/cv/' . $value)
        );
    }

    protected function fileSkKepalaDinas(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/file-uploads/sk-kepala-dinas/' . $value)
        );
    }

    protected function fileSertifikat(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/file-uploads/sertifikat/' . $value)
        );
    }

    protected function fileIjazahTerakhir(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/file-uploads/ijazah-terakhir/' . $value)
        );
    }
}
