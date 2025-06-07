@extends('layouts.master')

@section('title-page')
    Rekam Medis
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rekam Medis</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}" style="color: #38A6B1">Dashboard</a></li>
                        <li class="breadcrumb-item active">Rekam Medis</li>
                    </ol>
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
                                <h3 class="card-title">Rekam Medis</h3>
                            </div>

                            <div class="ml-auto">
                                <a href="{{ route('doctor.medical-record.create') }}"
                                    class="btn btn-primary2 d-flex align-items-center"><i
                                        class="iconoir-plus-circle mr-2"></i> Tambah</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Periksa</th>
                                        <th>Pasien</th>
                                        <th>Diagnosis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medicalRecords as $record)
                                        <tr>
                                            <td class="index">{{ $loop->index + 1 }}</td>
                                            <td>{{ $record->tgl_periksa }}</td>
                                            <td>{{ $record->user->nama_depan }} {{ $record->user->nama_belakang }}</td>
                                            <td>{{ Str::limit($record->diagnosis, 30) }}</td>
                                            <td>
                                                {{-- <div class="btn-group">
                                                    <a data-toggle="dropdown">
                                                        <i class="iconoir-more-vert"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('doctor.medical-record.show', $record->id) }}"><i class="iconoir-eye-solid mr-2"></i>
                                                                Detail</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('doctor.medical-record.pdf', $record->id) }}"
                                                                target="_blank"><i class="iconoir-download mr-2"></i>
                                                                Download</a>
                                                        </li>
                                                    </ul>
                                                </div> --}}
                                                <div class="d-flex align-items-center" style="gap: 10px">
                                                    <a href="{{ route('doctor.medical-record.show', $record->id) }}" class="btn btn-sm btn-warning d-flex align-items-center justify-content-center" style="gap: 5px"><i class="iconoir-eye-solid" style="font-size: 15px"></i>Detail</a>
                                                    <a href="{{ route('doctor.medical-record.pdf', $record->id) }}" target="_blank" class="btn btn-sm btn-info d-flex align-items-center justify-content-center" style="gap: 5px"><i class="iconoir-download" style="font-size: 15px"></i> Download</a>
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
