<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\JenisJalan;
use App\Models\JenisRencanaPembangunan;
use Illuminate\Http\Request;

class PengajuanPemohonController extends Controller
{
    public function index()
    {

        $data = [
            'active' => 'pengajuan',
        ];

        return view('pemohon.pengajuan.index', $data);
    }

    public function pilihTipe()
    {
        $data = [
            'active' => 'pengajuan'
        ];

        return view('pemohon.pengajuan.pilih-tipe', $data);
    }

    public function createAndalalin()
    {
        $jenisJalans = JenisJalan::get();
        $jenisRencanas = JenisRencanaPembangunan::orderBy('nama', 'asc')->get();

        $data = [
            'active' => 'pengajuan',
            'tipe' => 'andalalin',
            'jenisRencanas' => $jenisRencanas,
            'jenisJalans' => $jenisJalans
        ];

        return view('pemohon.pengajuan.create-andalalin', $data);
    }
}
