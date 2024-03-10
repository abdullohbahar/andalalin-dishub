<?php

namespace App\Http\Controllers\Konsultan;

use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardKonsultan extends Controller
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

        $pengajuanDitolak = $pengajuan->with('hasOneDataPemohon', 'belongsToUser', 'belongsToJenisRencana')->where('konsultan_id', $userID)->where('status', 'ditolak')->orderBy('updated_at', 'asc')->get();
        $pengajuanDisetujui = $pengajuan->with('hasOneDataPemohon', 'belongsToUser', 'belongsToJenisRencana')->where('konsultan_id', $userID)->where('status', 'disetujui')->orderBy('updated_at', 'asc')->get();
        $pengajuanPerluRevisi = $pengajuan->with('hasOneDataPemohon', 'belongsToUser', 'belongsToJenisRencana')->where('konsultan_id', $userID)->where('status', 'revisi')->orderBy('updated_at', 'asc')->get();
        $pengajuanBaru = $pengajuan->with('hasOneDataPemohon', 'belongsToUser.hasOneProfile', 'belongsToJenisRencana', 'hasOneRiwayatVerifikasi', 'hasOneRiwayatInputData')->where('konsultan_id', $userID)->orderBy('updated_at', 'asc')->get();

        $data = [
            'active' => 'dashboard',
            'hasProfile' => $hasProfile,
            'pengajuanDisetujui' => $pengajuanDisetujui,
            'pengajuanDitolak' => $pengajuanDitolak,
            'pengajuanPerluRevisi' => $pengajuanPerluRevisi,
            'pengajuanBaru' => $pengajuanBaru
        ];

        return view('konsultan.dashboard.index', $data);
    }
}
