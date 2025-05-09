<?php

namespace App\Http\Controllers\Konsultan;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengajuanAndalalinKonsultanController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;

        $pengajuans = Pengajuan::with(
            'hasOneDataPemohon',
            'belongsToUser.hasOneProfile',
            'belongsToJenisRencana',
            'hasOneRiwayatVerifikasi',
            'hasOneRiwayatInputData'
        )->where('konsultan_id', $userID)
            ->whereHas('hasOneDataPemohon', function ($query) {
                $query->whereNotNull('nama_proyek')->where('nama_proyek', '!=', '');
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = [
            'active' => 'pengajuan',
            'pengajuans' => $pengajuans
        ];

        return view('konsultan.pengajuan.index', $data);
    }
}
