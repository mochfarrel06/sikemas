<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resep Digital</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.6;
        }

        .center {
            text-align: center;
        }

        .header-logo {
            width: 80px;
            height: auto;
            margin: 0 auto 10px;
        }

        .info-table, .obat-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td {
            vertical-align: top;
            padding: 4px;
        }

        .obat-table th, .obat-table td {
            /* border: 1px solid #000; */
            padding: 6px;
            text-align: left;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature img {
            width: 120px;
        }

        .stamp {
            position: absolute;
            right: 100px;
            margin-top: 10px;
            z-index: 1;
            opacity: 0.5;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .info-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .info-header div {
            width: 48%;
        }
    </style>
</head>
<body>

    <div class="center">
        {{-- <img src="{{ public_path('logo.png') }}" alt="Logo" class="header-logo"> --}}
        <div class="title">Resep Digital</div>
    </div>

    <div style="margin-bottom: 5px; border-bottom: 1px solid #000; padding-bottom: 10px">
        <strong>No. Resep :</strong><br>{{ $medicalRecord->id }}
        <span style="float: right;">{{ \Carbon\Carbon::parse($medicalRecord->queue->tgl_periksa)->translatedFormat('j F Y') }}</span>
    </div>

    <table class="info-table" style="border-bottom: 1px solid #000; padding-bottom: 10px">
        <tr>
            <td>
                <strong>Dokter</strong><br>
                {{ $medicalRecord->queue->doctor->nama_depan }} {{ $medicalRecord->queue->doctor->nama_belakang }}<br>
                <strong>Pembayaran</strong><br>
                @if(!empty($medicalRecord->queue->patient->no_bpjs))
                BAYAR BPJS
                @else
                BAYAR TUNAI
                @endif<br>
                <strong>Poli</strong><br>
                {{ $medicalRecord->queue->doctor->specialization->name }}
            </td>
            <td>
                <strong>Pasien</strong><br>
                {{ $medicalRecord->queue->patient->nama_depan}} {{ $medicalRecord->queue->patient->nama_belakang}}<br>
                <strong>Jenis Kelamin</strong><br>
                {{ $medicalRecord->queue->patient->jenis_kelamin}}<<br>
                <strong>Usia</strong><br>
                {{ \Carbon\Carbon::parse($medicalRecord->queue->patient->tgl_lahir)->age }} Tahun
            </td>
        </tr>
    </table>

    @php
    $totalHarga = 0;
@endphp

<table class="obat-table" width="100%" border="1" cellspacing="0" cellpadding="8" style="border-collapse: collapse; font-size: 14px;">
    <thead>
        <tr>
            <th>Obat</th>
            <th>Aturan Pakai</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($medicalRecord->medicines as $medicine)
            <tr>
                <td>R/ {{ $medicine->name }}</td>
                <td>3 X Sehari</td>
                <td>Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
            </tr>
            @php
                $totalHarga += $medicine->price;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" style="text-align: right;">Total Harga</th>
            <th>Rp {{ number_format($totalHarga, 0, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>



    <div class="signature">
        <strong>Tanda tangan</strong>
        <br>
        <br>
        <br>
        <br>
        <strong>dr. Opik Ahmad Subakri</strong>
    </div>

</body>
</html>
