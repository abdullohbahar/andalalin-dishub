<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JenisRencanaPembangunan;
use App\Models\SubJenisRencanaPembangunan;
use App\Models\SubSubJenisRencana;

class SubJenisRencanaPembangunanController extends Controller
{
    public function index($idJenisRencanaPembangunan)
    {
        $jenisRencanaPembangunan = JenisRencanaPembangunan::findorfail($idJenisRencanaPembangunan);
        $subJenisRencanaPembangunan = SubJenisRencanaPembangunan::with('hasOneUkuranMinimal', 'hasOneSubSubJenis')
            ->where('jenis_rencana_id', $idJenisRencanaPembangunan)
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'active' => 'jenis-rencana-pembangunan',
            'jenisRencanaPembangunan' => $jenisRencanaPembangunan,
            'subJenisRencanaPembangunan' => $subJenisRencanaPembangunan,
        ];

        return view('admin.jenis-rencana-pembangunan.sub-jenis-rencana-pembangunan.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:sub_jenis_rencanas,nama',
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.unique' => 'Nama sudah dipakai',
        ]);

        SubJenisRencanaPembangunan::create([
            'jenis_rencana_id' => $request->id_jenis_rencana_pembangunan,
            'nama' => $request->nama
        ]);

        return redirect()->back()->with('success', 'Berhasil menambah');
    }

    public function edit($id)
    {
        $subJenisRencanaPembangunan = SubJenisRencanaPembangunan::findorfail($id);

        $data = [
            'active' => 'jenis-rencana-pembangunan',
            'subJenisRencanaPembangunan' => $subJenisRencanaPembangunan
        ];

        return view('admin.jenis-rencana-pembangunan.sub-jenis-rencana-pembangunan.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ], [
            'nama.required' => 'Nama Harus Diisi',
        ]);

        $subJenisRencanaPembangunan = SubJenisRencanaPembangunan::findorfail($id);

        if ($subJenisRencanaPembangunan->nama != $request->nama) {
            $request->validate([
                'nama' => 'unique:sub_jenis_rencanas,nama'
            ], [
                'nama.unique' => 'Nama Sudah Ada',
            ]);
        }

        try {
            $subJenisRencanaPembangunan->nama = $request->nama;
            $subJenisRencanaPembangunan->save();

            return to_route('admin.jenis.sub.rencana.pembangunan', $subJenisRencanaPembangunan->jenis_rencana_id)->with('success', 'Berhasil Mengubah Sub Jenis Rencana Pembangunan');
        } catch (\Throwable $th) {
            return to_route('admin.jenis.sub.rencana.pembangunan', $subJenisRencanaPembangunan->jenis_rencana_id)->with('failed', 'Gagal Mengubah Sub Jenis Rencana Pembangunan')->withInput();
        }
    }

    public function destroy($idSubJenisRencanaPembangunan)
    {
        try {
            $subsub = SubSubJenisRencana::where('sub_jenis_rencana_id', $idSubJenisRencanaPembangunan)->get();

            foreach ($subsub as $sub) {
                $sub->delete();
            }

            $sub = SubJenisRencanaPembangunan::findOrFail($idSubJenisRencanaPembangunan); // Temukan user yang akan dihapus

            // Hapus user dari tabel user
            $sub->delete();

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
