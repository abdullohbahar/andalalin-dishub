<?php

namespace App\Http\Controllers\Pdf;

use PDF;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use App\Models\SuratKesanggupan;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use App\Http\Controllers\Controller;
use App\Models\SuratPersetujuan;

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
        $pdfMerger = PDFMerger::init();

        // cover

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

        // lampiran

        // Gabungkan PDFs
        $pdfMerger->merge();

        // Simpan file hasil penggabungan (contoh: merged.pdf)
        $pdfMerger->save(storage_path('app/public/merged.pdf'));
    }
}
