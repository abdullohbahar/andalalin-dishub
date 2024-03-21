<?php

namespace App\Http\Controllers\Pemohon;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\SuratKesanggupan;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;
use App\Models\User;

class SuratKesanggupanPemohonController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneSuratKesanggupan')->findorfail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuanID' => $pengajuanID,
            'pengajuan' => $pengajuan
        ];

        return view('pemohon.surat-kesanggupan.index', $data);
    }

    public function storeNomorSurat(Request $request, $pengajuanID)
    {
        SuratKesanggupan::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'nomor_surat' => $request->nomor_surat,
        ]);

        return redirect()->back()->with('success', 'Berhasil menyimpan nomor surat. Harap lihat alur pengisian untuk langkah selanjutnya');
    }

    public function storeFileSurat(Request $request, $pengajuanID)
    {
        $request->validate([
            "file" => "required|mimes:pdf"
        ]);

        $pengajuan = Pengajuan::with('hasOneDataPemohon')->findorfail($pengajuanID);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . " - Surat Kesanggupan." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Surat Kesanggupan/'  . $pengajuan->user_id .  '/' . $pengajuan->hasOneDataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->storeAs('public/' . $location, $filename);

            SuratKesanggupan::where('pengajuan_id', $pengajuanID)->update([
                'file' => $filepath
            ]);
        }

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Menunggu Verifikasi Surat Kesanggupan'
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Verifikasi Surat Kesanggupan'
        ]);

        $this->kirimNotifikasiKeAdmin($pengajuanID);

        return to_route('pemohon.menungu.verifikasi', $pengajuanID)->with('success', 'Terimakasih Telah Mengirim Surat Kesanggupan');
    }

    public function kirimNotifikasiKeAdmin($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToUser.hasOneProfile', 'hasOneDataPemohon')->where('id', $pengajuanID)->first();

        $namaPemohon = $pengajuan->belongsToUser->hasOneProfile->nama;
        $namaProyek = $pengajuan->hasOneDataPemohon->nama_proyek;

        $admin = User::with('hasOneProfile')->where('role', 'admin')->first();
        $nomorHpAdmin = $admin->hasOneProfile->no_telepon;

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
                'target' => "$nomorHpAdmin", // nomer hp konsultan
                'message' => "Pemohon telah mengunggah surat pernyataan kesanggupan, dengan rincian data berikut:\nNama Pemohon: $namaPemohon\nNama Proyek: $namaProyek\nHarap lakukan persetujuan pada surat pernyataan tersebut.",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

    public function menungguVerifikasi($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneSuratKesanggupan')->findorfail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuanID' => $pengajuanID,
            'pengajuan' => $pengajuan
        ];

        return view('pemohon.surat-kesanggupan.menunggu-verifikasi', $data);
    }
}
