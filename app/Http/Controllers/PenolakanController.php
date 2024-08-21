<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengajuan;
use App\Models\Penolakan;
use Illuminate\Http\Request;

class PenolakanController extends Controller
{
    public function tolak(Request $request)
    {
        Penolakan::create([
            'pengajuan_id' => $request->pengajuan_id,
            'parent_id' => $request->parent_id,
            'tipe' => $request->tipe,
            'alasan' => $request->alasan
        ]);

        if ($request->tipe == 'berita acara') {
            $url = 'penilai.dashboard';
            $admin = User::with('hasOneProfile')->where('role', 'admin')->first()->no_telepon;
            $this->kirimNotifikasi($request->pengajuan_id, $admin, $request->tipe, $request->alasan);
        }

        return to_route($url)->with('success', 'Berhasil melakukan penolakan');
    }

    public function kirimNotifikasi($pengajuanID, $nomorHp, $tipe, $alasan)
    {
        $pengajuan = Pengajuan::with('belongsToUser.hasOneProfile', 'hasOneDataPemohon')->findorfail($pengajuanID);

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
                'target' => "$nomorHp", // nomer hp pemohon
                'message' => "Penilai melakukan penolakan $tipe proyek $namaProyek. Harap untuk merevisi $tipe tersebut!\nDengan alasan:\n$alasan",
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
