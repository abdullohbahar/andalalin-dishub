<?php

namespace App\Http\Controllers\Pemohon;

use DataTables;
use Carbon\Carbon;
use App\Models\Pengajuan;
use App\Models\JenisJalan;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;
use App\Models\JenisRencanaPembangunan;


class PengajuanPemohonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userID = auth()->user()->id;

            $query = Pengajuan::with([
                'belongsToJenisRencana',
                'hasOneDataPemohon',
                'hasOneRiwayatInputData'
            ])
                ->orderBy('updated_at', 'desc')
                ->whereHas('hasOneDataPemohon')
                ->where('user_id', $userID)
                ->get();

            // return $query;
            return Datatables::of($query)
                ->addColumn('jenis', function ($item) {
                    if ($item->jenis_pengajuan == 'non-andalalin') {
                        $jenis = 'Non Andalalin';
                    } else {
                        $jenis = $item->belongsToJenisRencana?->nama ?? '';
                    }

                    return $jenis;
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

                    if ($item->status != 'input data belum selesai') {
                        $detailBtn = "<a href='/pengajuan/andalalin/detail/$item->id' class='btn btn-primary btn-sm'>Detail</a>";
                        // if ($item->hasOneRiwayatInputData->step == 'Selesai') {
                        //     $verifikasiBtn = '';
                        // } else {
                        $verifikasiBtn = "<a href='/pengajuan/andalalin/riwayat-input-data/$item->id' class='btn btn-warning btn-sm'>Aktivitas Permohonan</a>";
                        // }
                    } else {
                        $detailBtn = "<a href='/pengajuan/andalalin/riwayat-input-data/$item->id' class='btn btn-info btn-sm'>Lanjutkan Mengisi Data</a>";
                        $verifikasiBtn = '';
                    }

                    if ($item->hasOneDataPemohon?->longitude) {
                        $latitude = $item->hasOneDataPemohon?->latitude;
                        $longitude = $item->hasOneDataPemohon?->longitude;

                        $btnLihatLokasi = "<a href='https://www.google.com/maps?q=$latitude,$longitude' target='_blank' class='btn btn-success btn-sm'>Lihat Lokasi</a>";
                    } else {
                        $btnLihatLokasi  = '';
                    }

                    return "
                        <div class='btn-group' role='group'>
                            $detailBtn
                            $verifikasiBtn
                            $btnLihatLokasi
                        </div>
                    ";
                })
                ->rawColumns(['jenis', 'proyek', 'status', 'aksi'])
                ->make();
        }

        $userID = auth()->user()->id;

        $data = [
            'active' => 'pengajuan',
        ];

        return view('pemohon.pengajuan.index', $data);
    }

    public function pengajuan()
    {
        $jenisJalans = JenisJalan::get();
        $jenisRencanas = JenisRencanaPembangunan::orderBy('nama', 'asc')->get();

        $data = [
            'active' => 'pengajuan',
            'tipe' => 'andalalin',
            'jenisRencanas' => $jenisRencanas,
            'jenisJalans' => $jenisJalans,
        ];

        return view('pemohon.pengajuan.andalalin.create-andalalin', $data);
    }

    public function storePengajuan(Request $request)
    {
        $userID = auth()->user()->id;

        $data = [
            'user_id' => $userID,
            'jenis_jalan_id' => $request->jenis_jalan_id,
            'jenis_rencana_id' => $request->jenis_rencana_id,
            'sub_jenis_rencana_id' => $request->sub_jenis_rencana_id,
        ];

        if ($request->has('sub_sub_jenis_rencana_id')) {
            $data['sub_sub_jenis_rencana_id'] = $request->sub_sub_jenis_rencana_id;
        }

        $jenisPengajuan = ($request->ukuran_minimal_id != 'non-andalalin') ? 'andalalin' : 'non-andalalin';
        $data['jenis_pengajuan'] = $jenisPengajuan;

        if ($jenisPengajuan === 'andalalin') {
            $data['status'] = 'input data belum selesai';
            $data['ukuran_minimal_id'] = $request->ukuran_minimal_id;
        } else {
            $data['status'] = 'proses permohonan';
        }

        $pengajuan = Pengajuan::create($data);

        RiwayatInputData::updateOrCreate(
            ['pengajuan_id' => $pengajuan->id],
            ['step' => 'Input Data Permohonan Dan Data Konsultan']
        );

        return to_route('pemohon.pilih.konsultan.pengajuan.andalalin', $pengajuan->id);
    }
}
