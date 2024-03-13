<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use PDF;

class PemberitahuanJadwalTinjauan extends Controller
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

        $pengajuan = Pengajuan::with('hasOneJadwalTinjauan', 'hasOneDataPemohon.belongsToConsultan.hasOneProfile', 'belongsToUser.hasOneProfile')->findOrFail($pengajuanID);

        \Carbon\Carbon::setLocale('id');
        $tanggal = \Carbon\Carbon::parse($pengajuan->hasOneJadwalTinjauan->tanggal)->translatedFormat('L F Y');
        $hari = \Carbon\Carbon::parse($pengajuan->hasOneJadwalTinjauan->tanggal)->translatedFormat('l');
        $tanggalSurat = \Carbon\Carbon::parse($pengajuan->hasOneJadwalTinjauan->created_at)->translatedFormat('L F Y');

        $kepada = [];
        $kepada['pimpinan'] = $pengajuan->hasOneDataPemohon->nama_pimpinan;
        $kepada['konsultan'] = $pengajuan->hasOneDataPemohon->belongsToConsultan->hasOneProfile->nama;
        $kepada['pemohon'] = $pengajuan->belongsToUser->hasOneProfile->nama;

        $data = [
            'aksara' => $encodeAksara,
            'logo' => $encodeLogo,
            'pengajuan' => $pengajuan,
            'tanggal' => $tanggal,
            'hari' => $hari,
            'tanggalSurat' => $tanggalSurat,
            'kepada' => $kepada
        ];

        $pdf = PDF::loadView('document-template.jadwal-tinjauan', $data);

        return $pdf->download('Jadwal Tinjauan Lapangan.pdf');

        return view('document-template.jadwal-tinjauan', $data);
    }
}
