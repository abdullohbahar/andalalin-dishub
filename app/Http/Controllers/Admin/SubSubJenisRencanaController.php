<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubJenisRencanaPembangunan;
use App\Models\SubSubJenisRencana;
use Illuminate\Http\Request;

class SubSubJenisRencanaController extends Controller
{
    public function index($idSubJenisRencanaPembangunan)
    {
        $subJenisRencanaPembangunan = SubJenisRencanaPembangunan::findorfail($idSubJenisRencanaPembangunan);
        $subSubJenisRencanaPembangunan = SubSubJenisRencana::where('sub_jenis_rencana_id', $idSubJenisRencanaPembangunan)
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'active' => 'jenis-rencana-pembangunan',
            'subJenisRencanaPembangunan' => $subJenisRencanaPembangunan,
            'subSubJenisRencanaPembangunan' => $subSubJenisRencanaPembangunan,
        ];

        return view('admin.jenis-rencana-pembangunan.sub-jenis-rencana-pembangunan.sub-sub-jenis-rencana-pembangunan.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:sub_sub_jenis_rencanas,nama',
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.unique' => 'Nama sudah dipakai',
        ]);

        SubSubJenisRencana::create([
            'sub_jenis_rencana_id' => $request->id_sub_jenis_rencana_pembangunan,
            'nama' => $request->nama
        ]);

        return redirect()->back()->with('success', 'Berhasil menambah');
    }

    public function edit($id)
    {
        $subSubJenisRencanaPembangunan = SubSubJenisRencana::findorfail($id);

        $data = [
            'active' => 'jenis-rencana-pembangunan',
            'subSubJenisRencanaPembangunan' => $subSubJenisRencanaPembangunan
        ];

        return view('admin.jenis-rencana-pembangunan.sub-jenis-rencana-pembangunan.sub-sub-jenis-rencana-pembangunan.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ], [
            'nama.required' => 'Nama Harus Diisi',
        ]);

        $SubSubJenisRencanaPembangunan = SubSubJenisRencana::findorfail($id);

        if ($SubSubJenisRencanaPembangunan->nama != $request->nama) {
            $request->validate([
                'nama' => 'unique:sub_sub_jenis_rencanas,nama'
            ], [
                'nama.unique' => 'Nama Sudah Ada',
            ]);
        }

        try {
            $SubSubJenisRencanaPembangunan->nama = $request->nama;
            $SubSubJenisRencanaPembangunan->save();

            return to_route('admin.jenis.sub.sub.rencana.pembangunan', $SubSubJenisRencanaPembangunan->sub_jenis_rencana_id)->with('success', 'Berhasil Mengubah Sub Sub Jenis Rencana Pembangunan');
        } catch (\Throwable $th) {
            return to_route('admin.jenis.sub.sub.rencana.pembangunan', $SubSubJenisRencanaPembangunan->sub_jenis_rencana_id)->with('failed', 'Gagal Mengubah Sub Sub Jenis Rencana Pembangunan')->withInput();
        }
    }

    public function destroy($idSubSubJenisRencanaPembangunan)
    {
        try {
            $user = SubSubJenisRencana::findOrFail($idSubSubJenisRencanaPembangunan); // Temukan user yang akan dihapus

            // Hapus user dari tabel user
            $user->delete();

            // Mengembalikan respons JSON sukses dengan status 200
            return response()->json([
                'message' => 'Berhasil Menghapus',
                'code' => 200,
                'error' => false
            ]);
        } catch (\Exception $e) {
            // Menangkap exception jika terjadi kesalahan
            return response()->json([
                'message' => 'Gagal Menghapus' . $e,
                'code' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }
}
