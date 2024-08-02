<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DokumenDataPemohon;
use App\Http\Controllers\Controller;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use DataTables;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Pengajuan::with('belongsToJenisRencana', 'hasOneDataPemohon', 'belongsToUser.hasOneProfile', 'hasOneRiwayatInputData')
                ->whereHas('hasOneDataPemohon', function ($query) {
                    $query->whereNotNull('nama_proyek')->where('nama_proyek', '!=', '');
                })
                ->orderBy('updated_at', 'desc')
                ->get();

            // return $query;
            return Datatables::of($query)
                ->addColumn('nama', function ($item) {
                    return $item->belongsToUser?->hasOneProfile?->nama ?? '';
                })
                ->addColumn('jenis', function ($item) {
                    return $item->belongsToJenisRencana?->nama ?? '';
                })
                ->addColumn('proyek', function ($item) {
                    return $item->hasOneDataPemohon?->nama_proyek ?? '';
                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 'ditolak') {
                        $color = 'danger';
                    } else if ($item->status == 'disetujui') {
                        $color = 'info';
                    } else if ($item->status == 'revisi') {
                        $color = 'warning';
                    } else if ($item->status == 'Selesai') {
                        $color = 'success';
                    } else if ($item->status == 'input data belum selesai') {
                        $color = 'secondary';
                    } else {
                        $color = 'primary';
                    }

                    return "<span class='badge badge-$color'>$item->status</span>";
                })
                ->addColumn('aksi', function ($item) {
                    $detailBtn = "<a href='/admin/pengajuan/detail/$item->id' class='btn btn-primary btn-sm'>Detail</a>";

                    if ($item->status != 'ditolak') {
                        if ($item->status != 'input data belum selesai') {
                            // if ($item->hasOneRiwayatInputData?->step != 'Selesai') {
                            $btnVerifikasi = "<a href='/admin/aktivitas/$item->id' class='btn btn-info btn-sm'>Verifikasi</a>";
                            // } else {
                            //     $btnVerifikasi = '';
                            // }
                        } else {
                            $btnVerifikasi = '';
                        }
                    } else {
                        $btnVerifikasi = '';
                    }

                    return "
                        <div class='btn-group' role='group'>
                            $detailBtn
                            $btnVerifikasi
                        </div>
                    ";
                })
                ->rawColumns(['nama', 'jenis', 'proyek', 'status', 'aksi'])
                ->make();
        }

        $data = [
            'active' => 'pengajuan-permohonan',
        ];

        return view('admin.pengajuan.index', $data);
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
            'belongsToUser.hasOneProfile',
            'hasOneSuratPersetujuan',
            'hasOnePemrakarsa'
        )
            ->findorfail($pengajuanID);

        $data = [
            'pengajuan' => $pengajuan,
            'active' => 'pengajuan-permohonan',
        ];

        return view('admin.pengajuan.show', $data);
    }

    public function setujui($dokumenID)
    {
        try {
            DokumenDataPemohon::where('id', $dokumenID)->update([
                'status' => 'disetujui',
                'is_verified' => true
            ]);

            // Mengembalikan respons JSON sukses dengan status 200
            return response()->json([
                'message' => 'Berhasil Menyetujui Dokumen',
                'code' => 200,
                'error' => false
            ]);
        } catch (\Exception $e) {
            // Menangkap exception jika terjadi kesalahan
            return response()->json([
                'message' => 'Gagal Menyetujui Dokumen' . $e,
                'code' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function revisi(Request $request)
    {
        DokumenDataPemohon::where('id', $request->dokumenID)->update([
            'alasan' => $request->alasan,
            'status' => 'revisi'
        ]);

        return redirect()->back()->with('success', 'Berhasil');
    }

    public function tolak(Request $request)
    {
        $documents = DokumenDataPemohon::where('data_pemohon_id', $request->dataPemohonID)->get();

        foreach ($documents as $document) {
            DokumenDataPemohon::where('id', $document->id)
                ->update([
                    'alasan' => $request->alasan,
                    'status' => 'ditolak'
                ]);
        }

        return redirect()->back()->with('success', 'Berhasil Menolak');
    }

    public function selesaiVerifikasi($pengajuanID)
    {
        $pengajuan = Pengajuan::with(
            'belongsToJenisRencana',
            'belongsToUkuranMinimal',
            'belongsToJenisJalan',
            'belongsToSubJenisRencana',
            'belongsToSubSubJenisRencana',
            'hasOneDataPemohon.hasManyDokumenDataPemohon',
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
            'belongsToUser.hasOneProfile',
            'hasOneDataPemohon.belongsToConsultan'
        )
            ->findorfail($pengajuanID);


        $statusDokumen = [];
        foreach ($pengajuan->hasOneDataPemohon->hasManyDokumenDataPemohon as $dokumen) {
            $statusDokumen[] = $dokumen->status;
        }

        // Menggunakan array_filter untuk memeriksa apakah semua nilai adalah null
        $isSemuaNull = count(array_filter($statusDokumen, function ($status) {
            return $status !== null;
        })) === 0;

        if ($isSemuaNull) {
            return redirect()->back()->with('terminated', 'Harap melakukan verifikasi pada dokumen yang ada');
        }

        if (in_array('ditolak', $statusDokumen)) {
            $this->kirimNotifikasiDitolak($pengajuan);
            $status = 'ditolak';

            Pengajuan::where('id', $pengajuanID)->update([
                'status' => $status
            ]);

            return to_route('admin.pengajuan.index')->with('success', 'Terimakasih Telah Melakukan Verifikasi. Harap Menunggu Pemohon Mengajukan Permohonan Ulang');
        } else if (in_array('revisi', $statusDokumen)) {
            $this->kirimNotifikasiRevisi($pengajuan);
            $status = 'revisi';

            Pengajuan::where('id', $pengajuanID)->update([
                'status' => $status
            ]);

            RiwayatVerifikasi::updateorcreate([
                'pengajuan_id' => $pengajuanID,
            ], [
                'step' => 'Buat Jadwal Tinjauan Lapangan'
            ]);

            RiwayatInputData::updateorcreate([
                'pengajuan_id' => $pengajuanID,
            ], [
                'step' => 'Jadwal Tinjauan Lapangan'
            ]);

            return to_route('admin.buat.jadwal', $pengajuanID)->with('success', 'Terimakasih Telah Melakukan Verifikasi.');
        } else {
            $this->kirimNotifikasiDisetujui($pengajuan);
            $status = 'disetujui';
            $tambahan = 'Silahkan membuatkan jadwal tinjauan lapangan untuk pemohon';

            Pengajuan::where('id', $pengajuanID)->update([
                'status' => $status
            ]);

            RiwayatVerifikasi::updateorcreate([
                'pengajuan_id' => $pengajuanID,
            ], [
                'step' => 'Buat Jadwal Tinjauan Lapangan'
            ]);

            RiwayatInputData::updateorcreate([
                'pengajuan_id' => $pengajuanID,
            ], [
                'step' => 'Jadwal Tinjauan Lapangan'
            ]);

            return to_route('admin.buat.jadwal', $pengajuanID)->with('success', 'Terimakasih Telah Melakukan Verifikasi. ' . $tambahan);
        }
    }

    public function kirimNotifikasiRevisi($pengajuan)
    {
        $nomorPemohon = $pengajuan->belongsToUser->hasOneProfile->no_telepon;
        $nomorKonsultan = $pengajuan->hasOneDataPemohon->belongsToConsultan->hasOneProfile->no_telepon;

        $namaProyek = $pengajuan->hasOneDataPemohon->nama_proyek;
        $upperNamaProyek = Str::upper($namaProyek);

        $namaDokumen = [];
        foreach ($pengajuan->hasOneDataPemohon->hasManyDokumenDataPemohon as $dokumen) {
            if ($dokumen->status == 'revisi') {
                $namaDokumen[] = '- ' . $dokumen->nama_dokumen;
            }
        }

        $implode = implode("\n", $namaDokumen);

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
                'target' => "$nomorPemohon, $nomorKonsultan", // nomer hp pemohon
                'message' => "Admin telah melakukan verifikasi pada data telah unggah pada proyek $upperNamaProyek, adapun dokumen yang perlu DIREVISI yaitu:\n$implode\nHarap untuk mengunggah ulang dokumen tersebut.",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

    public function kirimNotifikasiDitolak($pengajuan)
    {
        $nomorPemohon = $pengajuan->belongsToUser->hasOneProfile->no_telepon;
        $nomorKonsultan = $pengajuan->hasOneDataPemohon->belongsToConsultan->hasOneProfile->no_telepon;

        $namaProyek = $pengajuan->hasOneDataPemohon->nama_proyek;
        $upperNamaProyek = Str::upper($namaProyek);

        foreach ($pengajuan->hasOneDataPemohon->hasManyDokumenDataPemohon as $dokumen) {
            $alasan = $dokumen->alasan;
        }

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
                'target' => "$nomorPemohon, $nomorKonsultan", // nomer hp pemohon
                'message' => "Admin telah melakukan verifikasi pada data yang telah diunggah pada proyek $upperNamaProyek, permohonan anda DITOLAK oleh Admin. Adapun alasan penolakannya sebagai berikut:\n$alasan\nHarap untuk melakukan pengisian data ulang.",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

    public function kirimNotifikasiDisetujui($pengajuan)
    {
        $nomorPemohon = $pengajuan->belongsToUser->hasOneProfile->no_telepon;
        $nomorKonsultan = $pengajuan->hasOneDataPemohon->belongsToConsultan->hasOneProfile->no_telepon;

        $namaProyek = $pengajuan->hasOneDataPemohon->nama_proyek;
        $upperNamaProyek = Str::upper($namaProyek);

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
                'target' => "$nomorPemohon, $nomorKonsultan", // nomer hp pemohon
                'message' => "Admin telah melakukan verifikasi pada data yang telah diunggah pada proyek $upperNamaProyek, permohonan anda DISETUJUI oleh admin. Harap menunggu notifikasi berikutnya untuk jadwal tinjauan lapangan",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }
}
