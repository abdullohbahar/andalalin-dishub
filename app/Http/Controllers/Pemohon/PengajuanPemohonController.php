<?php

namespace App\Http\Controllers\Pemohon;

use Carbon\Carbon;
use App\Models\Pengajuan;
use App\Models\JenisJalan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JenisRencanaPembangunan;
use App\Models\RiwayatInputData;

class PengajuanPemohonController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;

        $pengajuans = Pengajuan::with('belongsToJenisRencana', 'hasOneDataPemohon')->where('user_id', $userID)->get();

        $data = [
            'active' => 'pengajuan',
            'pengajuans' => $pengajuans
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

    public function createTipeAndalalin()
    {
        $userID = auth()->user()->id;

        $pengajuan = Pengajuan::create([
            'user_id' => $userID,
            'jenis_pengajuan' => 'andalalin',
            'status' => 'input data belum selesai'
        ]);

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuan->id
        ], [
            'step' => 'Buat Pengajuan Baru'
        ]);

        return to_route('pemohon.create.pengajuan.andalalin', $pengajuan->id);
    }
}
