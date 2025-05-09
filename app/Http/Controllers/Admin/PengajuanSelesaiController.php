<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengajuanSelesaiController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneSuratKesanggupan')->findOrFail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan
        ];

        return view('admin.pengajuan.pengajuan-selesai.index', $data);
    }
}
