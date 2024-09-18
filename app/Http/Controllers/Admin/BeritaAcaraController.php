<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\User;
use App\Models\Pengajuan;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use App\Models\RiwayatInputData;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Riskihajar\Terbilang\Facades\Terbilang;

class BeritaAcaraController extends Controller
{
    public function index($pengajuanID)
    {
        $pengajuan = Pengajuan::with(
            'belongsToJenisRencana.hasOneTemplateBeritaAcara',
            'hasOneBeritaAcara.belongsToUser.hasOneProfile',
            'belongsToSubJenisRencana.hasOneTemplateBeritaAcara',
            'belongsToSubSubJenisRencana.hasOneTemplateBeritaAcara',
        )->findorfail($pengajuanID);

        if ($pengajuan->belongsToSubSubJenisRencana) {
            $template = $pengajuan->belongsToSubSubJenisRencana?->hasOneTemplateBeritaAcara?->body;
        } else {
            $template = $pengajuan->belongsToSubJenisRencana?->hasOneTemplateBeritaAcara?->body;
        }

        $users = User::where('role', 'pemohon')
            ->orwhere('role', 'konsultan')
            ->orwhere('role', 'pemrakarsa')
            ->get();

        $data = [
            'active' => 'pengajuan',
            'pengajuan' => $pengajuan,
            'users' => $users,
            'template' => $template
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

        $pengajuan = Pengajuan::findorfail($pengajuanID);

        if ($beritaAcara->where('pengajuan_id', $pengajuanID)->first()) {
            $data = [
                'body' => $request->body,
                'body_prakonstruksi' => $request->body_prakonstruksi,
                'body_konstruksi' => $request->body_konstruksi,
                'user_id' => $request->user_id,
                'tanggal' => $request->tanggal,
            ];

            if ($pengajuan->jenis_pengajuan == 'non-andalalin') {
                $data['is_penilai_3_approve'] = true;
                $data['is_penilai_2_approve'] = true;
                $data['is_penilai_1_approve'] = true;
            }

            BeritaAcara::where('pengajuan_id', $pengajuanID)
                ->update($data);
        } else {
            $nomor_terbesar = BeritaAcara::max('nomor');

            // Jika tidak ada nomor sebelumnya, maka nomor baru adalah 1
            if (!$nomor_terbesar) {
                $nomor_baru = 1;
            } else {
                // Jika ada nomor sebelumnya, nomor baru adalah nomor terbesar ditambah 1
                $nomor_baru = $nomor_terbesar + 1;
            }

            $data = [
                'body_prakonstruksi' => $request->body_prakonstruksi,
                'body_konstruksi' => $request->body_konstruksi,
                'body' => $request->body,
                'user_id' => $request->user_id,
                'tanggal' => $request->tanggal,
                'nomor' => $nomor_baru,
                'pengajuan_id' => $pengajuanID
            ];

            if ($pengajuan->jenis_pengajuan == 'non-andalalin') {
                $data['is_penilai_3_approve'] = true;
                $data['is_penilai_2_approve'] = true;
                $data['is_penilai_1_approve'] = true;
            }

            BeritaAcara::create($data);
        }

        return redirect()->back()->with('success', 'Berhasil disimpan');
    }

    public function telahMengisi($pengajuanID)
    {
        $pengajuan = Pengajuan::findorfail($pengajuanID);

        $role = auth()->user()->role;

        if ($pengajuan->jenis_pengajuan === 'andalalin') {
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

            $this->kirimNotifikasiKePenilai();

            return to_route("$role.menunggu.verifikasi.penilai", $pengajuanID)->with('success', 'Terimakasih telah mengisi berita acara. Harap menunggu verifikasi berita acara yang dilakukan oleh penilai!');
        } else {
            RiwayatInputData::updateorcreate([
                'pengajuan_id' => $pengajuanID
            ], [
                'step' => 'Surat Kesanggupan'
            ]);

            RiwayatVerifikasi::updateorcreate([
                'pengajuan_id' => $pengajuanID
            ], [
                'step' => 'Menunggu Surat Kesanggupan'
            ]);

            $fileUpload = $this->generateBeritaAcara($pengajuanID);

            BeritaAcara::where('pengajuan_id', $pengajuanID)->update([
                'is_penilai_1_approve' => true,
                'is_penilai_2_approve' => true,
                'is_penilai_3_approve' => true,
                'file_uploads' => $fileUpload
            ]);

            return to_route("admin.menunggu.surat.kesanggupan", $pengajuanID)->with('success', 'Terimakasih telah mengisi berita acara. Harap menunggu verifikasi berita acara yang dilakukan oleh penilai!');
        }
    }

    public function kirimNotifikasiKePenilai()
    {
        $penilai1 = User::with('hasOneProfile')->where('role', 'penilai1')->first();
        $penilai2 = User::with('hasOneProfile')->where('role', 'penilai2')->first();
        $penilai3 = User::with('hasOneProfile')->where('role', 'penilai3')->first();

        $nomorHpPenilai1 = $penilai1?->hasOneProfile?->no_telepon ?? '';
        $nomorHpPenilai2 = $penilai2?->hasOneProfile?->no_telepon ?? '';
        $nomorHpPenilai3 = $penilai3?->hasOneProfile?->no_telepon ?? '';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => "$nomorHpPenilai1, $nomorHpPenilai2, $nomorHpPenilai3", // nomer hp pemohon
                'message' => "Admin telah melakukan input berita acara, harap untuk segera melakukan persetujuan berita acara!",
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
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

    public function generateBeritaAcara($pengajuanID)
    {
        // dd($pengajuanID);

        $logoPath = public_path('img/kab-bantul.png');
        $encodeLogo = base64_encode(file_get_contents($logoPath));

        $aksaraPath = public_path('img/aksara-dishub.png');
        $encodeAksara = base64_encode(file_get_contents($aksaraPath));

        $watermark = public_path('img/logo-dishub.png');
        $encodeWatermark = base64_encode(file_get_contents($watermark));

        $pengajuan = Pengajuan::with(
            'hasOneJadwalTinjauan',
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
            'belongsToUser.hasOneProfile',
            'belongsToJenisRencana',
            'belongsToSubJenisRencana.hasOneUkuranMinimal',
            'belongsToSubSubJenisRencana.hasOneUkuranMinimal',
            'hasOneBeritaAcara',
            'hasOnePemrakarsa'
        )->findOrFail($pengajuanID);

        // mencari ukuran minimal
        if ($pengajuan?->sub_sub_jenis_rencana) {
            $ukuranMinimal = $pengajuan?->belongsToSubJenisRencana?->hasOneUkuranMinimal?->tipe;
        } else {
            $ukuranMinimal = $pengajuan?->belongsToSubSubJenisRencana?->hasOneUkuranMinimal?->tipe;
        }

        // mencari jenis bangkitan
        if ($pengajuan?->sub_sub_jenis_rencana) {
            $jenisBangkitan = $pengajuan?->belongsToSubJenisRencana?->hasOneUkuranMinimal?->kategori;
        } else {
            $jenisBangkitan = $pengajuan?->belongsToSubSubJenisRencana?->hasOneUkuranMinimal?->kategori;
        }

        // mengambil nama proyek
        $namaProyek = $pengajuan->hasOneDataPemohon?->nama_proyek ?? '';

        // alamat proyek
        $alamatProyek = $pengajuan->hasOneDataPemohon?->alamat ?? '';

        // tanggal diambil dari pemohon mengajukan berita acara
        \Carbon\Carbon::setLocale('id');
        $tanggal = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('L');
        $hari = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('l');
        $bulan = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('F');
        $tahun = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('Y');

        $tahapOperasional = $pengajuan->hasOneBeritaAcara->body;
        $nomor = $pengajuan->hasOneBeritaAcara->nomor;

        $penilais = User::with('hasOneProfile', 'hasOneTtd')->where('role', 'like', '%penilai%')->orderBy('role', 'asc')->get();

        Config::set('terbilang.locale', 'id');

        $luasLahan = $pengajuan->hasOneDataPemohon?->luas_tanah;
        $luasBangunan = $pengajuan->hasOneDataPemohon?->luas_bangunan;

        $data = [
            'aksara' => $encodeAksara,
            'logo' => $encodeLogo,
            'hari' => $hari,
            'tanggal' => Terbilang::make($tanggal),
            'bulan' => $bulan,
            'tahun' => Terbilang::make($tahun),
            'ukuranMinimal' => $ukuranMinimal,
            'jenisBangkitan' => $jenisBangkitan,
            'namaProyek' => $namaProyek,
            'alamatProyek' => $alamatProyek,
            'yearNow' => date('Y'),
            'tahapOperasional' => $tahapOperasional,
            'penilais' => $penilais,
            'nomor' => $nomor,
            'pengajuan' => $pengajuan,
            'luasLahan' => $luasLahan,
            'luasBangunan' => $luasBangunan,
            'watermark' => $encodeWatermark,
        ];

        $pdf = PDF::loadView('document-template.berita-acara', $data);

        // Tentukan lokasi penyimpanan sesuai dengan struktur yang digunakan untuk file uploads
        $filename = time() . " - Berita Acara.pdf";
        $location = 'public/file-uploads/Berita Acara/' . $pengajuan->user_id . '/non-andalalin/berita-acara/';
        $filepath = $location . $filename;

        if (!Storage::exists('public/' . $location)) {
            Storage::makeDirectory('public/' . $location);
        }

        // Simpan file PDF
        $pdf->save(storage_path('app/public/' . $filepath));

        return $filepath;
    }
}
