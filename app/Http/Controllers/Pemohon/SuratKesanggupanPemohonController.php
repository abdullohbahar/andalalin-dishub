<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuratKesanggupanPemohonController extends Controller
{
    public function index($pengajuanID)
    {
        $data = [
            'active' => 'pengajuan',
            'pengajuanID' => $pengajuanID
        ];

        return view('pemohon.surat-kesanggupan.index', $data);
    }
}
