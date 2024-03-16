<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function belongsToPengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function belongsToUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
