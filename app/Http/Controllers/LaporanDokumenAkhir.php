<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SuratPersetujuan;
use App\Models\Pengajuan;

class LaporanDokumenAkhir extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneSuratKesanggupan')->findOrFail($pengajuanID);

        $data = [
            'active' => 'dashboard',
            'pengajuan' => $pengajuan
        ];

        return view('laporan-dokumen-akhir.index', $data);
    }
}
