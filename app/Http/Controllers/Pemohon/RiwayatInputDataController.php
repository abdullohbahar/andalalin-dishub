<?php

namespace App\Http\Controllers\Pemohon;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiwayatInputDataController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneRiwayatInputData', 'hasOneDataPemohon', 'hasOneRiwayatVerifikasi')->findOrFail($pengajuanID);

        $riwayat = $pengajuan->hasOneRiwayatInputData->step ?? null;

        if ($riwayat == null || $riwayat == 'buat pengajuan baru') {
            return to_route('pemohon.create.pengajuan.andalalin', $pengajuanID);
        } else if ($riwayat == 'Input Data Permohonan Dan Data Konsultan') {
            return to_route('pemohon.pilih.konsultan.pengajuan.andalalin', $pengajuanID);
        } else if ($riwayat == 'Upload Dokumen Permohonan') {
            return to_route('pemohon.upload.dokumen.pemohon', $pengajuan->hasOneDataPemohon->id);
        } else if ($riwayat == 'Menunggu Verifikasi Data') {
            return to_route('pemohon.menunggu.verifikasi.data', $pengajuanID);
        } else if ($riwayat == 'Jadwal Tinjauan Lapangan' || $pengajuan->hasOneRiwayatVerifikasi == 'Buat Jadwal Sidang') {
            return to_route('pemohon.jadwal.tinjauan.lapangan', $pengajuanID);
        } else if ($riwayat == 'Sidang') {
            return to_route('pemohon.jadwal.sidang', $pengajuanID);
        } else if ($riwayat == 'Berita Acara') {
            return to_route('pemohon.berita.acara', $pengajuanID);
        } else if ($riwayat == 'Menunggu Verifikasi Penilai') {
            return to_route('pemohon.menunggu.verifikasi.penilai', $pengajuanID);
        }
    }
}
