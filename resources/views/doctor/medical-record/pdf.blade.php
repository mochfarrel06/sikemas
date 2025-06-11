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

        /* Tabel 1 */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
        }

        /* Tabel 2 */
        .table-header {
            width: 100%;
            border-collapse: collapse;
            padding: 0;
        }

        .table-header,
        .table-header th,
        .table-header td {
            border: none;
        }

        /* Tabel 3 */
        .table-up {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-up th,
        .table-up td {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <table class="table-up">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table class="table-header">
                        <tr>
                            <td style="width: 25%; padding: 4px">Nama</td>
                            <td style="padding: 4px">: {{ $medicalRecord->user->nama_depan }}
                                {{ $medicalRecord->user->nama_belakang }}</td>
                        </tr>
                        <tr>
                            <td style="width: 25%; padding: 4px">Umur</td>
                            <td style="padding: 4px">:
                                {{ \Carbon\Carbon::parse($medicalRecord->queue->patient->tgl_lahir)->age }} tahun</td>
                        </tr>
                        <tr>
                            <td style="width: 25%; padding: 4px">Alamat</td>
                            <td style="padding: 4px">: {{ $medicalRecord->queue->patient->alamat }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; padding: 0">
                    <table class="table-header">
                        <tr>
                            <td style="width: 40%; padding: 4px">Poli</td>
                            <td style="padding: 4px">: {{ $medicalRecord->queue->doctor->specialization->name }}</td>
                        </tr>
                        <tr>
                            <td style="width: 40%; padding: 4px">No. Rekam Medis</td>
                            <td style="padding: 4px">: {{ $medicalRecord->id }}</td>
                        </tr>
                        <tr>
                            <td style="width: 40%; padding: 4px">Tgl Pemeriksaan</td>
                            <td style="padding: 4px">: {{ $medicalRecord->queue->tgl_periksa }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <h3 style="text-align:center; margin-top: 30px;">Hasil Pemeriksaan Laboratorium</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Jenis Pemeriksaan</th>
                    <th>Hasil</th>
                    <th>Nilai Normal</th>
                </tr>
            </thead>
            <tbody>
                <!-- KIMIA KLINIK -->
                <tr>
                    <td colspan="3"><strong>KIMIA KLINIK</strong></td>
                </tr>
                <tr>
                    <td>Gula Darah Acak</td>
                    <td></td>
                    <td>{{ $medicalRecord->gula_darah_acak }}</td>
                </tr>
                <tr>
                    <td>Gula Darah Puasa</td>
                    <td></td>
                    <td>{{ $medicalRecord->gula_darah_puasa }}</td>
                </tr>
                <tr>
                    <td>Gula Darah 2 jam PP</td>
                    <td></td>
                    <td>{{ $medicalRecord->gula_darah_2jm_pp }}</td>
                </tr>
                <tr>
                    <td>Cholesterol</td>
                    <td></td>
                    <td>{{ $medicalRecord->cholesterol }}</td>
                </tr>
                <tr>
                    <td>Trigliserida</td>
                    <td></td>
                    <td>{{ $medicalRecord->trigliserida }}</td>
                </tr>
                <tr>
                    <td>HDL</td>
                    <td></td>
                    <td>{{ $medicalRecord->hdl }}</td>
                </tr>
                <tr>
                    <td>LDL</td>
                    <td></td>
                    <td>{{ $medicalRecord->ldl }}</td>
                </tr>
                <tr>
                    <td>Asam Urat</td>
                    <td></td>
                    <td>{{ $medicalRecord->asam_urat }}</td>
                </tr>
                <tr>
                    <td>BUN</td>
                    <td></td>
                    <td>{{ $medicalRecord->bun }}</td>
                </tr>
                <tr>
                    <td>Creatinin</td>
                    <td></td>
                    <td>{{ $medicalRecord->creatinin }}</td>
                </tr>
                <tr>
                    <td>SGOT</td>
                    <td></td>
                    <td>{{ $medicalRecord->sgot }}</td>
                </tr>
                <tr>
                    <td>SGPT</td>
                    <td></td>
                    <td>{{ $medicalRecord->sgpt }}</td>
                </tr>

                <!-- DARAH LENGKAP -->
                <tr>
                    <td colspan="3"><strong>DARAH LENGKAP</strong></td>
                </tr>
                <tr>
                    <td>Hemoglobin</td>
                    <td>16.3</td>
                    <td>L:14-16 P:12-14 g/dl</td>
                </tr>
                <tr>
                    <td>Leukosit</td>
                    <td>2.700</td>
                    <td>4-10 ribu sel/mm3</td>
                </tr>
                <tr>
                    <td>Erytrosit</td>
                    <td>5.020.000</td>
                    <td>4-5 juta sel/mm3</td>
                </tr>
                <tr>
                    <td>Trombosit</td>
                    <td>81.000</td>
                    <td>150-450 ribu sel/mm3</td>
                </tr>
                <tr>
                    <td>PCV/HCT</td>
                    <td>46.0</td>
                    <td>L:40-48 P:38-43 Vol%</td>
                </tr>

                <!-- WIDAL SLIDE -->
                <tr>
                    <td colspan="3"><strong>WIDAL SLIDE</strong></td>
                </tr>
                <tr>
                    <td>Salmonella O</td>
                    <td>Neg</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Salmonella H</td>
                    <td>Neg</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Salmonella P, A</td>
                    <td>Neg</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Salmonella P, B</td>
                    <td>Neg</td>
                    <td></td>
                </tr>

                <!-- HbsAg -->
                <tr>
                    <td>HbsAg</td>
                    <td>Negatif</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>
</body>

</html>
