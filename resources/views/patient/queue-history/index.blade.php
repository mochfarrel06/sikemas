@extends('layouts.master')

@section('title-page')
    Riwayat
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riwayat Antrean Pasien</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div class="d-flex align-items-center">
                                <i class="iconoir-table mr-2"></i>
                                <h3 class="card-title">Riwayat Antrean Pasien</h3>
                            </div>
                            {{-- <div class="ml-auto">
                                <a href="{{ $jumlahhistory > 0 ? route('history.pdf') : '#' }}"
                                    class="btn btn-primary d-flex align-items-center {{ $jumlahhistory <= 0 ? 'disabled' : '' }}"
                                    target="_blank">
                                    <i class="iconoir-download mr-2"></i> Export
                                </a>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pasien</th>
                                        <th>Tanggal Periksa</th>
                                        <th>Jam</th>
                                        <th>Dokter</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($queueHistories as $queue)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $queue->patient->nama_depan }} {{ $queue->patient->nama_belakang }}</td>
                                            <td>{{ $queue->tgl_periksa }}</td>
                                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->start_time ?? $queue->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->end_time ?? $queue->waktu_selesai)->format('H:i') }}</td>
                                            <td>{{ $queue->doctor->nama_depan }} {{ $queue->doctor->nama_belakang }}</td>
                                            <td>{{ $queue->keterangan }}</td>
                                            <td>@if ($queue->status == 'booking')
                                                <a class="btn btn-warning btn-sm">Booking</a>
                                            @elseif ($queue->status == 'periksa')
                                                <a class="btn btn-info btn-sm">Periksa</a>
                                            @elseif ($queue->status == 'selesai')
                                                <a class="btn btn-success btn-sm">Selesai</a>
                                            @elseif ($queue->status == 'batal')
                                                <a class="btn btn-danger btn-sm">Batal</a>
                                            @endif</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a data-toggle="dropdown">
                                                        <i class="iconoir-more-vert"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li><a class="dropdown-item" href="{{ route('history.queue-history.show', $queue->id) }}"><i
                                                            class="iconoir-eye-solid mr-2"></i> Detail</a>
                                                        </li>
                                                        @if ($queue->status == 'selesai' && $queue->medical_id)
                                                            <li><a class="dropdown-item"
                                                                href="{{ route('history.history-medical.pdf', $queue->medical_id) }}"
                                                                target="_blank"><i class="iconoir-download mr-2"></i>
                                                                Download</a>
                                                            </li>
                                                        @endif
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
