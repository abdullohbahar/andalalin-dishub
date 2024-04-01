<?php

namespace App\Http\Controllers\Pdf;

use PDF;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class CoverController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($pengajuanID)
    {
        $logoPath = public_path('img/logo-dishub.png');
        $encodeLogo = base64_encode(file_get_contents($logoPath));

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

        $data = [
            'pengajuan' => $pengajuan,
            'logoDishub' => $encodeLogo
        ];

        $pdf = PDF::loadView('document-template.cover', $data);

        $userID = auth()->user()->id;

        $path = public_path('storage/file-uploads/cover/'  . $userID .  '/' . $pengajuan->hasOneDataPemohon->nama_proyek . '/');

        // Check if the directory exists
        if (!File::exists($path)) {
            // If not, create it
            File::makeDirectory($path, $mode = 0777, true, true);
            // You can adjust the permission mode as needed (0777 in this case)
        }

        $pdf->render();
        $pdf->save($path . 'cover.pdf');

        return $path . 'cover.pdf';
    }
}
