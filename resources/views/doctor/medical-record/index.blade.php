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
                                <h3 class="card-title">Daftar Pasien</h3>
                            </div>

                            @if (auth()->user() && !in_array(auth()->user()->role, ['admin', 'farmasi']))
                            <div class="ml-auto">
                                    <a href="{{ route('doctor.medical-record.create') }}"
                                        class="btn btn-primary2 d-flex align-items-center">
                                        <i class="iconoir-plus-circle mr-2"></i> Tambah
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                        {{-- Ganti script notifikasi dengan alert biasa yang sudah terbukti bekerja --}}
                            @if (auth()->user()->role === 'farmasi')
                                @php
                                    $hasNewMedicalRecordWithMedicines = \App\Models\MedicalRecord::whereHas('medicines')->exists();
                                @endphp

                                @if ($hasNewMedicalRecordWithMedicines)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <strong>Ada rekam medis baru!</strong> Terdapat rekam medis baru yang perlu diproses farmasi.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pasien</th>
                                        <th>Kunjungan Pertama</th>
                                        <th>Kunjungan Terakhir</th>
                                        <th>Total Kunjungan</th>
                                        <th>Diagnosis Terakhir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medicalRecords as $record)
                                        <tr>
                                            <td class="index">{{ $loop->index + 1 }}</td>
                                            <td>
                                                <strong>{{ $record->queue->patient->nama_depan }} {{ $record->queue->patient->nama_belakang }}</strong>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($record->first_visit)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($record->last_visit)->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge badge-primary">{{ $record->total_visits }} kali</span>
                                            </td>
                                            <td>{{ Str::limit($record->diagnosis, 30) }}</td>
                        
                                            <td>
                                                <div class="d-flex align-items-center" style="gap: 10px">
                                                    <a href="{{ route('doctor.medical-record.show', $record->queue->patient->id) }}" 
                                                       class="btn btn-sm btn-warning d-flex align-items-center justify-content-center" 
                                                       style="gap: 5px">
                                                        <i class="iconoir-eye-solid" style="font-size: 15px"></i>Riwayat
                                                    </a>
                                                    <a href="{{ route('doctor.medical-record.pdf', $record->id) }}" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-info d-flex align-items-center justify-content-center" 
                                                       style="gap: 5px">
                                                        <i class="iconoir-download" style="font-size: 15px"></i> Download
                                                    </a>
                                                    <a href="{{ route('doctor.medical-record.nota', $record->id) }}" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-success d-flex align-items-center justify-content-center" 
                                                       style="gap: 5px">
                                                        <i class="iconoir-printer" style="font-size: 15px"></i> Nota
                                                    </a>
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
    {{-- Notifikasi Browser --}}
    @if (auth()->user()->role === 'farmasi')
        @php
            $hasNewMedicalRecordWithMedicines = \App\Models\MedicalRecord::whereHas('medicines')->exists();
        @endphp

        @if ($hasNewMedicalRecordWithMedicines)
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if ("Notification" in window) {
                        if (Notification.permission !== "granted") {
                            Notification.requestPermission().then(function (permission) {
                                if (permission === "granted") {
                                    showNotif();
                                }
                            });
                        } else {
                            showNotif();
                        }
                    } else {
                        // Fallback jika browser tidak support notifikasi
                        alert("Terdapat rekam medis baru yang perlu diproses farmasi.");
                    }

                    function showNotif() {
                        new Notification("Notifikasi Farmasi", {
                            body: "Terdapat rekam medis baru yang perlu diproses farmasi.",
                            icon: "/logo.png" // Ganti ini dengan path ikon/logo aplikasi kamu
                        });
                    }
                });
            </script>
        @endif
    @endif
@endpush