<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubJenisRencanaPembangunan;
use App\Models\SubSubJenisRencana;
use App\Models\UkuranMinimal;
use Illuminate\Http\Request;

class UkuranMinimalController extends Controller
{
    public function index($id, $jenis)
    {
        if ($jenis == 'sub') {
            $queries = SubJenisRencanaPembangunan::findorfail($id);
            $ukuranMinimal = UkuranMinimal::where('sub_jenis_rencana_id', $id)
                ->get();
        } else if ($jenis == 'subsub') {
            $ukuranMinimal = UkuranMinimal::where('sub_sub_jenis_rencana_id', $id)
                ->get();
            $queries = SubSubJenisRencana::findorfail($id);
        }



        $data = [
            'active' => 'jenis-rencana-pembangunan',
            'queries' => $queries,
            'ukuranMinimal' => $ukuranMinimal,
            'jenis' => $jenis
        ];

        return view('admin.jenis-rencana-pembangunan.ukuran-minimal.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'keterangan' => 'required',
            'tipe' => 'required',
        ], [
            'kategori.required' => 'Kategori harus diisi',
            'keterangan.required' => 'Ukuran minimal harus diisi',
            'tipe.required' => 'Tipe harus diisi',
        ]);

        if ($request->jenis == 'sub') {
            UkuranMinimal::create([
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
                'tipe' => $request->tipe,
                'sub_jenis_rencana_id' => $request->id_sub
            ]);
        } else if ($request->jenis == 'subsub') {
            UkuranMinimal::create([
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
                'tipe' => $request->tipe,
                'sub_sub_jenis_rencana_id' => $request->id_sub
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambah ukuran minimal');
    }

    public function edit($id, $jenis, $idSub)
    {
        $ukuranMinimal = UkuranMinimal::findorfail($id);

        $data = [
            'active' => 'jenis-rencana-pembangunan',
            'ukuranMinimal' => $ukuranMinimal,
            'jenis' => $jenis,
            'idSub' => $idSub
        ];

        return view('admin.jenis-rencana-pembangunan.ukuran-minimal.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required',
            'keterangan' => 'required',
            'tipe' => 'required'
        ], [
            'kategori.required' => 'Kategori harus diisi',
            'keterangan.required' => 'Ukuran minimal harus diisi',
            'tipe.required' => 'Tipe harus diisi',
        ]);

        UkuranMinimal::where('id', $id)
            ->update([
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
                'tipe' => $request->tipe,
            ]);

        // redirect belum fix ----
        if ($request->jenis == 'sub') {
            $ukuranMinimal = UkuranMinimal::findorfail($id);
            return to_route('admin.sub.ukuran.minimal', [
                'idSub' => $ukuranMinimal->sub_jenis_rencana_id,
                'jenis' => 'sub',
            ])->with('success', 'Berhasil mengubah ukuran minimal');
        } else if ($request->jenis == 'subsub') {
            $ukuranMinimal = UkuranMinimal::findorfail($id);
            return to_route('admin.sub.sub.ukuran.minimal', [
                'idSub' => $ukuranMinimal->sub_sub_jenis_rencana_id,
                'jenis' => 'subsub',
            ])->with('success', 'Berhasil mengubah ukuran minimal');
        }
    }

    public function destroy($idUkuranMinimal)
    {
        try {
            $user = UkuranMinimal::findOrFail($idUkuranMinimal); // Temukan user yang akan dihapus

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
