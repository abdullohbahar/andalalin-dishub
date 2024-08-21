<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;
use App\Models\JadwalTinajuanLapangan;

class TinjauanLapanganController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with(
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
            'hasOneJadwalTinjauan'
        )
            ->findOrFail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan
        ];

        return view('admin.pengajuan.tinjauan-lapangan.index', $data);
    }

    public function updateJadwal(Request $request, $id)
    {
        $jadwal = new JadwalTinajuanLapangan();

        JadwalTinajuanLapangan::where('id', $id)->update([
            'tanggal' => $request->tanggal,
            'jam' => $request->jam
        ]);

        $data = $jadwal->with('belongsToPengajuan.belongsToUser.hasOneProfile', 'belongsToPengajuan.hasOneDataPemohon')->where('pengajuan_id', $request->pengajuan_id)->first();

        $this->kirimNotifikasiJadwalDiubah($data);

        return redirect()->back()->with('success', 'Berhasil mengubah jadwal');
    }

    public function kirimNotifikasiJadwalDiubah($jadwal)
    {
        $nomorPemohon = $jadwal->belongsToPengajuan?->belongsToUser?->hasOneProfile?->no_telepon;
        $namaProyek = $jadwal->belongsToPengajuan?->hasOneDataPemohon?->nama_proyek;
        $upperNamaProyek = Str::upper($namaProyek);
        $namaWebsite = env('APP_URL');

        $pengajuan = Pengajuan::with(
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
        )
            ->findorfail($jadwal->pengajuan_id);

        $nomorKonsultan = $pengajuan->hasOneDataPemohon?->belongsToConsultan?->hasOneProfile?->no_telepon;

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
                'target' => "$nomorPemohon, $nomorKonsultan", // nomer hp pemohon
                'message' => "Admin telah mengubah jadwal tinajaun lapangan pada proyek $upperNamaProyek, Harap melakukan pengecekan pada website $namaWebsite , untuk mengunduh jadwal tinjauan lapangan baru!",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

    public function telahMelakukanTinjauan($jadwalID)
    {
        $jadwal = JadwalTinajuanLapangan::findorfail($jadwalID);

        JadwalTinajuanLapangan::where('id', $jadwalID)->update([
            'is_review' => true
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $jadwal->pengajuan_id,
        ], [
            'step' => 'Buat Jadwal Sidang'
        ]);

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $jadwal->pengajuan_id,
        ], [
            'step' => 'Sidang'
        ]);

        return redirect()->back()->with('success', 'Terimakasih telah melakukan peninjauan lapangan');
    }
}
