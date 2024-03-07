<?php

namespace App\Http\Controllers\Pemohon;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pengajuan;
use App\Models\JenisJalan;
use App\Models\DataPemohon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DokumenDataPemohon;
use App\Http\Controllers\Controller;
use App\Models\JenisRencanaPembangunan;
use Illuminate\Support\Facades\Storage;

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
            ->where('role', 'konsultan')
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

        if ($request->hasFile('surat_permohonan')) {
            $file = $request->file('surat_permohonan');
            $filename = time() . " - surat permohonan." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $dataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->storeAs('public/' . $location, $filename);

            DokumenDataPemohon::create([
                'data_pemohon_id' => $request->data_pemohon_id,
                'user_id' => $userID,
                'nama_dokumen' => 'Surat Permohonan',
                'dokumen' => $filepath,
                'is_verified' => false
            ]);
        }

        if ($request->hasFile('dokumen_site_plan')) {
            $file = $request->file('dokumen_site_plan');
            $filename = time() . " - dokumen site plan." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $dataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->storeAs('public/' . $location, $filename);

            DokumenDataPemohon::create([
                'data_pemohon_id' => $request->data_pemohon_id,
                'user_id' => $userID,
                'nama_dokumen' => 'Dokumen Site Plan',
                'dokumen' => $filepath,
                'is_verified' => false
            ]);
        }

        if ($request->hasFile('surat_aspek_tata_ruang')) {
            $file = $request->file('surat_aspek_tata_ruang');
            $filename = time() . " - surat aspek tata ruang." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $dataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->storeAs('public/' . $location, $filename);

            DokumenDataPemohon::create([
                'data_pemohon_id' => $request->data_pemohon_id,
                'user_id' => $userID,
                'nama_dokumen' => 'Surat Aspek Tata Ruang',
                'dokumen' => $filepath,
                'is_verified' => false
            ]);
        }

        if ($request->hasFile('sertifikat_tanah')) {
            $file = $request->file('sertifikat_tanah');
            $filename = time() . " - sertifikat tanah." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $dataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->storeAs('public/' . $location, $filename);

            DokumenDataPemohon::create([
                'data_pemohon_id' => $request->data_pemohon_id,
                'user_id' => $userID,
                'nama_dokumen' => 'Sertifikat Tanah',
                'dokumen' => $filepath,
                'is_verified' => false
            ]);
        }

        if ($request->hasFile('kkop')) {
            $file = $request->file('kkop');
            $filename = time() . " - kkop." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $dataPemohon->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->storeAs('public/' . $location, $filename);

            DokumenDataPemohon::create([
                'data_pemohon_id' => $request->data_pemohon_id,
                'user_id' => $userID,
                'nama_dokumen' => 'KKOP',
                'dokumen' => $filepath,
                'is_verified' => false
            ]);
        }

        // Mendapatkan tanggal hari ini
        $today = Carbon::now();

        // Menambahkan 3 hari kerja ke depan
        $nextWorkingDay = $today->addWeekdays(3);

        // Jika tanggal jatuh pada akhir pekan, lompat ke hari Senin berikutnya
        if ($nextWorkingDay->isWeekend()) {
            $nextWorkingDay->next(Carbon::MONDAY);
        }

        Pengajuan::where('id', $dataPemohon->pengajuan_id)->update([
            'status' => 'menunggu konfirmasi admin',
            'deadline' => $nextWorkingDay->toDateString(),
        ]);

        $this->kirimNotifikasiKeAdmin($dataPemohon->pengajuan_id);

        return to_route('pemohon.pengajuan')->with('success', 'Terimakasih telah mengisi data yang sesuai. Harap menunggu konfirmasi admin, paling lambat 3 hari kerja');
    }

    public function kirimNotifikasiKeAdmin($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToUser', 'hasOneDataPemohon')->where('id', $pengajuanID)->first();

        $namaPemohon = $pengajuan->belongsToUser->hasOneProfile->nama;
        $jenisPengajuan = $pengajuan->jenis_pengajuan;
        $namaProyek = $pengajuan->hasOneDataPemohon->nama_proyek;
        $deadline = $pengajuan->deadline;

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
                'target' => "085701223722", // nomer hp admin
                'message' => "Pemohon telah melakukan pengajuan permohonan baru, dengan rincian data berikut:\nNama Pemohon: $namaPemohon\nJenis Pengajuan: $jenisPengajuan\nNama Proyek: $namaProyek\nHarap diverifikasi sebelum tanggal $deadline",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

    public function show($pengajuanID)
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

        $data = [
            'pengajuan' => $pengajuan,
            'active' => 'pengajuan-permohonan',
        ];

        return view('pemohon.pengajuan.show', $data);
    }

    public function uploadRevisiDokumen(Request $request)
    {
        $userID = auth()->user()->id;

        $lowerNamaDokumen = Str::lower($request->nama_dokumen);

        if ($request->hasFile('file')) {

            // lakukan pengecekan apakah dokumen dengan nama tersebut ada jika ada maka hapus terlebih dahulu baru upload ulang
            $dokumen = new DokumenDataPemohon();

            $path = $dokumen->where('id', $request->dokumen_id)->first()->dokumen;

            // Ambil path relatif setelah "public/"
            $relativePath = Str::after($path, 'file-uploads/');

            // Dapatkan path penyimpanan fisik
            $storagePath = public_path('storage/file-uploads/' . $relativePath);

            // Periksa apakah file ada
            if (file_exists($storagePath)) {
                // Hapus file jika ada
                unlink($storagePath);
            }

            $file = $request->file('file');
            $filename = time() . " - $lowerNamaDokumen ." . $file->getClientOriginalExtension();
            $location = 'file-uploads/Dokumen Permohonan/'  . $userID .  '/' . $request->nama_proyek . '/';
            $filepath = $location . $filename;
            $file->storeAs('public/' . $location, $filename);

            $dokumen->where('id', $request->dokumen_id)->update([
                'is_revised' => true,
                'dokumen' => $filepath,
                'is_verified' => false,
                'status' => NULL,
                'alasan' => NULL,
            ]);

            return redirect()->back()->with('success', 'Berhasil diupload');
        }
    }

    public function selesaiRevisi($idPengajuan)
    {
        Pengajuan::where('id', $idPengajuan)->update([
            'status' => 'telah direvisi'
        ]);

        return to_route('pemohon.pengajuan')->with('success', 'Terimakasih Telah Melakukan Revisi Dokumen');
    }
}
