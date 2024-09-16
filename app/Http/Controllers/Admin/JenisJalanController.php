<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisJalan;
use Illuminate\Http\Request;

class JenisJalanController extends Controller
{
    public function index()
    {
        $jenisJalan = JenisJalan::orderBy('created_at', 'asc')->get();

        $data = [
            'active' => 'jenis-jalan',
            'jenisJalan' => $jenisJalan
        ];

        return view('admin.jenis-jalan.index', $data);
    }

    public function create()
    {
        $data = [
            'active' => 'jenis-jalan',
        ];

        return view('admin.jenis-jalan.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|unique:jenis_jalans'
        ], [
            'jenis.required' => 'Jenis jalan harus diisi',
            'jenis.unique' => 'Jenis jalan sudah dipakai'
        ]);

        JenisJalan::create([
            'jenis' => $request->jenis
        ]);

        return to_route('admin.jenis.jalan')->with('success', 'Berhasil');
    }

    public function edit($id)
    {
        $jenisJalan = JenisJalan::findorfail($id);

        $data = [
            'active' => 'jenis-jalan',
            'jenisJalan' => $jenisJalan
        ];

        return view('admin.jenis-jalan.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $jenisJalan = JenisJalan::findorfail($id);

        $request->validate([
            'jenis' => 'required'
        ], [
            'jenis.required' => 'Jenis jalan harus diisi',
        ]);

        if ($jenisJalan->jenis != $request->jenisJalan) {
            $request->validate([
                'jenis' => 'unique:jenis_jalans'
            ], [
                'jenis.unique' => 'Jenis jalan sudah dipakai'
            ]);
        }

        JenisJalan::where('id', $id)->update([
            'jenis' => $request->jenis
        ]);

        return to_route('admin.jenis.jalan')->with('success', 'Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $jalan = JenisJalan::findOrFail($id); // Temukan jalan yang akan dihapus

            // Hapus jalan dari tabel jalan
            $jalan->delete();

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
