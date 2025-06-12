<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis - Hasil Pemeriksaan Laboratorium</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            background-color: #f9f9f9;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #2c5aa0;
            padding-bottom: 20px;
        }

        .header .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #2c5aa0;
            margin-bottom: 20px;
        }

        .subtitle {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }

        /* Tabel Info Pasien */
        .table-up {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table-header {
            width: 100%;
            border-collapse: collapse;
        }

        .table-header td {
            padding: 8px 4px;
            vertical-align: top;
        }

        .patient-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Tabel Hasil Lab */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 10px 8px;
            text-align: left;
        }

        .table th {
            background-color: #2c5aa0;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tr:hover {
            background-color: #e8f4f8;
        }

        .section-header {
            background-color: #e3f2fd !important;
            font-weight: bold;
            color: #1976d2;
        }

        .section-header td {
            text-align: center;
            font-size: 14px;
            padding: 12px;
        }

        .abnormal {
            background-color: #ffebee !important;
            color: #c62828;
            font-weight: bold;
        }

        .normal {
            color: #2e7d32;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .doctor-signature {
            margin-top: 40px;
            text-align: right;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }

        @media print {
            body {
                background-color: white;
                margin: 0;
            }
            .container {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="title">RUMAH SAKIT UMUM</div>
            <div class="subtitle">Hasil Pemeriksaan Laboratorium</div>
        </div>

        <div class="patient-info">
            <table class="table-up">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table class="table-header">
                            <tr>
                                <td style="width: 30%; font-weight: bold;">Nama</td>
                                <td>: <span id="patient-name">John Doe</span></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">Umur</td>
                                <td>: <span id="patient-age">35</span> tahun</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">Alamat</td>
                                <td>: <span id="patient-address">Jl. Contoh No. 123, Kediri</span></td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table class="table-header">
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Poli</td>
                                <td>: <span id="poli-name">Poli Umum</span></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">No. Rekam Medis</td>
                                <td>: <span id="medical-record-id">20</span></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">Tgl Pemeriksaan</td>
                                <td>: <span id="examination-date">2025-06-12</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 40%;">Jenis Pemeriksaan</th>
                    <th style="width: 20%;">Hasil</th>
                    <th style="width: 40%;">Nilai Normal</th>
                </tr>
            </thead>
            <tbody>
                <!-- KIMIA KLINIK -->
                <tr class="section-header">
                    <td colspan="3">KIMIA KLINIK</td>
                </tr>
                <tr>
                    <td>Gula Darah Acak</td>
                    <td class="normal">95 mg/dL</td>
                    <td>&lt; 200 mg/dL</td>
                </tr>
                <tr>
                    <td>Gula Darah Puasa</td>
                    <td class="normal">85 mg/dL</td>
                    <td>70-100 mg/dL</td>
                </tr>
                <tr>
                    <td>Gula Darah 2 jam PP</td>
                    <td class="normal">120 mg/dL</td>
                    <td>&lt; 140 mg/dL</td>
                </tr>
                <tr>
                    <td>Cholesterol Total</td>
                    <td class="normal">180 mg/dL</td>
                    <td>&lt; 200 mg/dL</td>
                </tr>
                <tr>
                    <td>Trigliserida</td>
                    <td class="normal">120 mg/dL</td>
                    <td>&lt; 150 mg/dL</td>
                </tr>
                <tr>
                    <td>HDL Cholesterol</td>
                    <td class="normal">55 mg/dL</td>
                    <td>L: &gt;40, P: &gt;50 mg/dL</td>
                </tr>
                <tr>
                    <td>LDL Cholesterol</td>
                    <td class="normal">110 mg/dL</td>
                    <td>&lt; 130 mg/dL</td>
                </tr>
                <tr>
                    <td>Asam Urat</td>
                    <td class="normal">5.5 mg/dL</td>
                    <td>L: 3.5-7.0, P: 2.6-6.0 mg/dL</td>
                </tr>
                <tr>
                    <td>BUN (Blood Urea Nitrogen)</td>
                    <td class="normal">15 mg/dL</td>
                    <td>8-25 mg/dL</td>
                </tr>
                <tr>
                    <td>Creatinin</td>
                    <td class="normal">0.9 mg/dL</td>
                    <td>L: 0.7-1.3, P: 0.6-1.1 mg/dL</td>
                </tr>
                <tr>
                    <td>SGOT (AST)</td>
                    <td class="normal">25 U/L</td>
                    <td>&lt; 40 U/L</td>
                </tr>
                <tr>
                    <td>SGPT (ALT)</td>
                    <td class="normal">28 U/L</td>
                    <td>&lt; 40 U/L</td>
                </tr>

                <!-- HEMATOLOGI -->
                <tr class="section-header">
                    <td colspan="3">HEMATOLOGI (DARAH LENGKAP)</td>
                </tr>
                <tr>
                    <td>Hemoglobin</td>
                    <td class="normal">16.3 g/dL</td>
                    <td>L: 14-16, P: 12-14 g/dL</td>
                </tr>
                <tr>
                    <td>Leukosit</td>
                    <td class="abnormal">2.700 /mm³</td>
                    <td>4.000-10.000 /mm³</td>
                </tr>
                <tr>
                    <td>Eritrosit</td>
                    <td class="normal">5.020.000 /mm³</td>
                    <td>4.000.000-5.000.000 /mm³</td>
                </tr>
                <tr>
                    <td>Trombosit</td>
                    <td class="abnormal">81.000 /mm³</td>
                    <td>150.000-450.000 /mm³</td>
                </tr>
                <tr>
                    <td>PCV/HCT</td>
                    <td class="normal">46.0 %</td>
                    <td>L: 40-48, P: 38-43 %</td>
                </tr>

                <!-- URINALISIS -->
                <tr class="section-header">
                    <td colspan="3">URINALISIS</td>
                </tr>
                <tr>
                    <td>Warna</td>
                    <td class="normal">Kuning Jernih</td>
                    <td>Kuning Jernih</td>
                </tr>
                <tr>
                    <td>pH</td>
                    <td class="normal">6.0</td>
                    <td>5.0-8.0</td>
                </tr>
                <tr>
                    <td>Berat Jenis</td>
                    <td class="normal">1.020</td>
                    <td>1.005-1.030</td>
                </tr>
                <tr>
                    <td>Protein</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Glukosa/Reduksi</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Bilirubin</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Urobilinogen</td>
                    <td class="normal">Normal</td>
                    <td>Normal</td>
                </tr>
                <tr>
                    <td>Nitrit</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Keton</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>

                <!-- SEDIMEN URIN -->
                <tr class="section-header">
                    <td colspan="3">SEDIMEN URIN</td>
                </tr>
                <tr>
                    <td>Leukosit</td>
                    <td class="normal">1-2 /lpb</td>
                    <td>&lt; 5 /lpb</td>
                </tr>
                <tr>
                    <td>Eritrosit</td>
                    <td class="normal">0-1 /lpb</td>
                    <td>&lt; 3 /lpb</td>
                </tr>
                <tr>
                    <td>Epitel</td>
                    <td class="normal">Positif 1</td>
                    <td>Positif 1-2</td>
                </tr>
                <tr>
                    <td>Kristal</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Bakteri</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>

                <!-- HEMOSTASIS -->
                <tr class="section-header">
                    <td colspan="3">HEMOSTASIS</td>
                </tr>
                <tr>
                    <td>Bleeding Time (BT)</td>
                    <td class="normal">2 menit</td>
                    <td>1-3 menit</td>
                </tr>
                <tr>
                    <td>Clotting Time (CT)</td>
                    <td class="normal">5 menit</td>
                    <td>3-8 menit</td>
                </tr>

                <!-- SEROLOGI -->
                <tr class="section-header">
                    <td colspan="3">SEROLOGI</td>
                </tr>
                <tr>
                    <td>Widal - Salmonella O</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Widal - Salmonella H</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Widal - Salmonella P.A</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Widal - Salmonella P.B</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>HbsAg</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>VDRL</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
                <tr>
                    <td>Plano Test</td>
                    <td class="normal">Negatif</td>
                    <td>Negatif</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p><strong>Catatan:</strong></p>
            <p>• Nilai yang ditandai <span class="abnormal">merah</span> menunjukkan hasil di luar batas normal</p>
            <p>• Konsultasikan hasil pemeriksaan dengan dokter untuk interpretasi yang tepat</p>
        </div>

        <div class="doctor-signature">
            <div class="signature-box">
                <p>Kediri, <span id="report-date">12 Juni 2025</span></p>
                <div class="signature-line">
                    <p><strong>dr. Nama Dokter</strong></p>
                    <p>Dokter Penanggung Jawab</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to update patient data
        function updatePatientData(data) {
            if (data.patient_name) document.getElementById('patient-name').textContent = data.patient_name;
            if (data.patient_age) document.getElementById('patient-age').textContent = data.patient_age;
            if (data.patient_address) document.getElementById('patient-address').textContent = data.patient_address;
            if (data.poli_name) document.getElementById('poli-name').textContent = data.poli_name;
            if (data.medical_record_id) document.getElementById('medical-record-id').textContent = data.medical_record_id;
            if (data.examination_date) document.getElementById('examination-date').textContent = data.examination_date;
            if (data.report_date) document.getElementById('report-date').textContent = data.report_date;
        }

        // Add responsive behavior
        window.addEventListener('resize', function() {
            const table = document.querySelector('.table');
            if (window.innerWidth < 768) {
                table.style.fontSize = '11px';
            } else {
                table.style.fontSize = '13px';
            }
        });

        // Initialize responsive design
        if (window.innerWidth < 768) {
            document.querySelector('.table').style.fontSize = '11px';
        }
    </script>

</html>