@extends('layouts.master')

@section('title-page', 'Tambah Antrean')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Antrean Pasien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('data-patient.queue.index') }}">Antrean Pasien</a></li>
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
                        <form id="main-form" method="POST" action="{{ route('data-patient.queue.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="doctor_id">Dokter</label>
                                            <select class="custom-select @error('doctor_id') is-invalid @enderror"
                                                name="doctor_id" id="doctor_id">
                                                <option value="">-- Pilih Dokter --</option>
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}">{{ $doctor->nama_depan }}
                                                        {{ $doctor->nama_belakang }}</option>
                                                @endforeach
                                            </select>
                                            @error('doctor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Tanggal Periksa</label>
                                            <input type="date"
                                                class="form-control @error('tgl_periksa') is-invalid @enderror"
                                                name="tgl_periksa" id="date">
                                            @error('tgl_periksa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="time-slots">Janji Temu Tersedia</label>
                                            <div class="time-slot-box @error('start_time') is-invalid @enderror @error('end_time') is-invalid @enderror">
                                                <div class="container-time" id="time-slots"></div>
                                            </div>
                                            @error('start_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('end_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="start_time" id="selected-start-time" value="{{ old('start_time') }}">
                                        <input type="hidden" name="end_time" id="selected-end-time" value="{{ old('end_time') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan Periksa</label>
                                            <textarea name="keterangan" id="keterangan" cols="20" rows="5" class="form-control @error('keterangan') is-invalid @enderror"></textarea>
                                            @error('keterangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                                <a href="{{ route('data-patient.queue.index') }}" class="btn btn-warning">Kembali</a>
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
            $('#doctor_id, #date').on('change', function() {
                var doctorId = $('#doctor_id').val();
                var date = $('#date').val();

                if (doctorId && date) {
                    $.ajax({
                        url: "{{ route('data-patient.queue.create') }}",
                        method: 'GET',
                        data: {
                            doctor_id: doctorId,
                            date: date
                        },
                        success: function(response) {
                            $('#time-slots').html('');
                            response.forEach(function(slot) {
                                let btnClass = slot.is_booked ? 'btn-danger' :
                                    'btn-success';
                                let isDisabled = slot.is_booked ? 'disabled' : '';
                                $('#time-slots').append(
                                    `<a href="#" class="btn ${btnClass} m-1 slot-btn" ${isDisabled} data-start="${slot.start}" data-end="${slot.end}">
                                        ${slot.start} - ${slot.end}
                                    </a>`
                                );
                            });
                        }
                    });
                }
            });
            $('#time-slots').on('click', '.slot-btn:not(.btn-danger)', function(e) {
                e.preventDefault();
                $('.slot-btn').removeClass('btn-warning').addClass('btn-success');
                $(this).removeClass('btn-success').addClass('btn-warning');

                var startTime = $(this).data('start');
                var endTime = $(this).data('end');
                $('#selected-start-time').val(startTime);
                $('#selected-end-time').val(endTime);
            });
        });
        document.getElementById('date').min = new Date().toISOString().split('T')[0];
    </script>
@endpush
