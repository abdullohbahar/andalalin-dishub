<?php

namespace App\Http\Controllers\Kadis;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\TteLog;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Romans\Filter\IntToRoman;
use App\Models\RiwayatInputData;
use App\Models\SuratPersetujuan;
use App\Models\RiwayatVerifikasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Riskihajar\Terbilang\Facades\Terbilang;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\EmailNotificationController;

class DashboardKadisController extends Controller
{
    public $passphrase;

    public function index()
    {
        $userID = auth()->user()->id;

        $user = User::with('hasOneProfile')->findOrFail($userID);

        if ($user->hasOneProfile?->no_ktp == '-' || $user->hasOneProfile?->no_ktp == null) {
            return to_route('edit.profile', $userID)->with('notification', 'harap melengkapi profile terlebih dahulu');
        }

        $belumApprove = SuratPersetujuan::with([
            'belongsToPengajuan.hasOneDataPemohon',
            'belongsToPengajuan.belongsToUser.hasOneProfile',
        ])
            ->where('is_kabid_approve', 1)
            ->where('is_kadis_approve', 0)
            ->whereNotNull('file')
            ->whereNotNull('pengajuan_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $sudahApprove = SuratPersetujuan::with([
            'belongsToPengajuan.hasOneDataPemohon',
            'belongsToPengajuan.belongsToUser.hasOneProfile',
            'belongsToPengajuan.hasOneSuratPersetujuan'
        ])->where('is_kadis_approve', 1)
            ->whereNotNull('file')
            ->whereNotNull('pengajuan_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $data = [
            'active' => 'dashboard',
            'belumApprove' => $belumApprove,
            'sudahApprove' => $sudahApprove,
        ];

