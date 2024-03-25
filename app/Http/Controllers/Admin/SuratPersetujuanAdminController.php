<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;

class SuratPersetujuanAdminController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToJenisRencana.hasOneTemplateBeritaAcara', 'hasOneBeritaAcara.belongsToUser.hasOneProfile')->findorfail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan,
        ];

        return view('admin.pengajuan.surat-persetujuan.index', $data);
    }

    public function next($pengajuanID)
    {
        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Menunggu Persetujuan Surat Persetujuan'
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Menunggu Persetujuan Surat Persetujuan'
        ]);

        return to_route('admin.menunggu.persetujuan.surat.persetujuan', $pengajuanID)->with('success', 'Harap menunggu persetujuan dari KASI, KABID dan KADIS');
    }

    public function show($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToJenisRencana.hasOneTemplateBeritaAcara', 'hasOneBeritaAcara.belongsToUser.hasOneProfile')->findorfail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan,
        ];

        return view('admin.pengajuan.surat-persetujuan.show', $data);
    }

    public function kirimNotifikasiKeKadis($pengajuanID)
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
