<?php

namespace App\Http\Controllers\Pemohon;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengajuan;

class DashboardPemohonController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;

        $user = User::with('hasOneProfile')->where('id', $userID)->first();

        if ($user->hasOneProfile == null) {
            $hasProfile = false;
        } else {
            $hasProfile = true;
        }

        $pengajuan = new Pengajuan();

        $pengajuanDitolak = $pengajuan->with('hasOneDataPemohon', 'belongsToJenisRencana')->where('user_id', $userID)->where('status', 'ditolak')->orderBy('updated_at', 'asc')->get();
        $pengajuanDisetujui = $pengajuan->with('hasOneDataPemohon', 'belongsToJenisRencana')->where('user_id', $userID)->where('status', 'disetujui')->orderBy('updated_at', 'asc')->get();
        $pengajuanPerluRevisi = $pengajuan->with('hasOneDataPemohon', 'belongsToJenisRencana')->where('user_id', $userID)->where('status', 'revisi')->orderBy('updated_at', 'asc')->get();

        $data = [
            'active' => 'dashboard',
            'hasProfile' => $hasProfile,
            'pengajuanDisetujui' => $pengajuanDisetujui,
            'pengajuanDitolak' => $pengajuanDitolak,
            'pengajuanPerluRevisi' => $pengajuanPerluRevisi
        ];

        return view('pemohon.dashboard.index', $data);
    }
}
