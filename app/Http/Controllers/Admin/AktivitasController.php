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
            return to_route('admin.berita.acara', $pengajuanID);
        } else if ($riwayat == 'Menunggu Verifikasi Penilai') {
            return to_route('admin.menunggu.verifikasi.penilai', $pengajuanID);
        } else if ($riwayat == 'Menunggu Verifikasi Penilai') {
            return to_route('admin.menunggu.verifikasi.penilai', $pengajuanID);
        } else if ($riwayat == 'Menunggu Surat Kesanggupan') {
            return to_route('admin.menunggu.surat.kesanggupan', $pengajuanID);
        } else if ($riwayat == 'Verifikasi Surat Kesanggupan') {
            return to_route('admin.surat.kesanggupan', $pengajuanID);
        } else if ($riwayat == 'Surat Persetujuan') {
            return to_route('admin.surat.persetujuan', $pengajuanID);
        } else if ($riwayat == 'Selesai') {
            return to_route('admin.pengajuan.selesai', $pengajuanID);
        }
    }
}
