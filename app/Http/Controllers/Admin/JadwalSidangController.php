<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JadwalSidang;

class JadwalSidangController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with(
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
            'hasOneJadwalTinjauan',
            'hasOneJadwalSidang'
        )
            ->findOrFail($pengajuanID);

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan
        ];

        return view('admin.pengajuan.jadwal-sidang.index', $data);
    }

    public function store(Request $request, $pengajuanID)
    {
        $request->validate([
            'jam' => 'required',
            'menit' => 'required',
            'tipe' => 'required',
            'tanggal' => 'required',
        ], [
            'jam.required' => 'Jam harus diisi',
            'menit.required' => 'Menit harus diisi',
            'tipe.required' => 'Tipe harus diisi',
            'tanggal.required' => 'Tanggal harus diisi'
        ]);

        if ($request->tipe == 'offline') {
            $request->validate([
                'alamat' => 'required'
            ], [
                'alamat.required' => 'Alamat harus diisi'
            ]);
        } else {
            $request->validate([
                'url' => 'required'
            ], [
                'url.required' => 'URL harus diisi'
            ]);
        }

        JadwalSidang::create([
            'jam' => "$request->jam:$request->menit",
            'tanggal' => $request->tanggal,
            'pengajuan_id' => $pengajuanID,
            'tipe' => $request->tipe,
            'url' => $request->url,
            'alamat' => $request->alamat
        ]);
    }
}
