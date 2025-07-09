@extends('layouts.master')

@section('title-page')
    Tambah
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Rekam Medis</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}"
                                style="color: #38A6B1">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('doctor.medical-record.index') }}"
                                style="color: #38A6B1">Rekam Medis</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                        <form id="main-form" method="POST" action="{{ route('doctor.medical-record.store') }}">
                            @csrf
                            <div class="card-body">
                                <!-- Dropdown Pasien - Selalu tampil untuk Admin dan Dokter -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="queue_id">Pilih Antrean Pasien</label>
                                            <select name="queue_id" id="queue_id"
                                                class="form-control @error('queue_id') is-invalid @enderror">
                                                <option value="">-- Pilih Pasien --</option>
                                                @foreach ($queues as $queue)
                                                    <option value="{{ $queue->id }}">{{ $queue->patient->kode_pasien }} -
                                                        {{ $queue->patient->nama_depan }}
                                                        {{ $queue->patient->nama_belakang }} -
                                                        {{ $queue->tgl_periksa }}</option>
                                                @endforeach
                                            </select>
                                            @error('queue_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @if(auth()->user()->role !== 'admin')
                                    <!-- Pilih Obat - Hanya tampil untuk Dokter -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="medicine_id">Pilih Obat</label>
                                                <select name="medicine_id[]" id="medicine_id"
                                                    class="form-control select2 @error('medicine_id') is-invalid @enderror"
                                                    multiple>
                                                    @foreach ($medicines as $medicine)
                                                        <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('medicine_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Vital Signs Section - Selalu tampil -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="mb-3" style="color: #38A6B1; border-bottom: 2px solid #38A6B1; padding-bottom: 5px;">
                                            Tanda Vital
                                        </h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tinggi_badan">Tinggi Badan (cm)</label>
                                            <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan"
                                                class="form-control @error('tinggi_badan') is-invalid @enderror"
                                                placeholder="Contoh: 170"
                                                @if(auth()->user()->role !== 'admin') readonly @endif>
                                            @error('tinggi_badan')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="berat_badan">Berat Badan (kg)</label>
                                            <input type="number" step="0.1" name="berat_badan" id="berat_badan"
                                                class="form-control @error('berat_badan') is-invalid @enderror"
                                                placeholder="Contoh: 70"
                                                @if(auth()->user()->role !== 'admin') readonly @endif>
                                            @error('berat_badan')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tekanan_darah">Tekanan Darah (mmHg)</label>
                                            <input type="text" name="tekanan_darah" id="tekanan_darah"
                                                class="form-control @error('tekanan_darah') is-invalid @enderror"
                                                placeholder="Contoh: 120/80"
                                                @if(auth()->user()->role !== 'admin') readonly @endif>
                                            @error('tekanan_darah')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                @if(auth()->user()->role !== 'admin')
                                    <!-- Pemeriksaan Medis Section - Hanya tampil untuk Dokter -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="mb-3 mt-3" style="color: #38A6B1; border-bottom: 2px solid #38A6B1; padding-bottom: 5px;">
                                                Pemeriksaan Medis
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="diagnosis">Diagnosis</label>
                                                <input list="diagnosis-list" type="text" name="diagnosis"
                                                    class="form-control @error('diagnosis') is-invalid @enderror">
                                                <datalist id="diagnosis-list">
                                                    @foreach ($diagnoses as $diag)
                                                        <option value="{{ $diag }}">
                                                    @endforeach
                                                </datalist>
                                                @error('diagnosis')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="resep">Perawatan</label>
                                                <input type="text" class="form-control @error('resep') is-invalid @enderror" name="resep">
                                                @error('resep')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="catatan_medis">Catatan Medis</label>
                                        <textarea name="catatan_medis" rows="4" class="form-control @error('catatan_medis') is-invalid @enderror"></textarea>
                                        @error('catatan_medis')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary2 mr-2">Simpan</button>
                                <a href="{{ route('doctor.medical-record.index') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').text('');
            });

            @if(auth()->user()->role === 'admin')
                // Script khusus untuk admin - hanya untuk tanda vital
                $('#tekanan_darah').on('input', function() {
                    var value = $(this).val();
                    // Hapus semua karakter non-digit dan slash
                    value = value.replace(/[^0-9\/]/g, '');
                    // Pastikan hanya ada satu slash
                    var parts = value.split('/');
                    if (parts.length > 2) {
                        value = parts[0] + '/' + parts[1];
                    }
                    $(this).val(value);
                });

                // Validasi tinggi dan berat badan
                $('#tinggi_badan, #berat_badan').on('input', function() {
                    var value = parseFloat($(this).val());

                    if ($(this).attr('id') === 'tinggi_badan') {
                        if (value < 0 || value > 300) {
                            $(this).addClass('is-invalid');
                            $(this).next('.invalid-feedback').text('Tinggi badan tidak valid');
                        }
                    } else if ($(this).attr('id') === 'berat_badan') {
                        if (value < 0 || value > 500) {
                            $(this).addClass('is-invalid');
                            $(this).next('.invalid-feedback').text('Berat badan tidak valid');
                        }
                    }
                });
            @endif
        });
    </script>
@endpush