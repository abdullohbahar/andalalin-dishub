<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisRencanaPembangunan;
use Illuminate\Http\Request;

class JenisRencanaPembangunanController extends Controller
{
    public function index()
    {
        $jenisRencanaPembangunan = JenisRencanaPembangunan::orderBy('created_at', 'asc')->get();

        $data = [
            'active' => 'jenis-rencana-pembangunan',
            'jenisRencanaPembangunan' => $jenisRencanaPembangunan
        ];

        return view('admin.jenis-rencana-pembangunan.index', $data);
    }

    public function create()
    {
        $data = [
            'active' => 'jenis-rencana-pembangunan'
        ];

        return view('admin.jenis-rencana-pembangunan.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:jenis_rencana_pembangunans,nama'
        ], [
            'nama.required' => 'Jenis Rencana Pembangunan Harus Diisi',
            'nama.unique' => 'Jenis Rencana Pembangunan Sudah Ada',
        ]);

        try {
            JenisRencanaPembangunan::create([
                'nama' => $request->nama
            ]);

            return to_route('admin.jenis.rencana.pembangunan')->with('success', 'Berhasil Menambah Jenis Rencana Pembangunan');
        } catch (\Throwable $th) {
            return to_route('admin.jenis.rencana.pembangunan')->with('failed', 'Gagal Menambah Jenis Rencana Pembangunan');
        }
    }

    public function edit($id)
    {
        $jenisRencanaPembangunan = JenisRencanaPembangunan::findorfail($id);

        $data = [
            'active' => 'jenis-rencana-pembangunan',
            'jenisRencanaPembangunan' => $jenisRencanaPembangunan
        ];

        return view('admin.jenis-rencana-pembangunan.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ], [
            'nama.required' => 'Jenis Rencana Pembangunan Harus Diisi',
        ]);

        $jenisRencanaPembangunan = JenisRencanaPembangunan::findorfail($id);

        if ($jenisRencanaPembangunan->nama != $request->nama) {
            $request->validate([
                'nama' => 'unique:jenis_rencana_pembangunans,nama'
            ], [
                'nama.unique' => 'Jenis Rencana Pembangunan Sudah Ada',
            ]);
        }

        try {
            $jenisRencanaPembangunan->nama = $request->nama;
            $jenisRencanaPembangunan->save();

            return to_route('admin.jenis.rencana.pembangunan')->with('success', 'Berhasil Mengubah Jenis Rencana Pembangunan');
        } catch (\Throwable $th) {
            return to_route('admin.jenis.rencana.pembangunan')->with('failed', 'Gagal Mengubah Jenis Rencana Pembangunan');
        }
    }
}
