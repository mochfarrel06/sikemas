<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Antrean Pasien</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Riwayat Antrean Pasien</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Tanggal Periksa</th>
                <th>Jam</th>
                <th>Dokter</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($queueHistories as $queue)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $queue->patient->nama_depan }} {{ $queue->patient->nama_belakang }}</td>
                    <td>{{ $queue->tgl_periksa }}</td>
                    <td>
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->end_time)->format('H:i') }}
                    </td>
                    <td>{{ $queue->doctor->nama_depan }} {{ $queue->doctor->nama_belakang }}</td>
                    <td>{{ $queue->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
