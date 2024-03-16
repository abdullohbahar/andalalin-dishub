<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

        }

        body {
            margin: 1.2cm 1.2cm 1.2cm 1.2cm;
            font-family: "Times New Roman", Times, serif;
        }

        .header {
            font-family: "Bookman Old Style", Times, serif;
            font-size: 11pt;
        }

        .logo {
            width: 1.8cm;
            height: 2.7cm;
        }

        .aksara {
            width: 32%;
            margin-top: -12px;
        }

        .text-center {
            text-align: center;
        }

        .garis {
            border-top: 4px solid black;
            border-bottom: 1px solid black;
            padding: 1px 0;
            width: 100%;
        }
    </style>
</head>

<body>
    {{-- KOP --}}
    <div>
        <table style="width: 100%">
            <tr>
                <td style="width: 15%">
                    <img src="data:image/jpeg;base64,{{ $logo }}" class="logo">
                </td>
                <td class="text-center">
                    <p style="font-size: 13pt !important; margin-top: 0px;">
                        PEMERINTAH KABUPATEN BANTUL
                    </p>
                    <p style="font-size: 13pt !important; margin-top: -15px;">
                        <b>
                            DINAS PERHUBUNGAN
                        </b>
                    </p>
                    <p>
                        <img src="data:image/jpeg;base64,{{ $aksara }}" class="aksara">
                    </p>
                    <p style="font-size: 13pt; margin-top: -15px;">
                        Alamat : Jl. Lingkar Timur Manding Trirenggo Bantul, Telp. (0274) 367321
                    </p>
                    <p style="font-size: 13pt; margin-top: -10px;">Email: dishub@bantulkab.go.id, Website:
                        http://dishub.bantulkab.go.id</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- garis tebal --}}
    <div class="garis">
    </div>

    <div class="text-center header" style="font-weight: bold;  text-transform: uppercase;">
        <p style="line-height: 0.7cm">
            BERITA ACARA PEMERIKSAAN <br>
            DOKUMEN {{ $ukuranMinimal }} <br>
            PENANGANAN DAMPAK LALU LINTAS {{ $jenisBangkitan }} PEMBANGUNAN DAN OPERASIONAL <br>
            {{ $namaProyek }} <br>
            {{ $alamatProyek }} <br>
            No : BA.01/ {{ $ukuranMinimal }} /DISHUB-BTL/{{ $yearNow }}
        </p>
    </div>

    <div style="text-align: justify">
        <p>
            Pada hari ini <span style="text-transform: capitalize">{{ $hari }} Tanggal {{ $tanggal }} Bulan
                {{ $bulan }} Tahun
                {{ $tahun }}</span>, bertempat di
            Bantul, kami yang bertandatangan di bawah ini :
        </p>
        <table style="width: 100%;" border="1">
            <tr>
                <td style="width: 5%" class="text-center">No</td>
                <td style="width: 40%;" class="text-center">Nama</td>
                <td class="text-center">Jabatan</td>
            </tr>
            <?php $no = 1; ?>
            @foreach ($penilais as $penilai)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $penilai->hasOneProfile->nama }}</td>
                    <td style="text-transform: capitalize">{{ $penilai->role }}</td>
                </tr>
            @endforeach
        </table>
        <p>
            Bertindak sebagai Penilai Dokumen Analisis Dampak Lalu Lintas berdasarkan :
        </p>
        <ol type="a" style="line-height: 1.6">
            <li>Undang-undang RI nomor 22 tahun 2009 tentang Lalu Lintas Angkutan Jalan dan Angkutan Jalan ;</li>
            <li>Undang-Undang Nomor 11 Tahun 2020 Tentang Cipta Kerja;</li>
            <li>Peraturan Pemerintah Nomor 5 Tahun 2021 Tentang Penyelenggaraan Perizinan Berusaha Berbasis Risiko;</li>
            <li>Peraturan Pemerintah Nomor 30 Tahun 2021 Tentang Penyelenggaraan Bidang Lalu Lintas Angkutan Jalan;</li>
            <li>Peraturan Menteri Nomor 17 Tahun 2021 Tentang Penyelenggaraan Analisis Dampak Lalu Lintas;</li>
            <li>Surat permohonan Pesetujuan Standar Teknis/Rekomendasi Teknis/ Andalalin atas Dokumen Standar Teknis/
                Rekomendasi Teknis/ Andalalin Penanganan Dampak Lalu Lintas Bangkitan Rendah/ Bangkitan Sedang/
                Bangkitan Tinggi Pembangunan Dan Operasional Mikrosite Indostation, Jalan Wachid Hasyim, Sumuran Rt 004
                Prsl: 06203, Kalurahan Palbapang, Kapanewon Bantul, Kabupaten Bantul, Daerah Istimewa Yogyakarta;</li>
            <li>
                Dokumen Standar Teknis/Rekomendasi Teknis/ Andalalin Penanganan Dampak Lalu Lintas Bangkitan Rendah/
                Bangkitan Sedang/ Bangkitan Tinggi Pembangunan Dan Operasional Mikrosite Indostation, Jalan Wachid
                Hasyim, Sumuran Rt 004 Prsl: 06203, Kalurahan Palbapang, Kapanewon Bantul, Kabupaten Bantul, Daerah
                Istimewa Yogyakarta.
            </li>
        </ol>
        <p style="line-height: 1.6">
            Telah mengadakan penelitian dan penilaian Dokumen Standar Teknis/Rekomendasi Teknis/ Andalalin Penanganan
            Dampak Lalu Lintas Bangkitan Rendah/ Bangkitan Sedang/ Bangkitan Tinggi Pembangunan Dan Operasional
            Mikrosite Indostation, Jalan Wachid Hasyim, Sumuran Rt 004 Prsl: 06203, Kalurahan Palbapang, Kapanewon
            Bantul, Kabupaten Bantul, Daerah Istimewa Yogyakarta dengan luas lahan 211,47 m2 dengan luas bangunan 44 m2.
            Dalam berita acara tersebut pemerakarsa sanggup untuk melakukan manajemen rekayasa meliputi :
        </p>
        <p>
            <b>TAHAP PRAKONSTRUKSI</b>
        </p>
        <ol style="line-height: 1.6">
            <li>Memenuhi segala persyaratan perizinan yang diwajibkan sebelum melaksanakan pembangunan; </li>
            <li>Melakukan sosialisasi Kepada masyarakat sekitar yang terdampak terkait dengan adanya pelaksanaan
                kontruksi pembangunan MIKROSITE INDOSTASION.</li>
        </ol>
        <p>
            <b>TAHAP KONSTRUKSI</b>
        </p>
        <ol style="line-height: 1.6">
            <li>Menyediakan akses masuk dan keluar untuk angkutan barang, dengan memberikan ruang yang cukup dan tidak
                menimbulkan tundaan perjalanan di jalan umum;</li>
            <li>
                Menyediakan petugas pengatur lalu lintas yang dilengkapi peralatan keselamatan selama jam operasional
                konstruksi untuk mengatur keluar masuk kendaraan proyek;
            </li>
            <li>
                Meningkatkan struktur jalan masuk kawasan pembangunan untuk mendukung mobilitas kendaraan material dan
                peralatan;
            </li>
            <li>
                Pengaturan material bangunan menghindari jam – jam sibuk dan pengangkutan dengan dimensi besar atau
                volume besar dilakukan di malam hari, agar tidak mengganggu arus lalu lintas pada rute yang dilalui;
            </li>
            <li>
                Membersihkan tapak roda kendaraan material sebelum keluar dari area pembangunan dan apabila terdapat
                ceceran material di badan jalan kami bersedia untuk melakukan pembersihan;
            </li>
            <li>
                Proses pengangkutan diharuskan tidak mengganggu lingkungan, kendaraan wajib dengan penutup yang memadai;
            </li>
            <li>
                Menggunakan kendaraan angkutan barang (pengangkut material dan peralatan konstruksi) sesuai dengan daya
                dukung jalan terendah pada jalur pengangkutan;
            </li>
            <li>
                Memberikan penyuluhan SOP pengangkutan sesuai Peraturan Pemerintah Nomor PM. 60 Tahun 2019 tentang
                penyelenggaraan angkutan barang dengan kendaraan bermotor di jalan;
            </li>
            <li>
                Menyediakan fasilitas bongkar/muat barang di dalam lokasi pembangunan, tidak menggunakan menggunakan
                badan jalan serta menempatkan bangunan di dalam lokasi pembangunan;
            </li>
            <li>
                Menyediakan ruang parkir di dalam lokasi pembangunan yang cukup mengakomodir parkir Truk (dan angkutan
                barang lainnya) dan pekerja. Dilarang parkir di badan jalan, agar tidak mengurangi kapasitas jalan yang
                ada dan tidak mengganggu arus lalu lintas;
            </li>
            <li>
                Menyediakan/memasang fasilitas perlengkapan jalan pada area pembangunan meliputi :
                <ol type="a" style="line-height: 1.6">
                    <li>lampu peringatan (warning Light),</li>
                    <li>
                        rambu lalu lintas sementara (rambu peringatan Hati – hati dengan papan tambahan ada pekerjaan
                        kontruksi dan keluar masuk kendaraan material),
                    </li>
                    <li>
                        lampu penerangan jalan (apabila terdapat kegiatan konstruksi pada malam hari,
                    </li>
                    <li>
                        papan informasi layanan aduan yang dipasang di depan Kawasan pembangunan;
                    </li>
                </ol>
            </li>
            <li>
                Memastikan bahwa kendaraan barang pengangkut bahan material tidak Over Dimension over load;
            </li>
            <li>
                Memperbaiki jalan yang rusak akibat dari pelaksanaan konstruksi;
            </li>
            <li>
                Berkoordinasi dengan instansi terkait.
            </li>
            <li>
                Menyediakan Sumur Resapan untuk pembuangan air dan drainase
            </li>
        </ol>
        <p>
            <b>TAHAP OPERASIONAL</b>
        </p>
        {!! $tahapOperasional !!}
        <p style="line-height: 1.6">
            Demikian berita acara ini dibuat, menjadi bagian yang tidak terpisahkan dengan Dokumen {{ $ukuranMinimal }}
            Penanganan Dampak Lalu Lintas {{ $jenisBangkitan }} Pembangunan Dan Operasional {{ $namaProyek }},
            {{ $alamatProyek }}. Pemrakarsa
            wajib melakukan ketentuan yang tertuang didalam berita acara ini.
        </p>
        <div class="text-center">
            Pemeriksa/Penilai
        </div>
        {{-- disini ada tanda tangan --}}
        <table style="width: 100%;" border="1">
            <tr>
                <td style="width: 5%" class="text-center">No</td>
                <td style="width: 40%;" class="text-center">Nama</td>
                <td class="text-center">Jabatan</td>
                <td class="text-center">Tanda Tangan</td>
            </tr>
            <?php $no = 1; ?>
            @foreach ($penilais as $penilai)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $penilai->hasOneProfile->nama }}</td>
                    <td style="text-transform: capitalize">{{ $penilai->role }}</td>
                    <td></td>
                </tr>
            @endforeach
        </table>
    </div>

</body>

</html>
