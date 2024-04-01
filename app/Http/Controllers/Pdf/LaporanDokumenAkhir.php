<?php

namespace App\Http\Controllers\Pdf;

use PDF;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use App\Models\SuratKesanggupan;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use App\Http\Controllers\Controller;
use App\Models\DataPemohon;
use App\Models\DokumenDataPemohon;
use App\Models\Pengajuan;
use App\Models\SuratPersetujuan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class LaporanDokumenAkhir extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($pengajuanID)
    {
        $pengajuan = Pengajuan::with('hasOneDataPemohon')->findorfail($pengajuanID);

        $pdfMerger = PDFMerger::init();

        // cover
        $cover = new CoverController();
        $pdfMerger->addPDF($cover->__invoke($pengajuanID));

        // surat persetujuan
        $suratPersetujuan = new SuratPersetujuanController();
        $suratPersetujuan->__invoke($pengajuanID);
        $suratPersetujuan = SuratPersetujuan::where('pengajuan_id', $pengajuanID)->first()?->file;
        $pdfMerger->addPDF(storage_path('app/' . $suratPersetujuan));

        // Load Berita Acara PDF
        $beritaAcara = BeritaAcara::where('pengajuan_id', $pengajuanID)->first()?->file_uploads;
        $pdfMerger->addPDF(storage_path('app/public/' . $beritaAcara));

        // Load Surat Kesanggupan PDF
        $suratKesanggupan = SuratKesanggupan::where('pengajuan_id', $pengajuanID)->first()?->getRawOriginal('file');
        $pdfMerger->addPDF(storage_path('app/public/' . $suratKesanggupan));

        // dokumen
        $dataPemohon = new DataPemohon();

        $suratPermohonan = $dataPemohon->with([
            'hasOneDokumenDataPemohon' => function ($query) {
                $query->where('nama_dokumen', 'Surat Permohonan');
            }
        ])->where('pengajuan_id', $pengajuanID)->first();

        $pdfMerger->addPDF(storage_path('app/public/' . $suratPermohonan->hasOneDokumenDataPemohon->getRawOriginal('dokumen')));

        $dokumenSitePlan = $dataPemohon->with([
            'hasOneDokumenDataPemohon' => function ($query) {
                $query->where('nama_dokumen', 'Dokumen Site Plan');
            }
        ])->where('pengajuan_id', $pengajuanID)->first();

        $pdfMerger->addPDF(storage_path('app/public/' . $dokumenSitePlan->hasOneDokumenDataPemohon->getRawOriginal('dokumen')));

        $suratAspekTataRuang = $dataPemohon->with([
            'hasOneDokumenDataPemohon' => function ($query) {
                $query->where('nama_dokumen', 'Surat Aspek Tata Ruang');
            }
        ])->where('pengajuan_id', $pengajuanID)->first();

        $pdfMerger->addPDF(storage_path('app/public/' . $suratAspekTataRuang->hasOneDokumenDataPemohon->getRawOriginal('dokumen')));

        $sertifikatTanah = $dataPemohon->with([
            'hasOneDokumenDataPemohon' => function ($query) {
                $query->where('nama_dokumen', 'Sertifikat Tanah');
            }
        ])->where('pengajuan_id', $pengajuanID)->first();

        $pdfMerger->addPDF(storage_path('app/public/' . $sertifikatTanah->hasOneDokumenDataPemohon->getRawOriginal('dokumen')));

        $kkop = $dataPemohon->with([
            'hasOneDokumenDataPemohon' => function ($query) {
                $query->where('nama_dokumen', 'KKOP');
            }
        ])->where('pengajuan_id', $pengajuanID)->first();

        $pdfMerger->addPDF(storage_path('app/public/' . $kkop->hasOneDokumenDataPemohon->getRawOriginal('dokumen')));

        // lampiran

        // Gabungkan PDFs
        $pdfMerger->merge();

        // Simpan file hasil penggabungan (contoh: merged.pdf)
        $path = public_path('storage/file-uploads/Laporan Dokumen Akhir/'  . $pengajuan->user_id .  '/' . $pengajuan->hasOneDataPemohon->nama_proyek . '/');

        // Check if the directory exists
        if (!File::exists($path)) {
            // If not, create it
            File::makeDirectory($path, $mode = 0777, true, true);
            // You can adjust the permission mode as needed (0777 in this case)
        }

        $pdfMerger->save($path . 'Laporan Dokumen Akhir.pdf');

        // Set header untuk file PDF
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename=Laporan Dokumen Akhir.pdf'
        ];

        // Stream file PDF ke browser
        return Response::file($path . 'Laporan Dokumen Akhir.pdf', $headers);

        return $path . 'Laporan Dokumen Akhir.pdf';
    }
}
