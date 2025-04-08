<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis - {{ $medicalRecord->patient->nama_depan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .header {
            margin-bottom: 20px;
        }

        .header .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .info {
            margin-bottom: 10px;
        }
        .info label {
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }

        .table-header {
            width: 100%;
            border-collapse: collapse;
            padding: 0;
        }

        .table-header, .table-header th, .table-header td {
            border: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">REKAM MEDIS PASIEN</h1>
        <table class="table">
            <tr>
                <td style="width: 50%; vertical-align: top;">KLINIK GIGI DENTHIS PLUS</td>
                <td style="width: 50%; padding: 0">
                    <table class="table-header">
                        <tr>
                            <td style="width: 25%; padding: 4px">Nama</td>
                            <td style="padding: 4px">: {{ $medicalRecord->user->nama_depan }} {{ $medicalRecord->user->nama_belakang }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%; padding: 4px">Umur</td>
                            <td style="padding: 4px">: {{ \Carbon\Carbon::parse($medicalRecord->queue->patient->tgl_lahir)->age }} tahun</td>
                        </tr>
                        <tr>
                            <td style="width: 25%; padding: 4px">Alamat</td>
                            <td style="padding: 4px">: {{ $medicalRecord->queue->patient->alamat }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%; padding: 4px">Tgl Periksa</td>
                            <td style="padding: 4px">: {{ $medicalRecord->queue->tgl_periksa }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <table class="table" style="margin-bottom: 10px">
        <tr>
            <td style="width: 20%; vertical-align: top;">Keluhan Pasien:</td>
            <td>{{ $medicalRecord->queue->keterangan }}</td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <th style="width: 20%;"">Diagnosis</th>
            <td>{{ $medicalRecord->diagnosis }}</td>
        </tr>
        <tr>
            <th style="width: 20%;"">Resep</th>
            <td>{{ $medicalRecord->resep }}</td>
        </tr>
        <tr>
            <th style="width: 20%;"">Catatan Medis</th>
            <td>{{ $medicalRecord->catatan_medis }}</td>
        </tr>
    </table>
</body>
</html>
