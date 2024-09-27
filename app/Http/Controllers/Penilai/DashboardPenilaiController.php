<?php

namespace App\Http\Controllers\Penilai;

use App\Models\User;
use App\Models\Pengajuan;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailNotificationController;

class DashboardPenilaiController extends Controller
{
    // Todo membuat status penolakan di admin
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
            'belongsToPengajuan.hasOneBeritaAcara',
            'belongsToPengajuan.hasOnePenolakan'
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
        $pengajuan = Pengajuan::with('hasOneBeritaAcara', 'hasOnePenolakan')->findorfail($pengajuanID);

        if ($pengajuan?->hasOnePenolakan) {
            if (!$pengajuan?->hasOnePenolakan?->is_revisied) {
                return redirect()->back();
            }
        }

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
                'step' => 'Menunggu Surat Kesanggupan'
            ]);

            $this->kirimNotifikasiKePemohon($pengajuanID);
        }

        return to_route('penilai.dashboard')->with('success', 'Berhasil melakukan approve');
    }

    public function kirimNotifikasiKePemohon($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToUser.hasOneProfile', 'hasOneDataPemohon')->findorfail($pengajuanID);

        $nomorHpPemohon = $pengajuan->belongsToUser->hasOneProfile->no_telepon;
        $namaProyek = $pengajuan->hasOneDataPemohon?->nama_proyek;

        $notification = new EmailNotificationController();
        $notification->sendEmail($pengajuan->user_id, "Penilai telah melakukan approve berita acara proyek $namaProyek. Harap untuk mengakses website kembali dan melanjutkan langkah selanjutnya!");

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
        //         'target' => "$nomorHpPemohon", // nomer hp pemohon
        //         'message' => "Penilai telah melakukan approve berita acara proyek $namaProyek. Harap untuk mengakses website kembali dan melanjutkan langkah selanjutnya!",
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
