<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengajuan;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;
use App\Models\User;

class BeritaAcaraController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToJenisRencana.hasOneTemplateBeritaAcara', 'hasOneBeritaAcara.belongsToUser.hasOneProfile')->findorfail($pengajuanID);

        $users = User::where('role', 'pemohon')
            ->orwhere('role', 'konsultan')
            ->orwhere('role', 'pemrakarsa')
            ->get();

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan,
            'users' => $users
        ];

        return view('admin.pengajuan.berita-acara.index', $data);
    }

    public function update(Request $request, $pengajuanID)
    {
        $request->validate([
            'user' => 'required',
            'tanggal' => 'required',
        ], [
            'user.required' => 'Harap memilih pemohon / konslutan / pemrakarsa',
            'tanggal.required' => 'Tanggal harus diisi'
        ]);

        // lakukan pengecekan apakah berita acara sudah ada atau belum
        $beritaAcara = new BeritaAcara();

        if ($beritaAcara->where('pengajuan_id', $pengajuanID)->first()) {
            BeritaAcara::where('pengajuan_id', $pengajuanID)
                ->update([
                    'body' => $request->body,
                    'user_id' => $request->user_id,
                    'tanggal' => $request->tanggal,
                ]);
        } else {
            $nomor_terbesar = BeritaAcara::max('nomor');

            // Jika tidak ada nomor sebelumnya, maka nomor baru adalah 1
            if (!$nomor_terbesar) {
                $nomor_baru = 1;
            } else {
                // Jika ada nomor sebelumnya, nomor baru adalah nomor terbesar ditambah 1
                $nomor_baru = $nomor_terbesar + 1;
            }

            BeritaAcara::create([
                'body' => $request->body,
                'user_id' => $request->user_id,
                'tanggal' => $request->tanggal,
                'nomor' => $nomor_baru,
                'pengajuan_id' => $pengajuanID
            ]);
        }

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
