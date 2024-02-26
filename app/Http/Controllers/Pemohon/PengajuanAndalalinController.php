<?php

namespace App\Http\Controllers\Pemohon;

use App\Models\Pengajuan;
use App\Models\JenisJalan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JenisRencanaPembangunan;
use App\Models\User;

class PengajuanAndalalinController extends Controller
{
    public function createAndalalin($pengajuanID)
    {
        $pengajuan = Pengajuan::findorfail($pengajuanID);
        $jenisJalans = JenisJalan::get();
        $jenisRencanas = JenisRencanaPembangunan::orderBy('nama', 'asc')->get();

        $data = [
            'active' => 'pengajuan',
            'tipe' => 'andalalin',
            'jenisRencanas' => $jenisRencanas,
            'jenisJalans' => $jenisJalans,
            'pengajuan' => $pengajuan
        ];

        return view('pemohon.pengajuan.andalalin.create-andalalin', $data);
    }

    public function updateAndalalin(Request $request, $pengajuanID)
    {
        $userID = auth()->user()->id;

        $data = [
            'user_id' => $userID,
            'jenis_jalan_id' => $request->jenis_jalan_id,
            'jenis_rencana_id' => $request->jenis_rencana_id,
            'sub_jenis_rencana_id' => $request->sub_jenis_rencana_id,
            'ukuran_minimal_id' => $request->ukuran_minimal_id,
        ];

        if ($request->has('sub_sub_jenis_rencana_id')) {
            $data['sub_sub_jenis_rencana_id'] = $request->sub_sub_jenis_rencana_id;
        }

        $pengajuan = Pengajuan::where('id', $pengajuanID)->update($data);

        return to_route('pemohon.pilih.konsultan.pengajuan.andalalin', $pengajuanID);
    }

    public function pilihKonsultan($pengajuanID)
    {
        $userID = auth()->user()->id;
        $konsultans = User::with('hasOneProfile')
            // ->where('role', 'konsultan')
            ->get();

        $pengajuan = Pengajuan::with('belongsToUkuranMinimal', 'belongsToJenisJalan', 'belongsToJenisRencana', 'belongsToSubJenisRencana', 'belongsToSubSubJenisRencana')
            ->where('user_id', $userID)
            ->where('id', $pengajuanID)
            ->first();

        if (stripos($pengajuan->belongsToUkuranMinimal->kategori, 'rendah')) {
            $klasifikasi = 'rendah';
        } else {
            $klasifikasi = 'tinggi';
        }

        $user = User::with('hasOneProfile')->findorfail($userID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan,
            'user' => $user,
            'klasifikasi' => $klasifikasi,
            'konsultans' => $konsultans
        ];

        return view('pemohon.pengajuan.andalalin.pilih-konsultan', $data);
    }

    public function storeDataPemohon(Request $request)
    {
    }
}
