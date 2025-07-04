@extends('layouts.master')

@section('title-page', 'Detail Antrean')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Jadwal Temu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('data-patient.queue.index') }}" style="color: #38A6B1">Jadwal Temu</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" style="width: 150px; height: 150px;"
                                    src="{{ asset($queue->doctor->foto_dokter) }}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $queue->doctor->nama_depan }}
                                {{ $queue->doctor->nama_belakang }}</h3>

                            <p class="text-muted text-center">{{ $queue->doctor->spesialisasi }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ $queue->doctor->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>No Tlp</b> <a class="float-right">{{ $queue->doctor->no_hp }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Pengalaman</b> <a class="float-right">{{ $queue->doctor->pengalaman }} tahun</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <h3 class="card-title">Jadwal Temu</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-info">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">Janji Temu</span>
                                            <span class="info-box-number text-center mb-0">{{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->start_time)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->end_time)->format('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-warning">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">Hari, Tanggal</span>
                                            <span class="info-box-number text-center mb-0">{{ \Carbon\Carbon::parse($queue->tgl_periksa)->locale('id')->translatedFormat('l') }}, {{ $queue->tgl_periksa }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-success">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center">Status</span>
                                            <span class="info-box-number text-center mb-0">{{ $queue->status }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Keterangan Periksa</label>
                                        <textarea class="form-control" cols="30" rows="10" disabled>{{ $queue->keterangan }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <a class="btn btn-warning" href="{{ route('data-patient.queue.index') }}">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
