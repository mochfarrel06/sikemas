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
                                <div class="row">
                                    <div class="col-md-6">
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
                                    <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tinggi_badan">Tinggi Badan (cm)</label>
                                            <input type="text" name="tinggi_badan" class="form-control @error('tinggi_badan') is-invalid @enderror">
                                            @error('tinggi_badan')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="berat_badan">Berat Badan (kg)</label>
                                            <input type="text" name="berat_badan" class="form-control @error('berat_badan') is-invalid @enderror">
                                            @error('berat_badan')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tekanan_darah">Tekanan Darah (mmHg)</label>
                                            <input type="text" name="tekanan_darah" class="form-control @error('tekanan_darah') is-invalid @enderror">
                                            @error('tekanan_darah')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

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
                                            <input type="text" class="form-control" name="resep"
                                                @error('resep') is-invalid @enderror">
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
            // const $submitBtn = $('#submit-btn');
            // $('#main-form').on('submit', function(event) {
            //     event.preventDefault();

            //     const form = $(this)[0];
            //     const formData = new FormData(form);

            //     $submitBtn.prop('disabled', true).text('Loading...');

            //     $.ajax({
            //         url: form.action,
            //         method: 'POST',
            //         data: formData,
            //         processData: false,
            //         contentType: false,
            //         success: function(response) {
            //             if (response.success && response.redirect) {
            //                 sessionStorage.setItem('success',
            //                     'Data Rekam Medis berhasil disubmit.');
            //                 window.location.href = response
            //                 .redirect; // arahkan ke halaman transaksi create
            //             } else {
            //                 $('#flash-messages').html('<div class="alert alert-danger">' +
            //                     (response.error || 'Terjadi kesalahan.') + '</div>');
            //             }
            //         }
            //         error: function(response) {
            //             const errors = response.responseJSON.errors;
            //             for (let field in errors) {
            //                 let input = $('[name=' + field + ']');
            //                 let error = errors[field][0];
            //                 input.addClass('is-invalid');
            //                 input.next('.invalid-feedback').remove();
            //                 input.after('<div class="invalid-feedback">' + error + '</div>');
            //             }

            //             const message = response.responseJSON.message ||
            //                 'Terdapat kesalahan pada proses rekam medis';
            //             $('#flash-messages').html('<div class="alert alert-danger">' + message +
            //                 '</div>');
            //         },
            //         complete: function() {
            //             $submitBtn.prop('disabled', false).text('Simpan');
            //         }
            //     });
            // });

            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').text('');
            });
        });
    </script>
@endpush
