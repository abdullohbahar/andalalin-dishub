<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenDataPemohon;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with('belongsToJenisRencana', 'hasOneDataPemohon', 'belongsToUser.hasOneProfile')
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = [
            'active' => 'pengajuan-permohonan',
            'pengajuans' => $pengajuans
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
            'belongsToUser.hasOneProfile'
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
            'belongsToUser.hasOneProfile'
        )
            ->findorfail($pengajuanID);

        $statusDokumen = [];
        foreach ($pengajuan->hasOneDataPemohon->hasManyDokumenDataPemohon as $dokumen) {
            $statusDokumen[] = $dokumen->status;
        }

        if (in_array('ditolak', $statusDokumen)) {
            $status = 'ditolak';
        } else if (in_array('revisi', $statusDokumen)) {
            $status = 'revisi';
        } else {
            $status = 'disetujui';
        }

        Pengajuan::where('id', $pengajuanID)->update([
            'status' => $status
        ]);

        return to_route('admin.pengajuan.index')->with('success', 'Terimakasih Telah Menyelesaikan Verifikasi');
    }
}
