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
            font-family: 'Arial', sans-serif;
        }

        .logo {
            width: 3.5cm;
        }

        .aksara {
            width: 25%;
            margin-top: -20px;
        }

        .text-center {
            text-align: center;
        }

        .garis {
            border-top: 1px solid black;
            border-bottom: 5px solid black;
            padding: 1px 0;
            width: 92%;
        }

        .tanggal-surat {
            margin-top: 15px;
            width: 85%;
            /* border: 2px solid #3498db; */
            text-align: right
        }

        .kepada {
            margin-top: 15px;
            width: 73.5%;
            text-align: right
        }

        .nomor {
            margin-top: 15px;
            width: 85%;
            text-align: right
        }

        .isi {
            margin-top: 15px;
            width: 85%;
            /* border: 2px solid #3498db; */
            text-align: left
        }
    </style>
</head>

<body>
    {{-- KOP --}}
    <div>
        <table style="width: 92%">
            <tr>
                <td style="width: 15%">
                    <img src="{{ asset('img/kab-bantul.png') }}" class="logo">
                </td>
                <td class="text-center">
                    <p style="font-size: 16pt !important; margin-top: 0px;">
                        PEMERINTAH KABUPATEN BANTUL
                    </p>
                    <p style="font-size: 16pt !important; margin-top: -20px;">
                        <b>
                            DINAS PERHUBUNGAN
                        </b>
                    </p>
                    <p>
                        <img src="{{ asset('img/aksara-dishub.png') }}" class="aksara">
                    </p>
                    <p style="font-size: 12pt; margin-top: -20px;">
                        Jalan Lingkar Timur, Manding, Trirenggo, Bantul
                    </p>
                    <p style="font-size: 12pt; margin-top: -10px;">Telp. (0274)-367321</p>
                    <p style="font-size: 12pt; margin-top: -10px;">Email: dishub@bantulkab.go.id</p>
                    <p style="font-size: 12pt; margin-top: -10px;">Website: http://dishub.bantulkab.go.id</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- garis tebal --}}
    <div class="garis">
    </div>

    {{-- tanggal --}}
    <div class="tanggal-surat">
        Bantul, 22 Januari 2024
    </div>

    <div class="nomor">
        <div style="float: left; width: 45%;">
            <table style="width: 100%; text-align: left !important;">
                <tr>
                    <td style="width: 20%">Nomor</td>
                    <td>:</td>
                    <td>Disini Nomor</td>
                </tr>
                <tr>
                    <td style="width: 20%">Sifat</td>
                    <td>:</td>
                    <td>Disini Sifat</td>
                </tr>
                <tr>
                    <td style="width: 20%">Lampiran</td>
                    <td>:</td>
                    <td>..........</td>
                </tr>
                <tr>
                    <td style="width: 20%">Hal</td>
                    <td>:</td>
                    <td>Jadwal Tinjauan Lapangan</td>
                </tr>
            </table>
        </div>
        <div class="tabel-2" style="float: right; width: 40%;">
            <table style="width: 100%; text-align: left !important;">
                <tr>
                    <td style="width: 10%">
                        Kepada
                        <br>
                        Yth.
                        <br>
                        <ol>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ol>
                        di - <u>Bantul</u>
                    </td>
                </tr>
            </table>
        </div>
        <div style="clear: both;"></div> <!-- Untuk membersihkan float -->
    </div>

    <div class="isi">
        <p style="text-indent: 30px;">
            Mengharap kehadiran Bapak/Ibu/Saudara/i dalam acara yang akan
            diselenggarakan pada:
        </p>
        <table style="width: 92%; margin-left: 100px">
            <tr>
                <td style="width: 10%">Hari</td>
                <td style="width: 2%">:</td>
                <td>Kamis</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>25 Januari 2024</td>
            </tr>
            <tr>
                <td>Pukul</td>
                <td>:</td>
                <td>09.00 WIB</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>:</td>
                <td>Lapangan</td>
            </tr>
            <tr>
                <td>Acara</td>
                <td>:</td>
                <td>Tinjauan Lapangan</td>
            </tr>
        </table>
        <p style="text-indent: 30px">
            Atas perhatian dan kehadirannya diucapkan terimakasih.
        </p>
    </div>
</body>

</html>
