<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JadwalTinajuanLapangan;

class CreateJadwalController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneDataPemohon')->findOrFail($pengajuanID);

        $jadwals = JadwalTinajuanLapangan::with('belongsToPengajuan.hasOneDataPemohon')->get();

        $arrJadwals = [];
        foreach ($jadwals as $jadwal) {
            $arrJadwals[] = [
                'title' => $jadwal->jam,
                'start' => $jadwal->getRawOriginal('tanggal'),
                'id' => $jadwal->id
            ];
        }

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan,
            'arrJadwals' => json_encode($arrJadwals), // Konversi array menjadi JSON
        ];

        return view('admin.pengajuan.buat-jadwal.index', $data);
    }

    public function store(Request $request)
    {
        $jadwal = new JadwalTinajuanLapangan();
        $cekPengajuan = $jadwal->where('pengajuan_id', $request->pengajuan_id)->first();

        if ($cekPengajuan) {
            return redirect()->back()->with('failed', 'Anda telah menambahkan jadwal untuk pengajuan ini');
        }

        JadwalTinajuanLapangan::create([
            'pengajuan_id' => $request->pengajuan_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam
        ]);

        $data = $jadwal->with('belongsToPengajuan.belongsToUser.hasOneProfile', 'belongsToPengajuan.hasOneDataPemohon')->where('pengajuan_id', $request->pengajuan_id)->first();

        $this->kirimNotifikasiJadwalDibuat($data);

        // selanjutnya membuat stepper untuk tinjauan lapangan bersama
        return to_route('admin.tinjauan.lapangan', $request->pengajuan_id)->with('success', 'Berhasil Menambahkan Jadwal, Harap Lakukan Tinjauan Lapangan Sesuai Jadwal Yang Telah Dibuat');
    }

    public function kirimNotifikasiJadwalDibuat($jadwal)
    {
        $nomorPemohon = $jadwal->belongsToPengajuan->belongsToUser->hasOneProfile->no_telepon;
        $namaProyek = $jadwal->belongsToPengajuan->hasOneDataPemohon->nama_proyek;
        $upperNamaProyek = Str::upper($namaProyek);
        $namaWebsite = env('APP_URL');

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
                'message' => "Admin telah membuat jadwal tinajaun lapangan pada proyek $upperNamaProyek, Harap melakukan pengecekan pada website $namaWebsite , untuk mengunduh jadwal tinjauan lapangan!",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

    public function getDetailJadwal($jadwalID)
    {
        $jadwal = JadwalTinajuanLapangan::with('belongsToPengajuan.hasOneDataPemohon')->where('id', $jadwalID)->first();

        $data = [
            'nama_proyek' => $jadwal->belongsToPengajuan->hasOneDataPemohon->nama_proyek,
            'alamat' => $jadwal->belongsToPengajuan->hasOneDataPemohon->alamat,
            'tanggal_tinjauan' => $jadwal->tanggal,
            'jam_tinjauan' => $jadwal->jam
        ];

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function hapusJadwal($jadwalID)
    {
        try {
            $jadwal = JadwalTinajuanLapangan::findorfail($jadwalID);

            // Hapus user dari tabel user
            $jadwal->delete();

            // Mengembalikan respons JSON sukses dengan status 200
            return response()->json([
                'message' => 'Berhasil Menghapus',
                'code' => 200,
                'error' => false
            ]);
        } catch (\Exception $e) {
            // Menangkap exception jika terjadi kesalahan
            return response()->json([
                'message' => 'Gagal Menghapus' . $e,
                'code' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }
}
