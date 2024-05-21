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
            margin-left: 2cm;
            margin-right: 2cm;
            margin-top: 1.27cm;
            margin-bottom: 1.27cm;
            font-family: "Times New Roman", Times, serif;
        }

        table {
            border-collapse: collapse;
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

        .text-uppercase {
            text-transform: uppercase;
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

    <div class="text-center header" style="text-transform: uppercase;">
        <p style="line-height: 0.65cm">keputusan kepala dinas perhubungan kabupaten bantul
            <br>
            Nomor :
            Sk.{{ $nomor }}/{{ $ukuranMinimal }}/dishub-btl/{{ $bulanRoman }}/{{ $tahunInteger }}
        </p>
    </div>
    <p class="text-center" style="text-transform: uppercase; line-height: 0.65cm">
        Tahun {{ $tahunInteger }}
        <br>
        tentang
        <br>
        PERSETUJUAN {{ $ukuranMinimal }}
        DOKUMEN {{ $ukuranMinimal }} PENANGANAN DAMPAK LALU LINTAS {{ $jenisBangkitan }} PEMBANGUNAN DAN OPERASIONAL
        {{ $namaProyek }} <br>
        {{ $alamatProyek }}
    </p>

    <div>
        <p class="text-center">DINAS PERHUBUNGAN KABUPATEN BANTUL</p>
        <table border="1" style="text-align:justify">
            <tr>
                <td style="width: 15%; vertical-align:top; padding-top: 17.6px;">Menimbang</td>
                <td style="width: 2%; vertical-align:top; padding-top: 17.6px;">:</td>
                <td style="width: 83%; padding-right: 15px;">
                    <ol type="a" style="line-height: 19px">
                        <li>bahwa berdasarkan Pasal 52 Peraturan Pemerintah Nomor 32 Tahun 2011 tentang Manajemen dan
                            Rekayasa, Analisis Dampak, serta Manajemen Kebutuhan Lalu Lintas, telah diatur ketentuan
                            bahwa hasil analisis dampak lalu lintas di Jalan Kabupaten dan/atau Jalan Desa harus
                            mendapatkan persetujuan dari Bupati;
                        </li>
                        <li>
                            bahwa {{ $pengajuan->hasOnePemrakarsa->pemrakarsa }} telah mengajukan permohonan
                            persetujuan teknis
                            dengan Nomor
                            : {{ $pengajuan->hasOneDataPemohon->nomor_surat_permohonan }} tanggal
                            {{ $tanggalSuratPermohonan }} perihal Teknis Penanganan Dampak Lalu
                            Lintas {{ $jenisBangkitan }} Pembangunan dan Operasional {{ $namaProyek }};
                        </li>
                        <li>
                            bahwa Tim Evaluasi telah melakukan penilaian dan tinjauan lapangan terhadap Dokumen
                            {{ $ukuranMinimal }} Penanganan Dampak Lalu Lintas {{ $jenisBangkitan }} Pembangunan Dan
                            Operasional
                            {{ $namaProyek }}, {{ $alamatProyek }}
                        </li>
                        <li>
                            berdasarkan pertimbangan sebagaimana dimaksud pada huruf a, huruf b, dan huruf c, perlu
                            menetapkan Keputusan Kepala Dinas Perhubungan Kabupaten Bantul tentang Persetujuan
                            {{ $ukuranMinimal }} Penanganan Dampak Lalu Lintas {{ $jenisBangkitan }} Pembangunan Dan
                            Operasional
                            {{ $namaProyek }} Yang Berlokasi Di {{ $alamatProyek }}
                        </li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td style="width: 15%; vertical-align:top; padding-top: 17.6px;">Mengingat</td>
                <td style="width: 2%; vertical-align:top; padding-top: 17.6px;">:</td>
                <td style="width: 83%; padding-right: 15px;">
                    <ol type="1" style="line-height: 22px">
                        <li>
                            Undang-Undang Nomor 22 Tahun 2009 tentang Lalu Lintas dan Angkutan Jalan (Lembaran Negara
                            Republik Indonesia Tahun 2009 Nomor 96, Tambahan Lembaran Negara Republik Indonesia Nomor
                            5025);
                        </li>
                        <li>
                            Peraturan Pemerintah Nomor 32 Tahun 2011 tentang Manajemen dan Rekayasa, Analisis Dampak,
                            serta Manajemen Kebutuhan Lalu Lintas Jalan (Lembaran Negara Republik Indonesia Tahun 2011
                            Nomor 61, Tambahan Lembaran Negara Republik Indonesia Nomor 5221);
                        </li>
                        <li>
                            Peraturan Menteri Perhubungan Nomor PM 17 Tahun 2021 tentang Penyelenggaraan Analisis Dampak
                            Lalu Lintas ( Berita Negara Republik Indonesia Tahun 2021 Nomor 528);
                        </li>
                        <li>
                            Peraturan Daerah Kabupaten Bantul Nomor 19 Tahun 2015 Tentang Jaringan Lalu Lintas dan
                            Angkutan Jalan (Lembaran Daerah Kabupaten Bantul Tahun 2015 Nomor 19) sebagaimana telah
                            diubah dengan Peraturan Daerah Kabupaten Bantul Nomor 7 Tahun 2022 tentang Perubahan atas
                            Peraturan Daerah Kabupaten Bantul Nomor 19 Tahun 2015 Tentang Jaringan Lalu Lintas dan
                            Angkutan Jalan (Lembaran Daerah Kabupaten Bantul Tahun 2016 Nomor 7);
                        </li>
                        <li>
                            Peraturan Daerah Kabupaten Bantul Nomor 12 Tahun 2016 tentang Pembentukan dan Susunan
                            Perangkat Daerah Kabupaten Bantul (Lembaran Daerah Kabupaten Bantul Tahun 2016 Nomor 12,
                            Tambahan Lembaran Daerah Kabupaten Bantul Nomor 73) Sebagaimana telah diubah beberapa kali
                            dengan Peraturan Daerah Kabupaten Bantul Nomor 5 Tahun 2021 Tentang Pembentukan Susunan dan
                            Perangkat Daerah Kabupaten Bantul ( Lembaran Daerah Kabupaten Bantul Tahun 2021 Nomor 9 ,
                            Tambahan Lembaran Daerah Kabupaten Bantul Nomor 139)
                        </li>
                        <li>
                            Peraturan Bupati Bantul Nomor 118 Tahun 2022 Tentang Kedudukan, Susunan Organisasi, Tugas,
                            Fungsi dan Tata Kerja Dinas Perhubungan (Berita Daerah Kabupaten Bantul Tahun 2021 Nomor
                            98).
                        </li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td style="width: 15%; vertical-align:top; padding-top: 17.6px;">Memperhatikan</td>
                <td style="width: 2%; vertical-align:top; padding-top: 17.6px;">:</td>
                <td style="width: 83%; padding-right: 15px;">
                    <ol type="a" style="line-height: 23px">
                        <li>
                            berita acara Nomor
                            BA.0{{ $nomor }}/{{ $ukuranMinimal }}/DISHUB-BTL/{{ $bulanRoman }}/{{ $tahunInteger }}
                            tentang Penilaian Dokumen
                            {{ $ukuranMinimal }} Penanganan Dampak Lalu Lintas {{ $jenisBangkitan }} Pembangunan Dan
                            Operasional
                            {{ $namaProyek }} Yang Berlokasi Di {{ $alamatProyek }}
                        </li>
                        <li>
                            Surat Pernyataan Kesanggupan {{ $pengajuan->hasOnePemrakarsa->pemrakarsa }} Nomor :
                            {{ $pengajuan->hasOneDataPemohon->nomor_surat_permohonan }}
                            perihal Kesanggupan Melaksanakan Kewajiban dalam Rekomendasi {{ $ukuranMinimal }}
                            Penanganan
                            Dampak Lalu Lintas {{ $jenisBangkitan }} Pembangunan Dan Operasional {{ $namaProyek }}
                            Yang
                            Berlokasi Di {{ $alamatProyek }}
                        </li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">
                    <b>MEMUTUSKAN :</b>
                </td>
            </tr>
            <tr>
                <td style="width: 15%; vertical-align:top;">Menetapkan</td>
                <td style="width: 2%; vertical-align:top;">:</td>
                <td
                    style="width: 83%; padding-right: 15px; padding-left: 15px; line-height: 23px; text-transform:uppercase">
                    PERSETUJUAN {{ $ukuranMinimal }} TENTANG DOKUMEN {{ $ukuranMinimal }} PENANGANAN DAMPAK LALU
                    LINTAS
                    {{ $jenisBangkitan }} PEMBANGUNAN DAN OPERASIONAL {{ $namaProyek }} YANG BERLOKASI DI
                    {{ $namaProyek }}
                </td>
            </tr>
            <tr>
                <td style="width: 15%; vertical-align:top;">KESATU</td>
                <td style="width: 2%; vertical-align:top;">:</td>
                <td style="width: 83%; padding-right: 15px; padding-left: 15px; line-height: 23px">
                    Berdasarkan hasil penilaian/evaluasi dari Tim Evaluasi Dokumen Hasil Analisis Dampak Lalu Lintas
                    terhadap Dokumen Hasil Analisis Dampak Lalu Lintas yang diajukan oleh :
                    <table style="width: 100%">
                        <tr>
                            <td>Nama Pembangun</td>
                            <td>:</td>
                            <td>{{ $pengajuan->hasOnePemrakarsa->pemrakarsa }}</td>
                        </tr>
                        <tr>
                            <td>Penanggung Jawab</td>
                            <td>:</td>
                            <td>{{ $pengajuan->hasOnePemrakarsa->nama_penanggung_jawab }}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>{{ $pengajuan->hasOnePemrakarsa->jabatan }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{ $pengajuan->hasOnePemrakarsa->alamat }}</td>
                        </tr>
                        <tr>
                            <td>No Telp</td>
                            <td>:</td>
                            <td>{{ $pengajuan->hasOnePemrakarsa->no_telepon }}</td>
                        </tr>
                    </table>
                    dinyatakan telah memenuhi persyaratan untuk mendapatkan Persetujuan {{ $ukuranMinimal }} Tentang
                    Dokumen
                    {{ $ukuranMinimal }} Penanganan Dampak Lalu Lintas {{ $jenisBangkitan }} Pembangunan Dan
                    Operasional
                    Mikrosite
                    Indostation Yang Berlokasi Di {{ $namaProyek }} dengan luas lahan sebesar {{ $luasLahan }}
                    ({{ $terbilangLuasLahan }} meter persegi)
                </td>
            </tr>
            <tr>
                <td style="width: 15%; vertical-align:top;">KEDUA</td>
                <td style="width: 2%; vertical-align:top;">:</td>
                <td style="width: 83%; padding-right: 15px; padding-left: 15px; line-height: 23px">
                    <span class="text-uppercase">{{ $pengajuan->hasOnePemrakarsa->pemrakarsa }}</span> wajib
                    melaksanakan tanggungjawab sesuai Surat
                    Pernyataan Kesanggupan
                    sebagaimana tercantum dalam Lampiran yang merupakan bagian yang tidak terpisahkan dari Keputusan
                    ini.
                </td>
            </tr>
            <tr>
                <td style="width: 15%; vertical-align:top;">KETIGA</td>
                <td style="width: 2%; vertical-align:top;">:</td>
                <td style="width: 83%; padding-right: 15px; padding-left: 15px; line-height: 23px">
                    Apabila <span class="text-uppercase">{{ $pengajuan->hasOnePemrakarsa->pemrakarsa }}</span> tidak
                    dapat memenuhi kewajiban sebagaimana
                    dimaksud dalam DIKTUM
                    KEDUA dikenakan sanksi sesuai ketentuan dalam Peraturan Pemerintah Nomor 32 Tahun 2011 tentang
                    Manajemen dan Rekayasa, Analisis Dampak, serta Manajemen Kebutuhan Lalu Lintas.
                </td>
            </tr>
            <tr>
                <td style="width: 15%; vertical-align:top;">KEEMPAT</td>
                <td style="width: 2%; vertical-align:top;">:</td>
                <td style="width: 83%; padding-right: 15px; padding-left: 15px; line-height: 23px">
                    Surat rekomendasi persetujuan analisis dampak lalu lintas sebagaimana dimaksud dalam DIKTUM PERTAMA
                    akan berakhir dengan sendirinya dalam hal :
                    <ol>
                        <li>
                            pembangun tidak melaksanakan pembangunan dalam kurun waktu 2 (dua) tahun sejak diterbitkan
                            surat rekomendasi; dan/atau
                        </li>
                        <li>
                            pembangun tidak memenuhi salah satu rekomendasi yang tercantum dalam surat pernyataan
                            kesanggupan.
                        </li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td style="width: 15%; vertical-align:top;">KELIMA</td>
                <td style="width: 2%; vertical-align:top;">:</td>
                <td style="width: 83%; padding-right: 15px; padding-left: 15px; line-height: 23px">
                    Dinas Perhubungan Kabupaten Bantul melalui Tim Pengawas Pelaksanaan Persetujuan Analisis Dampak Lalu
                    Lintas melakukan pengawasan terhadap pemenuhan Persetujuan Hasil Analisis Dampak Lalu Lintas
                    Pembangunan & Operasional {{ $namaProyek }}.
                </td>
            </tr>
            <tr>
                <td style="width: 15%; vertical-align:top;">KEENAM</td>
                <td style="width: 2%; vertical-align:top;">:</td>
                <td style="width: 83%; padding-right: 15px; padding-left: 15px; line-height: 23px">
                    Apabila {{ $pengajuan->hasOnePemrakarsa->pemrakarsa }} melakukan pengembangan bangunan maka Dokumen
                    ini akan ditinjau
                    kembali sesuai dengan peraturan perundang-undangan yang berlaku.
                </td>
            </tr>
            <tr>
                <td style="width: 15%; vertical-align:top;">KETUJUH</td>
                <td style="width: 2%; vertical-align:top;">:</td>
                <td style="width: 83%; padding-right: 15px; padding-left: 15px; line-height: 23px">
                    Keputusan ini mulai berlaku pada tanggal ditetapkan.
                </td>
            </tr>
        </table>

        <div style="margin-top: 20px; page-break-inside:avoid">
            <table style="width: 100%">
                <tr>
                    <td style="width: 30%"></td>
                    <td style="width: 70%">
                        <table style="width: 100%">
                            <tr>
                                <td>Ditetapkan di</td>
                                <td>:</td>
                                <td>BANTUL</td>
                            </tr>
                            <tr>
                                <td>Pada tanggal</td>
                                <td>:</td>
                                <td>25 Oktober 2023</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: center">
                                    <br>
                                    KEPALA DINAS PERHUBUNGAN KABUPATEN BANTUL
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <b>
                                        <u>SINGGIH RIYADI, S.E., M.M.</u> <br>
                                        Pembina Tingkat I, IV/b <br>
                                        NIP. 197307211997031007
                                    </b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div>
                <p>
                    <u>
                        Keputusan ini disampaikan kepada:
                    </u>
                </p>
                <ol>
                    <li>Bupati Bantul;</li>
                    <li>Dinas Perhubungan Kabupaten Bantul</li>
                    <li>Dinas Pekerjaan Umum dan Perumahan Rakyat Kabupaten Bantul;</li>
                    <li>Polres Kabupaten Bantul;</li>
                    <li>{{ $pengajuan->hasOnePemrakarsa->pemrakarsa }} </li>
                    <li>Arsip.</li>
                </ol>
            </div>
        </div>
    </div>

    <div style="page-break-after: always"></div>

    <div>
        <table style="width: 100%">
            <tr>
                <td style="width: 50%"></td>
                <td style="width: 50%; text-align:justify; line-height: 0.75cm" class="text-uppercase">
                    KEPUTUSAN KEPALA DINAS PERHUBUNGAN KABUPATEN BANTUL <br>
                    Nomor : Sk.{{ $nomor }} / {{ $ukuranMinimal }} / dishub-btl /
                    {{ $bulanRoman }} /
                    {{ $tahunInteger }}
                    <br>
                    TAHUN 2023 <br>
                    TENTANG <br>
                    PERSETUJUAN {{ $ukuranMinimal }} <br>
                    DOKUMEN {{ $ukuranMinimal }} PENANGANAN DAMPAK LALU LINTAS {{ $jenisBangkitan }} PEMBANGUNAN DAN
                    OPERASIONAL
                    {{ $namaProyek }} <br>
                    {{ $alamatProyek }}
                </td>
            </tr>
        </table>

        <p class="text-center">
            KEWAJIBAN PIHAK PEMBANGUN
        </p>
        <p style="text-align: justify; line-height:0.7cm">
            <span class="text-uppercase">{{ $pengajuan->hasOnePemrakarsa->pemrakarsa }}</span> selaku Pembangun
            <b>wajib</b>
            melaksanakan ketentuan
            dalam Surat
            Pernyataan Kesanggupan,
            yaitu:
        </p>
        <p>
            <b>TAHAP PRAKONSTRUKSI</b>
        </p>
        <ol style="line-height: 0.7cm">
            <li>Memenuhi segala persyaratan perizinan yang diwajibkan sebelum melaksanakan pembangunan;</li>
            <li>Melakukan sosialisasi Kepada masyarakat sekitar yang terdampak terkait dengan adanya pelaksanaan
                kontruksi pembangunan <span class="text-uppercase">{{ $namaProyek }}</span>.</li>
        </ol>
        <p>
            <b>TAHAP KONSTRUKSI</b>
        </p>
        <ol style="line-height: 0.7cm">
            <li>
                Menyediakan akses masuk dan keluar untuk angkutan barang, dengan memberikan ruang yang cukup dan tidak
                menimbulkan tundaan perjalanan di jalan umum;
            </li>
            <li>Menyediakan petugas pengatur lalu lintas yang dilengkapi peralatan keselamatan selama jam operasional
                konstruksi untuk mengatur keluar masuk kendaraan proyek;</li>
            <li>Meningkatkan struktur jalan masuk kawasan pembangunan untuk mendukung mobilitas kendaraan material dan
                peralatan;
            </li>
            <li>
                Pengaturan material bangunan menghindari jam – jam sibuk dan pengangkutan dengan dimensi besar atau
                volume besar dilakukan di malam hari, agar tidak mengganggu arus lalu lintas pada rute yang dilalui;
            </li>
            <li>
                Membersihkan tapak roda kendaraan material sebelum keluar dari area pembangunan dan apabila terdapat
                ceceran material di badan jalan pemrakarsa bersedia untuk melakukan pembersihan;
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
                <ol type="a">
                    <li>
                        lampu peringatan (warning Light),
                    </li>
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
    </div>
    <div style="page-break-inside: avoid">
        <table style="width: 100%">
            <tr>
                <td style="width: 50%">

                </td>
                <td style="width: 50%; line-height:0.75cm;" class="text-center">
                    KEPALA DINAS PERHUBUNGAN <br>
                    KABUPATEN BANTUL
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <b>
                        <u>
                            SINGGIH RIYADI, S.E., M.M.
                        </u>
                        <br>
                        Pembina Tingkat I, IV/b
                        <br>
                        NIP. 197307211997031007
                    </b>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
