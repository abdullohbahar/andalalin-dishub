<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\SuratKesanggupan;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;

class SuratKesanggupanAdminController extends Controller
{
    public function menungguSuratKesanggupan($pengajuanID)
    {
        $data = [
            'active' => 'pengajuan'
        ];

        return view('admin.pengajuan.surat-kesanggupan.menunggu-surat-kesanggupan', $data);
    }

    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneSuratKesanggupan')->findOrFail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan
        ];

        return view('admin.pengajuan.surat-kesanggupan.index', $data);
    }

    public function approve($pengajuanID)
    {
        SuratKesanggupan::where('pengajuan_id', $pengajuanID)->update([
            'is_approve' => true
        ]);

        $this->kirimNotifikasiKePemohon($pengajuanID);

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Menunggu Laporan Dokumen Akhir'
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Surat Persetujuan'
        ]);

        return to_route('admin.surat.persetujuan', $pengajuanID)->with('success', 'Terimakasih telah menyetujui Surat Kesanggupan');
    }

    public function kirimNotifikasiKePemohon($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToUser.hasOneProfile', 'hasOneDataPemohon')->findOrFail($pengajuanID);

        $nomorHpPemohon = $pengajuan->belongsToUser->hasOneProfile->nomor_telepon;
        $namaProyek = $pengajuan->hasOneDataPemohon->nama_proyek;

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
                'target' => "$nomorHpPemohon", // nomer hp pemohon
                'message' => "Admin telah menyetujui surat pernyataan kesanggupan yang telah anda unggah pada proyek $namaProyek.\nHarap menunggu notifikasi berikutnya untuk download laporan dokumen akhir!",
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
