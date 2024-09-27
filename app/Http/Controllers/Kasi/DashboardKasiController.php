<?php

namespace App\Http\Controllers\Kasi;

use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\SuratKesanggupan;
use App\Models\SuratPersetujuan;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailNotificationController;

class DashboardKasiController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;

        $user = User::with('hasOneProfile')->findOrFail($userID);

        if ($user->hasOneProfile->no_ktp == '-' || $user->hasOneProfile->no_ktp == null) {
            return to_route('edit.profile', $userID)->with('notification', 'harap melengkapi profile terlebih dahulu');
        }

        $belumApprove = SuratPersetujuan::with([
            'belongsToPengajuan.hasOneDataPemohon',
            'belongsToPengajuan.belongsToUser.hasOneProfile',
        ])->where('is_kasi_approve', 0)
            ->whereNotNull('file')
            ->whereNotNull('pengajuan_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $sudahApprove = SuratPersetujuan::with([
            'belongsToPengajuan.hasOneDataPemohon',
            'belongsToPengajuan.hasOneSuratPersetujuan',
            'belongsToPengajuan.belongsToUser.hasOneProfile',
        ])->where('is_kasi_approve', 1)
            ->whereNotNull('file')
            ->whereNotNull('pengajuan_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $data = [
            'active' => 'dashboard',
            'belumApprove' => $belumApprove,
            'sudahApprove' => $sudahApprove,
        ];

        return view('kasi.dashboard.index', $data);
    }

    public function showSuratPersetujuan($pengajuanID)
    {
        $pengajuan = Pengajuan::findorfail($pengajuanID);

        $data = [
            'active' => 'dashboard',
            'pengajuan' => $pengajuan,
            'pengajuanID' => $pengajuanID
        ];

        return view('kasi.dashboard.show-surat-persetujuan', $data);
    }


    public function approve($pengajuanID)
    {
        SuratPersetujuan::where('pengajuan_id', $pengajuanID)->update([
            'is_kasi_approve' => true
        ]);

        $this->kirimNotifikasiKeKabid($pengajuanID);

        return to_route('kasi.dashboard')->with('success', 'Berhasil melakukan approve');
    }

    public function kirimNotifikasiKeKabid($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToUser.hasOneProfile', 'hasOneDataPemohon')->findorfail($pengajuanID);

        $user = User::with('hasOneProfile')->where('role', 'kabid')->first();

        $nomorHpKabid = $user?->hasOneProfile?->no_telepon ?? '';

        $namaProyek = $pengajuan->hasOneDataPemohon?->nama_proyek;

        $roles = ['kabid'];
        $users = User::with('hasOneProfile')->whereIn('role', $roles)->get();

        $notification = new EmailNotificationController();
        foreach ($users as $user) {
            $notification->sendEmail($user->id, "Kasi telah melakukan approve Surat Persetujuan pada proyek $namaProyek.\nHarap melakukan persetujuan pada surat persetujuan tersebut");
        }

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://api.fonnte.com/send',
        //     CURLOPT_SSL_VERIFYPEER => FALSE,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => array(
        //         'target' => "$nomorHpKabid", // nomer hp pemohon
        //         'message' => "Kasi telah melakukan approve Surat Persetujuan pada proyek $namaProyek.\nHarap melakukan persetujuan pada surat persetujuan tersebut!",
        //         'countryCode' => '62', //optional
        //     ),
        //     CURLOPT_HTTPHEADER => array(
        //         'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
    }
}
