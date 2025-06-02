@extends('layouts.master')

@section('title-page')
    Dashboard
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $jumlahAntrean }}</h3>

                            <p>Jumlah Antrean</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('data-patient.queue.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div class="d-flex align-items-center">
                                <i class="iconoir-table mr-2"></i>
                                <h3 class="card-title">Antrean Pasien <b>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d-m-Y') }}</b></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Pasien</th>
                                        <th>Dokter</th>
                                        <th>Pasien</th>
                                        <th>Waktu Periksa</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($antreanHariIni as $queue)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $queue->patient->kode_pasien }}</td>
                                            <td>{{ $queue->doctor->nama_depan }} {{ $queue->doctor->nama_belakang }}</td>
                                            <td>{{ $queue->patient->nama_depan }} {{ $queue->patient->nama_belakang }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->start_time ?? $queue->waktu_mulai)->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->end_time ?? $queue->waktu_selesai)->format('H:i') }}
                                            </td>
                                            <td>
                                                @if ($queue->status == 'booking')
                                                    <a class="btn btn-warning btn-sm">Booking</a>
                                                @elseif ($queue->status == 'periksa')
                                                    <a class="btn btn-info btn-sm">Periksa</a>
                                                @elseif ($queue->status == 'selesai')
                                                    <a class="btn btn-success btn-sm">Selesai</a>
                                                @elseif ($queue->status == 'batal')
                                                    <a class="btn btn-danger btn-sm">Batal</a>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a data-toggle="dropdown">
                                                        <i class="iconoir-more-vert"></i>
                                                    </a>

                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{ route('data-patient.queue.show', $queue->id) }}"><i
                                                            class="iconoir-eye-solid mr-2"></i> Detail</a>
                                                        </li>
                                                        @if ($queue->status == 'booking')
                                                            <li style="cursor: pointer">
                                                                <a class="dropdown-item"
                                                                    onclick="periksaPasien({{ $queue->id }})"><i
                                                                        class="iconoir-check mr-2"></i> Periksa</a>
                                                            </li>
                                                        @endif
                                                        <li style="cursor: pointer"><a class="dropdown-item"
                                                                onclick="batalAntrean({{ $queue->id }})"><i
                                                                    class="iconoir-xmark mr-2"></i> Batal</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function periksaPasien(queueId) {
            Swal.fire({
                title: 'Yakin ingin periksa pasien sekarang?',
                text: "Tindakan ini akan memulai proses pemeriksaan pasien.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, periksa sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/data-patient/periksa-pasien/${queueId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal!', 'Tidak dapat memproses permintaan.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Kesalahan!', 'Terjadi kesalahan pada server.', 'error');
                        });
                }
            });
        }

        function batalAntrean(queueId) {
            Swal.fire({
                title: 'Yakin ingin membatalkan antrean pasien?',
                text: "Tindakan ini akan membatalkan antrean pasien yang telah dilakukan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, batalkan antrean',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/data-patient/batal-antrean/${queueId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal!', 'Tidak dapat memproses permintaan.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Kesalahan!', 'Terjadi kesalahan pada server.', 'error');
                        });
                }
            });
        }
    </script>
@endpush
