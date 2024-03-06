<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class AktivitasController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneRiwayatVerifikasi')->findOrFail($pengajuanID);

        $riwayat = $pengajuan->hasOneRiwayatVerifikasi->step ?? null;

        if ($riwayat == null || $riwayat == 'verifikasi pengajuan') {
            return to_route('admin.pengajuan.show', $pengajuanID);
        } else if ($riwayat == 'Buat Jadwal Tinjauan Lapangan') {
            return to_route('admin.buat.jadwal', $pengajuanID);
        } else if ($riwayat == 'Tinjauan Lapangan') {
            return to_route('admin.tinjauan.lapangan', $pengajuanID);
        } else if ($riwayat == 'Buat Jadwal Sidang') {
            return to_route('admin.jadwal.sidang', $pengajuanID);
        } else if ($riwayat == 'Sidang') {
            return to_route('admin.detail.jadwal.sidang', $pengajuanID);
        } else if ($riwayat == 'Berita Acara') {
            return "berita acara";
        }
    }
}
