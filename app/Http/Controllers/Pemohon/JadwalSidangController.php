<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class JadwalSidangController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with(
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
            'hasOneJadwalTinjauan',
            'hasOneJadwalSidang'
        )
            ->findOrFail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan
        ];

        return view('pemohon.pengajuan.andalalin.show-jadwal-sidang', $data);
    }
}
