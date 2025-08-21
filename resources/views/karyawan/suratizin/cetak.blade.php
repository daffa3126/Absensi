<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Surat Izin Tidak Masuk Kerja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .judul {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .tanggal {
            text-align: right;
            margin-top: 20px;
        }

        .isi {
            margin-top: 20px;
            line-height: 1.6;
        }

        .ttd {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="judul">SURAT IZIN TIDAK MASUK KERJA</div>
    <hr>

    <div class="tanggal">
        {{ $surat->tempat ?? 'Jakarta' }}, {{ \Carbon\Carbon::parse($surat->tanggal)->translatedFormat('d F Y') }}
    </div>

    <div class="isi">
        Melalui surat ini, saya yang bertanda tangan di bawah ini:

        <table style="margin-top: 10px;">
            <tr>
                <td style="width: 150px;">Nama Lengkap</td>
                <td>: {{ $surat->user->name }}</td>
            </tr>
            <tr>
                <td>Alasan</td>
                <td>: {{ $surat->jenis ?? '-' }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: {{ $surat->status ?? '-' }}</td>
            </tr>
        </table>

        <p style="margin-top: 10px;">
            Bermaksud untuk memberitahukan bahwa saya tidak dapat masuk kerja pada
            {{ \Carbon\Carbon::parse($surat->tanggal)->translatedFormat('d F Y') }}
            dikarenakan <b>{{ strtolower($surat->alasan) }}<b>.
        </p>

        <p>Demikian surat izin ini saya buat dengan sebenarnya.</p>
    </div>

    <div class="ttd">
        Hormat saya,<br><br><br><br><br><br>
        {{ $surat->user->name }}
    </div>

</body>

</html>