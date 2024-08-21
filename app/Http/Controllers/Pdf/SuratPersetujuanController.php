<?php

namespace App\Http\Controllers\Pdf;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Romans\Filter\IntToRoman;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Riskihajar\Terbilang\Facades\Terbilang;

class SuratPersetujuanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($pengajuanID)
    {
        $logoPath = public_path('img/kab-bantul.png');
        $encodeLogo = base64_encode(file_get_contents($logoPath));

        $aksaraPath = public_path('img/aksara-dishub.png');
        $encodeAksara = base64_encode(file_get_contents($aksaraPath));

        $pengajuan = Pengajuan::with(
            'hasOneJadwalTinjauan',
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
            'belongsToUser.hasOneProfile',
            'belongsToJenisRencana',
            'belongsToSubJenisRencana.hasOneUkuranMinimal',
            'belongsToSubSubJenisRencana.hasOneUkuranMinimal',
            'hasOneBeritaAcara',
            'hasOnePemrakarsa',
            'hasOneSuratKesanggupan',
            'hasOneSuratPersetujuan'
        )->findOrFail($pengajuanID);

        // mencari ukuran minimal
        if ($pengajuan?->sub_sub_jenis_rencana) {
            $ukuranMinimal = $pengajuan->belongsToSubJenisRencana?->hasOneUkuranMinimal?->tipe;
        } else {
            $ukuranMinimal = $pengajuan->belongsToSubSubJenisRencana?->hasOneUkuranMinimal?->tipe;
        }

        // mencari jenis bangkitan
        if ($pengajuan?->sub_sub_jenis_rencana) {
            $jenisBangkitan = $pengajuan->belongsToSubJenisRencana?->hasOneUkuranMinimal?->kategori;
        } else {
            $jenisBangkitan = $pengajuan->belongsToSubSubJenisRencana?->hasOneUkuranMinimal?->kategori;
        }


        // mengambil nama proyek
        $namaProyek = $pengajuan->hasOneDataPemohon?->nama_proyek ?? '';

        // alamat proyek
        $alamatProyek = $pengajuan->hasOneDataPemohon?->alamat ?? '';

        // tanggal diambil dari pemohon mengajukan berita acara
        \Carbon\Carbon::setLocale('id');
        $tanggal = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('L');
        $hari = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('l');
        $bulanString = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('F');
        $bulanInteger = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->format('m');
        $tahun = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('Y');

        // tanggal surat permohonan
        $tanggalSuratPermohonan = Carbon::parse($pengajuan->hasOneDataPemohon?->tanggal_surat_permohonan)->translatedFormat('d F Y');
        $tanggalSuratPersetujuan = Carbon::parse($pengajuan->hasOneSuratPersetujuan?->updated_at)->translatedFormat('d F Y');

        $roman = new IntToRoman();
        $bulanRoman = $roman->filter($bulanInteger);

        $tahapOperasional = $pengajuan->hasOneBeritaAcara->body;
        $nomor = sprintf("%02d", $pengajuan->hasOneBeritaAcara->nomor);

        $penilais = User::with('hasOneProfile', 'hasOneTtd')->where('role', 'like', '%penilai%')->orderBy('role', 'asc')->get();

        Config::set('terbilang.locale', 'id');

        $luasLahan = $pengajuan->hasOneDataPemohon?->luas_tanah;
        $luasBangunan = $pengajuan->hasOneDataPemohon?->luas_bangunan;

        $data = [
            'aksara' => $encodeAksara,
            'logo' => $encodeLogo,
            'hari' => $hari,
            'tanggal' => Terbilang::make($tanggal),
            'bulanString' => $bulanString,
            'bulanInteger' => $bulanInteger,
            'bulanRoman' => $bulanRoman,
            'tahunInteger' => $tahun,
            'tahun' => Terbilang::make($tahun),
            'ukuranMinimal' => $ukuranMinimal,
            'jenisBangkitan' => $jenisBangkitan,
            'namaProyek' => $namaProyek,
            'alamatProyek' => $alamatProyek,
            'yearNow' => date('Y'),
            'tahapOperasional' => $tahapOperasional,
            'penilais' => $penilais,
            'nomor' => $nomor,
            'pengajuan' => $pengajuan,
            'luasLahan' => $luasLahan,
            'terbilangLuasLahan' => Terbilang::make(intVal($luasLahan)),
            'luasBangunan' => $luasBangunan,
            'tanggalSuratPermohonan' => $tanggalSuratPermohonan,
            'tanggalSuratPersetujuan' => $tanggalSuratPersetujuan
        ];

        $pdf = PDF::loadView('document-template.surat-persetujuan', $data);

        if (!$pengajuan->hasOneSuratPersetujuan?->tte) {
            $directory = 'public/file-uploads/Surat Persetujuan/' . $pengajuan->user_id . '/' . $pengajuan->hasOneDataPemohon?->nama_proyek;

            // Membuat direktori jika belum ada
            Storage::makeDirectory($directory);

            $location = $directory . '/surat-persetujuan.pdf';

            // Menyimpan file ke storage/app/public
            $pdf->save(storage_path('app/' . $location));

            // Mengambil atau membuat objek SuratPersetujuan secara eksplisit
            $suratPersetujuan = $pengajuan->hasOneSuratPersetujuan ?? new \App\Models\SuratPersetujuan();

            // Memodifikasi objek dan menyimpannya
            $suratPersetujuan->file = $location;

            // Jika objek baru dibuat, kita harus menetapkan pengajuan_id (atau kunci asing lainnya)
            if (!$suratPersetujuan->exists) {
                $suratPersetujuan->pengajuan_id = $pengajuan->id;
            }

            $suratPersetujuan->save();
        }

        return $pdf->stream('Surat Kesanggupan.pdf');

        return view('document-template.surat-persetujuan', $data);
    }
}
