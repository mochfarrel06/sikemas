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
                    <td colspan="3"><strong>SIKEMAS</strong></td>
                </tr>
                <tr>
                    <td>Gula Darah Acak</td>
                    <td>{{ $medicalRecord->gula_darah_acak }}</td>
                    <td>&lt; 200 mg/dl</td>
                </tr>
                <tr>
                    <td>Gula Darah Puasa</td>
                    <td>{{ $medicalRecord->gula_darah_puasa }}</td>
                    <td>70-100 mg/dl</td>
                </tr>
                <tr>
                    <td>Gula Darah 2 jam PP</td>
                    <td>{{ $medicalRecord->gula_darah_2jm_pp }}</td>
                    <td>&lt; 140 mg/dl</td>
                </tr>
                <tr>
                    <td>Analisa Lemak</td>
                    <td>{{ $medicalRecord->analisa_lemak }}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Cholesterol</td>
                    <td>{{ $medicalRecord->cholesterol }}</td>
                    <td>&lt; 200 mg/dl</td>
                </tr>
                <tr>
                    <td>Trigliserida</td>
                    <td>{{ $medicalRecord->trigliserida }}</td>
                    <td>&lt; 150 mg/dl</td>
                </tr>
                <tr>
                    <td>HDL</td>
                    <td>{{ $medicalRecord->hdl }}</td>
                    <td>L: &gt;40 P: &gt;50 mg/dl</td>
                </tr>
                <tr>
                    <td>LDL</td>
                    <td>{{ $medicalRecord->ldl }}</td>
                    <td>&lt; 100 mg/dl</td>
                </tr>
                <tr>
                    <td>Asam Urat</td>
                    <td>{{ $medicalRecord->asam_urat }}</td>
                    <td>L: 3.5-7.2 P: 2.6-6.0 mg/dl</td>
                </tr>
                <tr>
                    <td>BUN</td>
                    <td>{{ $medicalRecord->bun }}</td>
                    <td>8-20 mg/dl</td>
                </tr>
                <tr>
                    <td>Creatinin</td>
                    <td>{{ $medicalRecord->creatinin }}</td>
                    <td>L: 0.7-1.2 P: 0.6-1.1 mg/dl</td>
                </tr>
                <tr>
                    <td>SGOT</td>
                    <td>{{ $medicalRecord->sgot }}</td>
                    <td>L: &lt;37 P: &lt;31 U/L</td>
                </tr>
                <tr>
                    <td>SGPT</td>
                    <td>{{ $medicalRecord->sgpt }}</td>
                    <td>L: &lt;41 P: &lt;31 U/L</td>
                </tr>

                <!-- URINE LENGKAP -->
                <tr>
                    <td colspan="3"><strong>URINE LENGKAP</strong></td>
                </tr>
                <tr>
                    <td>Warna</td>
                    <td>{{ $medicalRecord->warna }}</td>
                    <td>Kuning jernih</td>
                </tr>
                <tr>
                    <td>pH</td>
                    <td>{{ $medicalRecord->ph }}</td>
                    <td>4.8-7.4</td>
                </tr>
                <tr>
                    <td>Berat Jenis</td>
                    <td>{{ $medicalRecord->berat_jenis }}</td>
                    <td>1.015-1.025</td>
                </tr>
                <tr>
                    <td>Reduksi</td>
                    <td>{{ $medicalRecord->reduksi }}</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Protein</td>
                    <td>{{ $medicalRecord->protein }}</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Bilirubin</td>
                    <td>{{ $medicalRecord->bilirubin }}</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Urobilinogen</td>
                    <td>{{ $medicalRecord->urobilinogen }}</td>
                    <td>Normal</td>
                </tr>
                <tr>
                    <td>Nitrit</td>
                    <td>{{ $medicalRecord->nitrit }}</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Keton</td>
                    <td>{{ $medicalRecord->keton }}</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Sedimen Lekosit</td>
                    <td>{{ $medicalRecord->sedimen_lekosit }}</td>
                    <td>0-5 /lpb</td>
                </tr>
                <tr>
                    <td>Sedimen Eritrosit</td>
                    <td>{{ $medicalRecord->sedimen_eritrosit }}</td>
                    <td>0-2 /lpb</td>
                </tr>
                <tr>
                    <td>Sedimen Epitel</td>
                    <td>{{ $medicalRecord->sedimen_epitel }}</td>
                    <td>0-2 /lpb</td>
                </tr>
                <tr>
                    <td>Sedimen Kristal</td>
                    <td>{{ $medicalRecord->sedimen_kristal }}</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Sedimen Bakteri</td>
                    <td>{{ $medicalRecord->sedimen_bakteri }}</td>
                    <td>Negatif</td>
                </tr>

                <!-- DARAH LENGKAP -->
                <tr>
                    <td colspan="3"><strong>DARAH LENGKAP</strong></td>
                </tr>
                <tr>
                    <td>Hemoglobin</td>
                    <td>{{ $medicalRecord->hemoglobin }}</td>
                    <td>L:14-16 P:12-14 g/dl</td>
                </tr>
                <tr>
                    <td>Leukosit</td>
                    <td>{{ $medicalRecord->leukosit }}</td>
                    <td>4-10 ribu sel/mm3</td>
                </tr>
                <tr>
                    <td>Erytrosit</td>
                    <td>{{ $medicalRecord->erytrosit }}</td>
                    <td>4-5 juta sel/mm3</td>
                </tr>
                <tr>
                    <td>Trombosit</td>
                    <td>{{ $medicalRecord->trombosit }}</td>
                    <td>150-450 ribu sel/mm3</td>
                </tr>
                <tr>
                    <td>PCV/HCT</td>
                    <td>{{ $medicalRecord->pcv }}</td>
                    <td>L:40-48 P:38-43 Vol%</td>
                </tr>
                <tr>
                    <td>Diff Count</td>
                    <td>{{ $medicalRecord->dif }}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Bleeding Time</td>
                    <td>{{ $medicalRecord->bleeding_time }}</td>
                    <td>1-4 menit</td>
                </tr>
                <tr>
                    <td>Clotting Time</td>
                    <td>{{ $medicalRecord->clotting_time }}</td>
                    <td>2-6 menit</td>
                </tr>

                <!-- WIDAL SLIDE -->
                <tr>
                    <td colspan="3"><strong>WIDAL SLIDE</strong></td>
                </tr>
                <tr>
                    <td>Salmonella O</td>
                    <td>{{ $medicalRecord->salmonella_o }}</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Salmonella H</td>
                    <td>{{ $medicalRecord->salmonella_h }}</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Salmonella P, A</td>
                    <td>{{ $medicalRecord->salmonella_p_a }}</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Salmonella P, B</td>
                    <td>{{ $medicalRecord->salmonella_p_b }}</td>
                    <td>Negatif</td>
                </tr>

                <!-- SEROLOGI -->
                <tr>
                    <td colspan="3"><strong>SEROLOGI</strong></td>
                </tr>
                <tr>
                    <td>HbsAg</td>
                    <td>{{ $medicalRecord->hbsag }}</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>VDRL</td>
                    <td>{{ $medicalRecord->vdrl }}</td>
                    <td>Non Reaktif</td>
                </tr>
                <tr>
                    <td>Plano Test</td>
                    <td>{{ $medicalRecord->plano_test }}</td>
                    <td>Negatif</td>
                </tr>
            </tbody>
        </table>

        <!-- Diagnosis dan Catatan -->
        <div style="margin-top: 30px;">
            <h3>Diagnosis</h3>
            <p>{{ $medicalRecord->diagnosis }}</p>
            
            <h3>Resep</h3>
            <p>{{ $medicalRecord->resep }}</p>
            
            <h3>Catatan Medis</h3>
            <p>{{ $medicalRecord->catatan_medis }}</p>
        </div>

        <!-- Tanda Tangan -->
        <div style="margin-top: 50px; text-align: right;">
            <p>Dokter Pemeriksa</p>
            <br><br><br>
            <p style="text-decoration: underline;">{{ $medicalRecord->queue->doctor->nama_depan }} {{ $medicalRecord->queue->doctor->nama_belakang }}</p>
        </div>
    </div>
</body>

</html>