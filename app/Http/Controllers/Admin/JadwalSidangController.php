<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use Illuminate\Support\Str;
use App\Models\JadwalSidang;
use Illuminate\Http\Request;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;
use App\Models\RiwayatInputData;

class JadwalSidangController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with(
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
            'hasOneJadwalTinjauan',
            'hasOneJadwalSidang'
        )
            ->findOrFail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan
        ];

        return view('admin.pengajuan.jadwal-sidang.index', $data);
    }

    public function store(Request $request, $pengajuanID)
    {
        $request->validate([
            'jam' => 'required',
            'menit' => 'required',
            'tipe' => 'required',
            'tanggal' => 'required',
        ], [
            'jam.required' => 'Jam harus diisi',
            'menit.required' => 'Menit harus diisi',
            'tipe.required' => 'Tipe harus diisi',
            'tanggal.required' => 'Tanggal harus diisi'
        ]);

        if ($request->tipe == 'offline') {
            $request->validate([
                'alamat' => 'required'
            ], [
                'alamat.required' => 'Alamat harus diisi'
            ]);
        } else {
            $request->validate([
                'url' => 'required'
            ], [
                'url.required' => 'URL harus diisi'
            ]);
        }

        JadwalSidang::updateorcreate([
            'pengajuan_id' => $pengajuanID,
        ], [
            'jam' => "$request->jam:$request->menit",
            'tanggal' => $request->tanggal,
            'tipe' => $request->tipe,
            'url' => $request->url,
            'alamat' => $request->alamat
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $pengajuanID,
        ], [
            'step' => 'Sidang'
        ]);

        $this->kirimNotifikasiJadwalSidang($pengajuanID);

        // lanjut buat halaman telah melakukan sidang
        return to_route('admin.detail.jadwal.sidang', $pengajuanID)->with('success', 'Terimakasih telah membuat jadwal sidang. Harap lakukan sidang sesuai dengan jadwal yang telah dibuat');
    }

    public function kirimNotifikasiJadwalSidang($pengajuanID)
    {
        $pengajuan = Pengajuan::with(
            'belongsToJenisRencana',
            'belongsToUkuranMinimal',
            'belongsToJenisJalan',
            'belongsToSubJenisRencana',
            'belongsToSubSubJenisRencana',
            'hasOneDataPemohon.hasManyDokumenDataPemohon',
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
            'belongsToUser.hasOneProfile'
        )
            ->findorfail($pengajuanID);

        $nomorPemohon = $pengajuan->belongsToUser->hasOneProfile->no_telepon;
        $namaProyek = $pengajuan->hasOneDataPemohon->nama_proyek;
        $upperNamaProyek = Str::upper($namaProyek);

        $website = env("APP_URL");

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
                'target' => "$nomorPemohon", // nomer hp pemohon
                'message' => "Admin telah membuat jadwal sidang pada proyek $upperNamaProyek. Harap melakukan pengecekan pada website $website , untuk melihat jadwal sidang yang telah dibuat",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

    public function jadwalSidang($pengajuanID)
    {
        $pengajuan = Pengajuan::with(
            'hasOneDataPemohon',
            'belongsToUser.hasOneProfile',
            'hasOneJadwalSidang'
        )
            ->findorfail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan
        ];

        return view('admin.pengajuan.jadwal-sidang.show', $data);
    }

    public function telahMelakukanSidang($pengajuanID)
    {
        JadwalSidang::where('pengajuan_id', $pengajuanID)->update([
            'is_meeting' => true,
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $pengajuanID,
        ], [
            'step' => 'Berita Acara'
        ]);

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuanID,
        ], [
            'step' => 'Berita Acara'
        ]);

        return redirect()->back()->with('success', 'Terimakasih telah melakukan sidang. Harap mengisi berita acara di langkah berikutnya, harap mengisi berita acara sebelum 2x24 jam!');
    }
}
