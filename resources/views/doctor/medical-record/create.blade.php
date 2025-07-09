@extends('layouts.master')

@section('title-page')
    Tambah
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        @if(auth()->user()->role === 'admin')
                            Input Data Vital Pasien
                        @elseif(auth()->user()->role === 'doctor')
                            Tambah Rekam Medis
                        @else
                            Tambah Rekam Medis
                        @endif
                    </h1>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="queue_id">Pilih Antrean Pasien</label>
                                            <select name="queue_id" id="queue_id"
                                                class="form-control @error('queue_id') is-invalid @enderror"
                                                @if(auth()->user()->role === 'admin') @endif>
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

                                {{-- Data Vital - Admin bisa edit, Dokter readonly --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tinggi_badan">Tinggi Badan (cm)</label>
                                            <input type="text" name="tinggi_badan" id="tinggi_badan"
                                                class="form-control @error('tinggi_badan') is-invalid @enderror"
                                                @if(auth()->user()->role === 'doctor') readonly @endif
                                                placeholder="@if(auth()->user()->role === 'doctor') Data diisi oleh admin @endif">
                                            @error('tinggi_badan')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="berat_badan">Berat Badan (kg)</label>
                                            <input type="text" name="berat_badan" id="berat_badan"
                                                class="form-control @error('berat_badan') is-invalid @enderror"
                                                @if(auth()->user()->role === 'doctor') readonly @endif
                                                placeholder="@if(auth()->user()->role === 'doctor') Data diisi oleh admin @endif">
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
                                                @if(auth()->user()->role === 'doctor') readonly @endif
                                                placeholder="@if(auth()->user()->role === 'doctor') Data diisi oleh admin @endif">
                                            @error('tekanan_darah')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Data Medis - Hanya untuk Dokter --}}
                                @if(auth()->user()->role === 'doctor')
                                <div class="row">
                                    <div class="col-md-6">
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
                                    <textarea name="catatan_medis" class="form-control @error('catatan_medis') is-invalid @enderror"></textarea>
                                    @error('catatan_medis')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @endif

                                {{-- Info untuk Admin --}}
                                @if(auth()->user()->role === 'admin')
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Info:</strong> Sebagai admin, Anda hanya dapat menginput data vital pasien (tinggi badan, berat badan, tekanan darah). Data medis akan dilengkapi oleh dokter.
                                </div>
                                @endif

                                {{-- Info untuk Dokter --}}
                                @if(auth()->user()->role === 'doctor')
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Info:</strong> Data vital pasien (tinggi badan, berat badan, tekanan darah) diinput oleh admin dan bersifat readonly.
                                </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary2 mr-2">
                                    @if(auth()->user()->role === 'admin')
                                        Simpan Data Vital
                                    @elseif(auth()->user()->role === 'doctor')
                                        Simpan Rekam Medis
                                    @else
                                        Simpan
                                    @endif
                                </button>
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
            // Load existing data when queue is selected
            $('#queue_id').on('change', function() {
                const queueId = $(this).val();

                if (queueId) {
                    // Ajax call to get existing medical record data
                    $.ajax({
                        url: '/doctor/medical-record/get-existing/' + queueId,
                        method: 'GET',
                        success: function(response) {
                            if (response.success && response.data) {
                                const data = response.data;

                                // Fill vital signs data
                                $('#tinggi_badan').val(data.tinggi_badan || '');
                                $('#berat_badan').val(data.berat_badan || '');
                                $('#tekanan_darah').val(data.tekanan_darah || '');

                                @if(auth()->user()->role === 'doctor')
                                // Fill medical data for doctor
                                $('input[name="diagnosis"]').val(data.diagnosis || '');
                                $('input[name="resep"]').val(data.resep || '');
                                $('textarea[name="catatan_medis"]').val(data.catatan_medis || '');

                                // Set selected medicines
                                if (data.medicines && data.medicines.length > 0) {
                                    const medicineIds = data.medicines.map(m => m.id.toString());
                                    $('#medicine_id').val(medicineIds).trigger('change');
                                }
                                @endif
                            }
                        },
                        error: function() {
                            // Clear form if no existing data
                            $('#tinggi_badan, #berat_badan, #tekanan_darah').val('');
                            @if(auth()->user()->role === 'doctor')
                            $('input[name="diagnosis"], input[name="resep"]').val('');
                            $('textarea[name="catatan_medis"]').val('');
                            $('#medicine_id').val(null).trigger('change');
                            @endif
                        }
                    });
                }
            });

            // Remove validation errors on input
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').text('');
            });

            // Initialize Select2 for medicine selection
            @if(auth()->user()->role === 'doctor')
            $('#medicine_id').select2({
                placeholder: 'Pilih obat...',
                allowClear: true
            });
            @endif
        });
    </script>
@endpush