        return view('kadis.dashboard.index', $data);
    }

    public function showSuratPersetujuan($pengajuanID)
    {
        $pengajuan = Pengajuan::findorfail($pengajuanID);

        $suratPersetujuan = SuratPersetujuan::where('pengajuan_id', $pengajuanID)->orderBy('created_at', 'desc')->first();

        $data = [
            'active' => 'dashboard',
            'pengajuan' => $pengajuan,
            'pengajuanID' => $pengajuanID,
            'suratPersetujuan' => $suratPersetujuan
        ];

        return view('kadis.dashboard.show-surat-persetujuan', $data);
    }


    public function approve(Request $request, $pengajuanID)
    {
        $this->passphrase = $request->passphrase;
        // dd($request->all());
        $generatePDF = $this->generatePDF($pengajuanID);

        if (!$generatePDF['success']) {
            $response = json_decode($generatePDF['response']->body());

            // dd($response);

            TteLog::create([
                'parent_id' => $pengajuanID,
                'parent_table' => 'surat_keputusans',
                'response' => $generatePDF['response']->body()
            ]);

            // dd($response);

            if ($generatePDF['status'] !== 500) {
                return redirect()->back()->with('failed', $response->error);
            } else {
                return redirect()->back()->with('failed', 'Terjadi masalah saat memproses TTE');
            }
        }

        $suratPersetujuan = SuratPersetujuan::where('pengajuan_id', $pengajuanID)->first()?->file;

        unlink(storage_path('app/' . $suratPersetujuan));

        SuratPersetujuan::where('pengajuan_id', $pengajuanID)->update([
            'is_kadis_approve' => true,
            'file' => $generatePDF['response'],
            'tte' => true
        ]);

        $this->kirimNotifikasiKePemohonKonsultan($pengajuanID);
        $this->kirimNotifikasiKeSemua($pengajuanID);

        RiwayatInputData::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Selesai'
        ]);

        RiwayatVerifikasi::updateorcreate([
            'pengajuan_id' => $pengajuanID
        ], [
            'step' => 'Selesai'
        ]);

        return to_route('kadis.dashboard')->with('success', 'Berhasil melakukan approve');
    }

    public function generatePDF($pengajuanID)
    {
        $logoPath = public_path('img/kab-bantul.png');
        $encodeLogo = base64_encode(file_get_contents($logoPath));

        $aksaraPath = public_path('img/aksara-dishub.png');
        $encodeAksara = base64_encode(file_get_contents($aksaraPath));

        $watermark = public_path('img/logo-dishub.png');
        $encodeWatermark = base64_encode(file_get_contents($watermark));

        $bsrePath = public_path('img/bsre.jpeg');
        $encodeBsre = base64_encode(file_get_contents($bsrePath));

        $pengajuan = Pengajuan::with(
            'hasOneJadwalTinjauan',
            'hasOneDataPemohon.belongsToConsultan.hasOneProfile',
            'belongsToUser.hasOneProfile',
            'belongsToJenisRencana',
            'belongsToSubJenisRencana.hasOneUkuranMinimal',
            'belongsToSubSubJenisRencana.hasOneUkuranMinimal',
            'hasOneBeritaAcara',
            'hasOnePemrakarsa',
            'hasOneSuratKesanggupan',
            'hasOneSuratPersetujuan'
        )->findOrFail($pengajuanID);

        // mencari ukuran minimal
        if ($pengajuan?->sub_sub_jenis_rencana) {
            $ukuranMinimal = $pengajuan->belongsToSubJenisRencana?->hasOneUkuranMinimal?->tipe;
        } else {
            $ukuranMinimal = $pengajuan->belongsToSubSubJenisRencana?->hasOneUkuranMinimal?->tipe;
        }

        // mencari jenis bangkitan
        if ($pengajuan?->sub_sub_jenis_rencana) {
            $jenisBangkitan = $pengajuan->belongsToSubJenisRencana?->hasOneUkuranMinimal?->kategori;
        } else {
            $jenisBangkitan = $pengajuan->belongsToSubSubJenisRencana?->hasOneUkuranMinimal?->kategori;
        }


        // mengambil nama proyek
        $namaProyek = $pengajuan->hasOneDataPemohon?->nama_proyek ?? '';

        // alamat proyek
        $alamatProyek = $pengajuan->hasOneDataPemohon?->alamat ?? '';

        // tanggal diambil dari pemohon mengajukan berita acara
        \Carbon\Carbon::setLocale('id');
        $tanggal = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('L');
        $hari = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('l');
        $bulanString = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('F');
        $bulanInteger = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->format('m');
        $tahun = \Carbon\Carbon::parse($pengajuan->hasOneBeritaAcara->tanggal)->translatedFormat('Y');

        // tanggal surat permohonan
        $tanggalSuratPermohonan = Carbon::parse($pengajuan->hasOneDataPemohon?->tanggal_surat_permohonan)->translatedFormat('d F Y');
        $tanggalSuratPersetujuan = Carbon::parse($pengajuan->hasOneSuratPersetujuan?->updated_at)->translatedFormat('d F Y');

        $roman = new IntToRoman();
        $bulanRoman = $roman->filter($bulanInteger);

        $tahapOperasional = $pengajuan->hasOneBeritaAcara->body;
        $nomor = sprintf("%02d", $pengajuan->hasOneBeritaAcara->nomor);

        $penilais = User::with('hasOneProfile', 'hasOneTtd')->where('role', 'like', '%penilai%')->orderBy('role', 'asc')->get();

        Config::set('terbilang.locale', 'id');

        $luasLahan = $pengajuan->hasOneDataPemohon?->luas_tanah;
        $luasBangunan = $pengajuan->hasOneDataPemohon?->luas_bangunan;

        $kadis = User::with('hasOneProfile')->where('role', 'kadis')->first();

        // Buat QR Code dalam format PNG
        $qrcode = QrCode::size(100)
            ->format('png')
            ->merge(public_path('img/kab-bantul.png'), 0.5, true) // Ganti dengan path yang benar
            ->errorCorrection('M')
            ->generate(route('preview.surat.persetujuan', $pengajuanID));

        // Encode QR Code ke dalam Base64
        $base64 = base64_encode($qrcode);

        // Buat string untuk image tag
        $qrcode = 'data:image/png;base64,' . $base64;

        $kadis = User::where('role', 'kadis')->first();

        $data = [
            'aksara' => $encodeAksara,
            'logo' => $encodeLogo,
            'hari' => $hari,
            'tanggal' => Terbilang::make($tanggal),
            'bulanString' => $bulanString,
            'bulanInteger' => $bulanInteger,
            'bulanRoman' => $bulanRoman,
            'tahunInteger' => $tahun,
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
            'terbilangLuasLahan' => Terbilang::make(intVal($luasLahan)),
            'luasBangunan' => $luasBangunan,
            'tanggalSuratPermohonan' => $tanggalSuratPermohonan,
            'tanggalSuratPersetujuan' => $tanggalSuratPersetujuan,
            'watermark' => $encodeWatermark,
            'qrcode' => $qrcode,
            'bsre' => $encodeBsre,
            'kadis' => $kadis
        ];

        $pdf = PDF::loadView('document-template.surat-persetujuan', $data);

        // / Tentukan nama file dan lokasi penyimpanan di folder public
        $fileDir = public_path('file-uploads/pdf/');
        $fileName = 'surat_persetujuan_' . $pengajuanID . '.pdf';
        $filePath = $fileDir . $fileName;

        // Periksa apakah folder sudah ada, jika tidak, buat folder
        if (!file_exists($fileDir)) {
            mkdir($fileDir, 0755, true);
        }

        // Simpan file PDF
        $pdf->save($filePath);

        return $this->signTte($filePath, $fileName);
    }

    public function signTte($file, $filename)
    {
        $username = env("TTE_USERNAME");
        $password = env("TTE_PASSWORD");
        $passphrase = $this->passphrase;
        $url = env("TTE_URL");

        // dd($passphrase);

        $kadis = User::where('role', 'kadis')->first();

        // dd($kadis->hasOneProfile->no_ktp);

        $data = [
            'nik' => $kadis->hasOneProfile->no_ktp,
            'passphrase' => $passphrase,
            'tampilan' => 'invisible',
            'location' => 'Bantul'
        ];

        $response = Http::withBasicAuth($username, $password)
            ->attach(
                'file',
                file_get_contents($file),
                $filename
            )
            ->post($url, $data);

        // dd($data, $response, $file, $filename);

        // Cek apakah response sukses
        if ($response->successful()) {
            // Ambil konten file PDF yang diterima dari API
            $pdfContent = $response->body(); // Mengambil respons binary dari API

            // Tentukan lokasi penyimpanan file PDF di folder public
            $fileDir = public_path('file-uploads/signed-pdf/');
            $signedFileName = 'signed_' . $filename;
            $filePath = $fileDir . $signedFileName;

            // Periksa apakah folder sudah ada, jika tidak, buat folder
            if (!file_exists($fileDir)) {
                mkdir($fileDir, 0755, true);
            }

            // Simpan file PDF ke folder public
            file_put_contents($filePath, $pdfContent);

            // Hapus file asli setelah file baru berhasil disimpan
            if (file_exists($file)) {
                unlink($file); // Menghapus file yang lama (yang dikirim ke API)
            }

            // Return atau lakukan sesuatu setelah file tersimpan, misal return path file
            // return response()->json(['success' => 'PDF signed and saved successfully', 'file_path' => $filePath]);

            return [
                'success' => true,
                'status' => $response->status(),
                'response' => 'file-uploads/signed-pdf/' . $signedFileName,
                'body' => $response->body()
            ];
        } else {
            // Jika request gagal, kembalikan respons error
            return [
                'success' => false,
                'status' => $response->status(),
                'response' => $response,
                'body' => $response->body()
            ];
        }
    }


    public function kirimNotifikasiKePemohonKonsultan($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToUser.hasOneProfile', 'hasOneDataPemohon', 'belongsToConsultan.hasOneProfile')->findorfail($pengajuanID);

        $nomorHpPemohon = $pengajuan->belongsToUser?->hasOneProfile?->no_telepon;
        $nomorHpKonsultan = $pengajuan->belongsToConsultan?->hasOneProfile?->no_telepon;

        $namaProyek = $pengajuan->hasOneDataPemohon?->nama_proyek;

        $notification = new EmailNotificationController();
        $notification->sendEmail($pengajuan->user_id, "Pengajuan proyek $namaProyek telah selesai.\nHarap mengunduh surat persetujuan!");
        $notification->sendEmail($pengajuan->hasOneDataPemohon?->belongsToConsultan?->id, "Pengajuan proyek $namaProyek telah selesai.\nHarap mengunduh surat persetujuan!");


        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://api.fonnte.com/send',
        //     CURLOPT_SSL_VERIFYPEER => FALSE,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => array(
        //         'target' => "$nomorHpPemohon, $nomorHpKonsultan", // nomer hp pemohon
        //         'message' => "Pengajuan proyek $namaProyek telah selesai.\nHarap mengunduh surat persetujuan!",
        //         'countryCode' => '62', //optional
        //     ),
        //     CURLOPT_HTTPHEADER => array(
        //         'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
    }

    public function kirimNotifikasiKeSemua($pengajuanID)
    {
        $pengajuan = Pengajuan::with('belongsToUser.hasOneProfile', 'hasOneDataPemohon', 'belongsToConsultan.hasOneProfile')->findorfail($pengajuanID);
        $nomorHpPemohon = $pengajuan->belongsToUser?->hasOneProfile?->no_telepon;

        $kasi = User::with('hasOneProfile')->where('role', 'kasi')->first();
        $nomorHpKasi = $kasi?->hasOneProfile?->no_telepon ?? '';

        $kabid = User::with('hasOneProfile')->where('role', 'kabid')->first();
        $nomorHpKabid = $kabid?->hasOneProfile?->no_telepon ?? '';

        $kadis = User::with('hasOneProfile')->where('role', 'kadis')->first();
        $nomorHPKadis = $kadis?->hasOneProfile?->no_telepon ?? '';

        $namaProyek = $pengajuan->hasOneDataPemohon?->nama_proyek;

        $roles = ['kasi', 'kabid', 'kadis'];
        $users = User::with('hasOneProfile')->whereIn('role', $roles)->get();

        $notification = new EmailNotificationController();
        foreach ($users as $user) {
            $notification->sendEmail($user->id, "Pengajuan proyek $namaProyek telah selesai.\nHarap mengunduh Laporan Dokumen Akhir!");
        }

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://api.fonnte.com/send',
        //     CURLOPT_SSL_VERIFYPEER => FALSE,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => array(
        //         'target' => "$nomorHpPemohon, $nomorHpKasi, $nomorHPKadis, $nomorHpKabid", // nomer hp
        //         'message' => "Pengajuan proyek $namaProyek telah selesai.\nHarap mengunduh Laporan Dokumen Akhir!",
        //         'countryCode' => '62', //optional
        //     ),
        //     CURLOPT_HTTPHEADER => array(
        //         'Authorization: 2Ap5o4gaEsJrHmNuhLDH' //change TOKEN to your actual token
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
    }
}
