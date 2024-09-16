<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div style="text-align: center">
        <b>
            <span style="font-size: 18pt">
                Dokumen
                {{ $tipe }}
            </span>
        </b>
        <br>
        <b>
            <span style="font-size: 14pt">
                Penanganan Dampak Lalu Lintas {{ $jenisBangkitan }} <br>
                Pembangunan & Operasional {{ $pengajuan->hasOneDataPemohon?->nama_proyek }}
            </span>
        </b>
        <br>
        <span style="font-size: 12pt">
            {{ $pengajuan->hasOneDataPemohon?->alamat }}
        </span>
        <img src="data:image/jpeg;base64,{{ $logoDishub }}" style="width: 100%" class="logo">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <span style="font-size: 18pt">
            {{ $pengajuan->hasOnePemrakarsa->pemrakarsa }}
        </span>
        <br>
        <span style="font-size: 12pt">
            {{ $pengajuan->hasOnePemrakarsa->alamat }}
        </span>
    </div>
</body>

</html>
