<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .table {
            width: 100%;
            margin-top: 10px;
        }
        .text-center {
            text-align: center;
        }
        .no-border {
            border: none;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <strong>SIKEMAS</strong><br>
        <strong>Nota Pembaayaran</strong><br>
        {{-- <small>Jl. Raya Malangbong - Tasikmalaya Kp. Cisurupan RT.001 RW.001 Ds. Sukamanah</small><br>
        <small>Telp. (0262) 421 028 Email: puskesmas_malangbong@yahoo.com</small> --}}
    </div>

    {{-- <p style="text-align: right;">Garut, {{ now()->format('d F Y') }}</p> --}}

    <p>Nama : {{ $transaction->medicalRecord->queue->patient->nama_depan ?? '-' }}</p>
    <p>Umur : {{ \Carbon\Carbon::parse($transaction->medicalRecord->queue->patient->tgl_lahir)->age ?? '-' }} tahun</p>
    <p>Alamat : {{ $transaction->medicalRecord->queue->patient->alamat ?? '-' }}</p>
    <p>Poli : {{ $transaction->medicalRecord->queue->doctor->specialization->name }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pemeriksaan</th>
                <th>Rp.</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($transaction->medicalRecord->medicines as $index => $medicine)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $medicine->name }}</td>
                    <td>Rp.</td>
                    <td>{{ number_format($medicine->price, 0, ',', '.') }}</td>
                </tr>
                @php $total += $medicine->price; @endphp
            @endforeach
            {{-- Baris kosong tambahan seperti contoh --}}
            @for ($i = $transaction->medicalRecord->medicines->count() + 1; $i <= 10; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>......................................</td>
                    <td>Rp.</td>
                    <td>...................</td>
                </tr>
            @endfor
            <tr>
                <th colspan="2">Jumlah</th>
                <th>Rp.</th>
                <th>{{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <br><br>
    <table class="no-border" style="width: 100%;">
        <tr>
            <td class="text-center">Yang Memeriksa</td>
            <td class="text-center">Yang Menerima</td>
        </tr>
        <tr>
            <td height="70" class="text-center">(...........................)</td>
            <td class="text-center">(...........................)</td>
        </tr>
    </table>
</body>
</html>
