<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalTinajuanLapangan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

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
        JadwalTinajuanLapangan::where('id', $jadwalID)->update([
            'is_review' => true
        ]);

        return redirect()->back()->with('success', 'Terimakasih telah melakukan peninjauan lapangan');
    }
}
