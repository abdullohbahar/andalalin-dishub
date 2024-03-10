<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;
use App\Models\JadwalTinajuanLapangan;
use App\Models\RiwayatInputData;

class TinjauanLapanganController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with(
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
            'hasOneJadwalTinjauan'
        )
            ->findOrFail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan
        ];

        return view('admin.pengajuan.tinjauan-lapangan.index', $data);
    }

    public function telahMelakukanTinjauan($jadwalID)
    {
        $jadwal = JadwalTinajuanLapangan::findorfail($jadwalID);

        JadwalTinajuanLapangan::where('id', $jadwalID)->update([
            'is_review' => true
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $jadwal->pengajuan_id,
        ], [
            'step' => 'Buat Jadwal Sidang'
        ]);

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $jadwal->pengajuan_id,
        ], [
            'step' => 'Sidang'
        ]);

        return redirect()->back()->with('success', 'Terimakasih telah melakukan peninjauan lapangan');
    }
}
