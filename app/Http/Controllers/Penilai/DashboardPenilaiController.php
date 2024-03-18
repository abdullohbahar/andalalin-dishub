<?php

namespace App\Http\Controllers\Penilai;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\Pengajuan;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardPenilaiController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;

        $user = User::with('hasOneProfile')->findOrFail($userID);

        if ($user->hasOneProfile->no_ktp == '-' || $user->hasOneProfile->no_ktp == null) {
            return to_route('edit.profile', $userID)->with('notification', 'harap melengkapi profile terlebih dahulu');
        }


        $role = auth()->user()->role;

        if ($role == 'penilai1') {
            $column = 'is_penilai_1_approve';
        } else if ($role == 'penilai2') {
            $column = 'is_penilai_2_approve';
        } else if ($role == 'penilai3') {
            $column = 'is_penilai_3_approve';
        }

        $belumApprove = RiwayatInputData::with([
            'belongsToPengajuan.hasOneDataPemohon',
            'belongsToPengajuan.belongsToUser.hasOneProfile',
            'belongsToPengajuan.hasOneBeritaAcara'
        ])
            ->join('berita_acaras', 'riwayat_input_data.pengajuan_id', '=', 'berita_acaras.pengajuan_id')
            ->where('berita_acaras.' . $column . '', '!=', 1)
            ->where('step', 'Menunggu Verifikasi Penilai')
            ->orderBy('riwayat_input_data.created_at', 'asc')
            ->get();

        $sudahApprove = RiwayatInputData::with([
            'belongsToPengajuan.hasOneDataPemohon',
            'belongsToPengajuan.belongsToUser.hasOneProfile',
            'belongsToPengajuan.hasOneBeritaAcara'
        ])
            ->join('berita_acaras', 'riwayat_input_data.pengajuan_id', '=', 'berita_acaras.pengajuan_id')
            ->where('berita_acaras.' . $column . '', '!=', 0)
            ->orderBy('riwayat_input_data.created_at', 'asc')
            ->get();

        $data = [
            'active' => 'dashboard',
            'belumApprove' => $belumApprove,
            'sudahApprove' => $sudahApprove,
        ];

        return view('penilai.dashboard.index', $data);
    }

    public function showBeritaAcara($pengajuanID)
    {
        $pengajuan = Pengajuan::findorfail($pengajuanID);

        $data = [
            'active' => 'dashboard',
            'pengajuan' => $pengajuan,
            'pengajuanID' => $pengajuanID
        ];

        return view('penilai.dashboard.show-berita-acara', $data);
    }

    public function approve($pengajuanID)
    {
        $role = auth()->user()->role;


        $updateData = [];

        switch ($role) {
            case 'penilai1':
                $updateData['is_penilai_1_approve'] = true;
                break;
            case 'penilai2':
                $updateData['is_penilai_2_approve'] = true;
                break;
            case 'penilai3':
                $updateData['is_penilai_3_approve'] = true;
                break;
        }

        if (!empty($updateData)) {
            BeritaAcara::where('pengajuan_id', $pengajuanID)->update($updateData);
        }

        $semuaApprove = BeritaAcara::where('pengajuan_id', $pengajuanID)
            ->where('is_penilai_1_approve', true)
            ->where('is_penilai_2_approve', true)
            ->where('is_penilai_3_approve', true)
            ->exists();

        if ($semuaApprove) {
            RiwayatInputData::updateorcreate([
                'pengajuan_id' => $pengajuanID
            ], [
                'step' => 'Unduh Berita Acara'
            ]);

            RiwayatVerifikasi::updateorcreate([
                'pengajuan_id' => $pengajuanID
            ], [
                'step' => 'Unduh Berita Acara'
            ]);
        }

        return to_route('penilai.dashboard')->with('success', 'Berhasil melakukan approve');
    }
}
