<?php

namespace App\Http\Controllers\Pemohon;

use App\Models\Pengajuan;
use App\Models\JenisJalan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DataPemohon;
use App\Models\DokumenDataPemohon;
use App\Models\JenisRencanaPembangunan;
use App\Models\User;

class PengajuanAndalalinController extends Controller
{
    public function createAndalalin($pengajuanID)
    {
        $pengajuan = Pengajuan::findorfail($pengajuanID);
        $jenisJalans = JenisJalan::get();
        $jenisRencanas = JenisRencanaPembangunan::orderBy('nama', 'asc')->get();

        $data = [
            'active' => 'pengajuan',
            'tipe' => 'andalalin',
            'jenisRencanas' => $jenisRencanas,
            'jenisJalans' => $jenisJalans,
            'pengajuan' => $pengajuan
        ];

        return view('pemohon.pengajuan.andalalin.create-andalalin', $data);
    }

    public function updateAndalalin(Request $request, $pengajuanID)
    {
        $userID = auth()->user()->id;

        $data = [
            'user_id' => $userID,
            'jenis_jalan_id' => $request->jenis_jalan_id,
            'jenis_rencana_id' => $request->jenis_rencana_id,
            'sub_jenis_rencana_id' => $request->sub_jenis_rencana_id,
            'ukuran_minimal_id' => $request->ukuran_minimal_id,
        ];

        if ($request->has('sub_sub_jenis_rencana_id')) {
            $data['sub_sub_jenis_rencana_id'] = $request->sub_sub_jenis_rencana_id;
        }

        $pengajuan = Pengajuan::where('id', $pengajuanID)->update($data);

        return to_route('pemohon.pilih.konsultan.pengajuan.andalalin', $pengajuanID);
    }

    public function pilihKonsultan($pengajuanID)
    {
        $userID = auth()->user()->id;
        $konsultans = User::with('hasOneProfile')
            // ->where('role', 'konsultan')
            ->get();

        $pengajuan = Pengajuan::with('belongsToUkuranMinimal', 'belongsToJenisJalan', 'belongsToJenisRencana', 'belongsToSubJenisRencana', 'belongsToSubSubJenisRencana')
            ->where('user_id', $userID)
            ->where('id', $pengajuanID)
            ->first();

        $dataPemohon = DataPemohon::with('belongsToConsultan.hasOneProfile')->where('user_id', $userID)
            ->where('pengajuan_id', $pengajuanID)
            ->first();

        if (stripos($pengajuan->belongsToUkuranMinimal->kategori, 'rendah')) {
            $klasifikasi = 'rendah';
        } else {
            $klasifikasi = 'tinggi';
        }

        $user = User::with('hasOneProfile')->findorfail($userID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan,
            'user' => $user,
            'klasifikasi' => $klasifikasi,
            'konsultans' => $konsultans,
            'dataPemohon' => $dataPemohon
        ];

        return view('pemohon.pengajuan.andalalin.pilih-konsultan', $data);
    }

    public function storeDataPemohon(Request $request)
    {
        $userID = auth()->user()->id;

        $dataPemohon = DataPemohon::updateorcreate([
            'user_id' => $userID,
            'pengajuan_id' => $request->pengajuan_id,
        ], [
            'user_id' => $userID,
            'pengajuan_id' => $request->pengajuan_id,
            'konsultan_id' => $request->konsultan_id,
            'nama_pimpinan' => $request->nama_pimpinan,
            'jabatan_pimpinan' => $request->jabatan_pimpinan,
            'nama_proyek' => $request->nama_proyek,
            'nama_jalan' => $request->nama_jalan,
            'luas_bangunan' => $request->luas_bangunan,
            'luas_tanah' => $request->luas_tanah,
            'alamat' => $request->alamat,
            'nomor_surat_permohonan' => $request->nomor_surat_permohonan,
            'tanggal_surat_permohonan' => $request->tanggal_surat_permohonan,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        return to_route('pemohon.upload.dokumen.pemohon', $dataPemohon->id);
    }

    public function uploadDokumenPemohon($idDataPemohon)
    {
        $dataPemohon = DataPemohon::findorfail($idDataPemohon);

        $data = [
            'active' => 'pengajuan',
            'dataPemohon' => $dataPemohon
        ];

        return view('pemohon.pengajuan.andalalin.upload-dokumen-pemohon', $data);
    }

    public function storeDokumenPemohon(Request $request)
    {
        $dataPemohon = DataPemohon::findorfail($request->data_pemohon_id);
        $userID = auth()->user()->id;

        $dokumenPemohon = [
            'data_pemohon_id' => $request->data_pemohon_id,
            'user_id' => $userID,
            'is_verified' => null
        ];

        if ($request->hasFile('surat_permohonan')) {
            $file = $request->file('surat_permohonan');
            $filename = time() . " - surat permohonan." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $dataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->move($location, $filename);
            $dokumenPemohon['surat_permohonan'] = $filepath;
        }

        if ($request->hasFile('dokumen_site_plan')) {
            $file = $request->file('dokumen_site_plan');
            $filename = time() . " - dokumen site plan." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $dataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->move($location, $filename);
            $dokumenPemohon['dokumen_site_plan'] = $filepath;
        }

        if ($request->hasFile('surat_aspek_tata_ruang')) {
            $file = $request->file('surat_aspek_tata_ruang');
            $filename = time() . " - surat aspek tata ruang." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $dataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->move($location, $filename);
            $dokumenPemohon['surat_aspek_tata_ruang'] = $filepath;
        }

        if ($request->hasFile('sertifikat_tanah')) {
            $file = $request->file('sertifikat_tanah');
            $filename = time() . " - sertifikat tanah." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $dataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->move($location, $filename);
            $dokumenPemohon['sertifikat_tanah'] = $filepath;
        }

        if ($request->hasFile('kkop')) {
            $file = $request->file('kkop');
            $filename = time() . " - kkop." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $dataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->move($location, $filename);
            $dokumenPemohon['kkop'] = $filepath;
        }

        DokumenDataPemohon::create($dokumenPemohon);

        return to_route('pemohon.pengajuan')->with('success', 'Terimakasih telah mengisi data yang sesuai. Harap menunggu konfirmasi admin, paling lambat 3 hari kerja');
    }
}
