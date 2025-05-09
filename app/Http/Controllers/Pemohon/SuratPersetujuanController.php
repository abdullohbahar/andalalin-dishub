<?php

namespace App\Http\Controllers\Pemohon;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;

class SuratPersetujuanController extends Controller
{
    public function menunggu($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneSuratPersetujuan')->findorfail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuanID' => $pengajuanID,
            'pengajuan' => $pengajuan
        ];

        return view('pemohon.surat-persetujuan.menunggu-surat-persetujuan', $data);
    }

    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneSuratPersetujuan')->findorfail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuanID' => $pengajuanID,
            'pengajuan' => $pengajuan
        ];

        return view('pemohon.surat-persetujuan.index', $data);
    }

    public function selesai($pengajuanID)
    {
        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Selesai'
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Selesai'
        ]);

        Pengajuan::where('id', $pengajuanID)->update([
            'status' => 'Selesai'
        ]);

        return to_route('pemohon.pengajuan.selesai', $pengajuanID)->with('success', 'Terimakasih Telah Menyelesaikan Permohonan. Untuk Langkah Selanjutnya Harap Untuk Mendownload Laporan Dokumen Akhir');
    }
}
