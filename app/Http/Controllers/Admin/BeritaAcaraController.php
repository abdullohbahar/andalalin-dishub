<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;

class BeritaAcaraController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToJenisRencana.hasOneTemplateBeritaAcara', 'hasOneBeritaAcara')->findorfail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan
        ];

        return view('admin.pengajuan.berita-acara.index', $data);
    }

    public function update(Request $request, $pengajuanID)
    {
        BeritaAcara::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'body' => $request->body
        ]);

        return redirect()->back()->with('success', 'Berhasil disimpan');
    }

    public function telahMengisi($pengajuanID)
    {
        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $pengajuanID,
        ], [
            'step' => 'Menunggu Verifikasi Penilai'
        ]);

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuanID,
        ], [
            'step' => 'Menunggu Verifikasi Penilai'
        ]);

        $role = auth()->user()->role;

        return to_route("$role.menunggu.verifikasi.penilai", $pengajuanID)->with('success', 'Terimakasih telah mengisi berita acara. Harap menunggu verifikasi berita acara yang dilakukan oleh penilai!');
    }

    public function menungguVerifikasiPenilai($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToJenisRencana.hasOneTemplateBeritaAcara', 'hasOneBeritaAcara')->findorfail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan
        ];

        return view('admin.pengajuan.berita-acara.show', $data);
    }
}
