<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\Pengajuan;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use Illuminate\Http\Request;

class BeritaAcaraPemohonController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::findOrFail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuanID' => $pengajuanID
        ];

        return view('pemohon.berita-acara.index', $data);
    }

    public function unggahBeritaAcara(Request $request, $pengajuanID)
    {
        $request->validate([
            "file_uploads" => "required|mimes:pdf"
        ]);

        $pengajuan = Pengajuan::with('hasOneDataPemohon')->findorfail($pengajuanID);

        if ($request->hasFile('file_uploads')) {
            $file = $request->file('file_uploads');
            $filename = time() . " - Berita Acara." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Berita Acara/'  . $pengajuan->user_id .  '/' . $pengajuan->hasOneDataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->storeAs('public/' . $location, $filename);

            // Tentukan path lengkap file
            $fullPath = storage_path('app/public/' . $location . $filename);

            // Ubah hak akses file menjadi 755
            chmod($fullPath, 0755);

            BeritaAcara::where('pengajuan_id', $pengajuanID)->update([
                'file_uploads' => $filepath
            ]);
        }

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Surat Kesanggupan'
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Menunggu Surat Kesanggupan'
        ]);

        return to_route('pemohon.surat.kesanggupan', $pengajuanID)->with('success', 'Terimakasih telah mengunggah berita acara');
    }
}
