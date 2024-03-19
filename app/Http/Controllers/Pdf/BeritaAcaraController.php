<?php

namespace App\Http\Controllers\Pdf;

use PDF;
use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Riskihajar\Terbilang\Facades\Terbilang;


class BeritaAcaraController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($pengajuanID)
    {
        // dd($pengajuanID);

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
            'hasOneBeritaAcara'
        )->findOrFail($pengajuanID);

        // mencari ukuran minimal
        $ukuranMinimal = $pengajuan->belongsToSubJenisRencana->hasOneUkuranMinimal->kategori;

        preg_match_all("/\((.*?)\)/", $ukuranMinimal, $matches);

        if (isset($matches[1][0])) {
            $ukuranMinimal = $matches[1][0]; // Hasilnya adalah "Dokumen Andalalin"
        } else {
            $ukuranMinimal = '';
        }


        // mencari jenis bangkitan
        $jenisBangkitan = $pengajuan->belongsToSubJenisRencana->hasOneUkuranMinimal->kategori;

        preg_match("/^(.*?)\(/", $jenisBangkitan, $matches);

        if (isset($matches[1])) {
            $jenisBangkitan = $matches[1]; // Hasilnya adalah "Dokumen Andalalin"
        } else {
            $jenisBangkitan = '';
        }

        // mengambil nama proyek
        $namaProyek = $pengajuan->hasOneDataPemohon->nama_proyek ?? '';

        // alamat proyek
        $alamatProyek = $pengajuan->hasOneDataPemohon->alamat ?? '';

        // tanggal diambil dari pemohon mengajukan berita acara
        \Carbon\Carbon::setLocale('id');
        $tanggal = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('L');
        $hari = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('l');
        $bulan = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('F');
        $tahun = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('Y');

        $tahapOperasional = $pengajuan->hasOneBeritaAcara->body;
        $nomor = $pengajuan->hasOneBeritaAcara->nomor;

        $penilais = User::with('hasOneProfile', 'hasOneTtd')->where('role', 'like', '%penilai%')->orderBy('role', 'asc')->get();

        Config::set('terbilang.locale', 'id');

        $luasLahan = $pengajuan->hasOneDataPemohon->luas_tanah;
        $luasBangunan = $pengajuan->hasOneDataPemohon->luas_bangunan;

        $data = [
            'aksara' => $encodeAksara,
            'logo' => $encodeLogo,
            'hari' => $hari,
            'tanggal' => Terbilang::make($tanggal),
            'bulan' => $bulan,
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
            'luasBangunan' => $luasBangunan,
        ];

        $pdf = PDF::loadView('document-template.berita-acara', $data);

        return $pdf->stream('Berita Acara.pdf');

        return view('document-template.berita-acara', $data);
    }
}
