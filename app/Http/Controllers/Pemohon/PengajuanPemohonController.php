<?php

namespace App\Http\Controllers\Pemohon;

use Carbon\Carbon;
use App\Models\Pengajuan;
use App\Models\JenisJalan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JenisRencanaPembangunan;
use App\Models\RiwayatInputData;
use DataTables;


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
                ->whereHas('hasOneDataPemohon', function ($query) {
                    $query->whereNotNull('nama_proyek')->where('nama_proyek', '!=', '');
                })
                ->where('user_id', $userID)
                ->get();

            // return $query;
            return Datatables::of($query)
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

    public function pilihTipe()
    {
        $data = [
            'active' => 'pengajuan'
        ];

        return view('pemohon.pengajuan.pilih-tipe', $data);
    }

    public function createTipeAndalalin()
    {
        $userID = auth()->user()->id;

        $pengajuan = Pengajuan::create([
            'user_id' => $userID,
            'jenis_pengajuan' => 'andalalin',
            'status' => 'input data belum selesai'
        ]);

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuan->id
        ], [
            'step' => 'Buat Pengajuan Baru'
        ]);

        return to_route('pemohon.create.pengajuan.andalalin', $pengajuan->id);
    }
}
