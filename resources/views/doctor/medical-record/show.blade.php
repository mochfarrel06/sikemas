@extends('layouts.master')

@section('title-page')
    Riwayat Pasien
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riwayat Rekam Medis - {{ $patient->nama_depan }} {{ $patient->nama_belakang }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}" style="color: #38A6B1">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('doctor.medical-record.index') }}" style="color: #38A6B1">Rekam Medis</a></li>
                        <li class="breadcrumb-item active">Riwayat Pasien</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12">
                    <!-- Info Pasien -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="iconoir-user mr-2"></i>
                                Informasi Pasien
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Nama:</strong> {{ $patient->nama_depan }} {{ $patient->nama_belakang }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Total Kunjungan:</strong> 
                                    <span class="badge badge-primary">{{ $medicalRecords->count() }} kali</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Kunjungan Pertama:</strong> 
                                    {{ \Carbon\Carbon::parse($medicalRecords->last()->tgl_periksa)->format('d/m/Y') }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Kunjungan Terakhir:</strong> 
                                    {{ \Carbon\Carbon::parse($medicalRecords->first()->tgl_periksa)->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Rekam Medis -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="iconoir-list mr-2"></i>
                                Riwayat Rekam Medis
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Periksa</th>
                                            <th>Diagnosis</th>
                                            <th>Tindakan</th>
                                            <th>Obat</th>
                                            <th>Total Biaya Obat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($medicalRecords as $record)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($record->tgl_periksa)->format('d/m/Y H:i') }}</td>
                                                <td>{{ Str::limit($record->diagnosis, 50) }}</td>
                                                <td>{{ $record->tindakan ?? '-' }}</td>
                                                <td>
                                                    @if ($record->medicines->isNotEmpty())
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($record->medicines as $medicine)
                                                                <li>• {{ $medicine->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($record->medicines->isNotEmpty())
                                                        <strong>Rp {{ number_format($record->medicines->sum('price'), 0, ',', '.') }}</strong>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px">
                                                        <a href="{{ route('doctor.medical-record.show', $record->id) }}" 
                                                           class="btn btn-sm btn-warning" 
                                                           title="Detail">
                                                            <i class="iconoir-eye-solid"></i>
                                                        </a>
                                                        <a href="{{ route('doctor.medical-record.pdf', $record->id) }}" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-info" 
                                                           title="Download PDF">
                                                            <i class="iconoir-download"></i>
                                                        </a>
                                                        <a href="{{ route('doctor.medical-record.nota', $record->id) }}" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-success" 
                                                           title="Print Nota">
                                                            <i class="iconoir-printer"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Total Keseluruhan Biaya Obat:</strong></td>
                                            <td><strong>Rp {{ number_format($medicalRecords->sum(function($record) { return $record->medicines->sum('price'); }), 0, ',', '.') }}</strong></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('doctor.medical-record.index') }}" class="btn btn-warning">
                                <i class="iconoir-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection