<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SuratPersetujuan;

class LaporanDokumenAkhir extends Controller
{
    public function index($pengajuanID)
    {
        $data = [
            'active' => 'dashboard',
        ];

        return view('laporan-dokumen-akhir.index', $data);
    }
}
