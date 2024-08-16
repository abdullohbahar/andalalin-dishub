<?php

namespace App\Http\Controllers\Kadis;

use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\SuratPersetujuan;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;

class DashboardKadisController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;

        $user = User::with('hasOneProfile')->findOrFail($userID);

        if ($user->hasOneProfile?->no_ktp == '-' || $user->hasOneProfile?->no_ktp == null) {
            return to_route('edit.profile', $userID)->with('notification', 'harap melengkapi profile terlebih dahulu');
        }

        $belumApprove = SuratPersetujuan::with([
            'belongsToPengajuan.hasOneDataPemohon',
            'belongsToPengajuan.belongsToUser.hasOneProfile',
        ])
            ->where('is_kabid_approve', 1)
            ->where('is_kadis_approve', 0)
            ->whereNotNull('file')
            ->whereNotNull('pengajuan_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $sudahApprove = SuratPersetujuan::with([
            'belongsToPengajuan.hasOneDataPemohon',
            'belongsToPengajuan.belongsToUser.hasOneProfile',
            'belongsToPengajuan.hasOneSuratPersetujuan'
        ])->where('is_kadis_approve', 1)
            ->whereNotNull('file')
            ->whereNotNull('pengajuan_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $data = [
            'active' => 'dashboard',
            'belumApprove' => $belumApprove,
            'sudahApprove' => $sudahApprove,
        ];

        return view('kadis.dashboard.index', $data);
    }

    public function showSuratPersetujuan($pengajuanID)
    {
        $pengajuan = Pengajuan::findorfail($pengajuanID);

        $data = [
            'active' => 'dashboard',
            'pengajuan' => $pengajuan,
            'pengajuanID' => $pengajuanID
        ];

        return view('kadis.dashboard.show-surat-persetujuan', $data);
    }


    public function approve($pengajuanID)
    {
        SuratPersetujuan::where('pengajuan_id', $pengajuanID)->update([
            'is_kadis_approve' => true
        ]);

        $this->kirimNotifikasiKePemohonKonsultan($pengajuanID);
        $this->kirimNotifikasiKeSemua($pengajuanID);

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Surat Persetujuan'
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Surat Persetujuan'
        ]);

        return to_route('kadis.dashboard')->with('success', 'Berhasil melakukan approve');
    }


    public function kirimNotifikasiKePemohonKonsultan($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToUser.hasOneProfile', 'hasOneDataPemohon', 'belongsToConsultan.hasOneProfile')->findorfail($pengajuanID);

        $nomorHpPemohon = $pengajuan->belongsToUser?->hasOneProfile?->no_telepon;
        $nomorHpKonsultan = $pengajuan->belongsToConsultan?->hasOneProfile?->no_telepon;

        $namaProyek = $pengajuan->hasOneDataPemohon?->nama_proyek;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => "$nomorHpPemohon, $nomorHpKonsultan", // nomer hp pemohon
                'message' => "Pengajuan proyek $namaProyek telah selesai.\nHarap mengunduh surat persetujuan!",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

    public function kirimNotifikasiKeSemua($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToUser.hasOneProfile', 'hasOneDataPemohon', 'belongsToConsultan.hasOneProfile')->findorfail($pengajuanID);
        $nomorHpPemohon = $pengajuan->belongsToUser?->hasOneProfile?->no_telepon;

        $kasi = User::with('hasOneProfile')->where('role', 'kasi')->first();
        $nomorHpKasi = $kasi?->hasOneProfile?->no_telepon ?? '';

        $kabid = User::with('hasOneProfile')->where('role', 'kabid')->first();
        $nomorHpKabid = $kabid?->hasOneProfile?->no_telepon ?? '';

        $kadis = User::with('hasOneProfile')->where('role', 'kadis')->first();
        $nomorHPKadis = $kadis?->hasOneProfile?->no_telepon ?? '';

        $namaProyek = $pengajuan->hasOneDataPemohon?->nama_proyek;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => "$nomorHpPemohon, $nomorHpKasi, $nomorHPKadis, $nomorHpKabid", // nomer hp
                'message' => "Pengajuan proyek $namaProyek telah selesai.\nHarap mengunduh Laporan Dokumen Akhir!",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }
}
