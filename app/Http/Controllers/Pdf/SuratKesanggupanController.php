<?php

namespace App\Http\Controllers\Pdf;

use PDF;
use App\Models\User;
use App\Models\Pengajuan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Riskihajar\Terbilang\Facades\Terbilang;

class SuratKesanggupanController extends Controller
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
            'hasOneSuratKesanggupan'
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
        $nomor = sprintf("%02d", $pengajuan->hasOneBeritaAcara->nomor);

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

        $pdf = PDF::loadView('document-template.surat-kesanggupan', $data);

        return $pdf->stream('Surat Kesanggupan.pdf');

        return view('document-template.surat-kesanggupan', $data);
    }
}
