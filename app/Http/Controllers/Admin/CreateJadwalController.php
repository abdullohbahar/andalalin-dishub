<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalTinajuanLapangan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

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

        return redirect()->back()->with('success', 'Berhasil Menambahkan Jadwal');
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
