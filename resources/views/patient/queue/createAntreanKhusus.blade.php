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
                        <form id="main-form" method="POST" action="{{ route('data-patient.storeAntreanKhusus') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="doctor_id">Dokter</label>
                                            <input type="text" class="form-control" value="{{ $doctor->nama_depan }} {{ $doctor->nama_belakang }}" readonly>
                                            <input type="hidden" name="doctor_id" id="doctor_id" value="{{ $doctorId }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="patient_id">Pasien</label>
                                            <select class="custom-select" name="patient_id" id="patient_id">
                                                <option value="">-- Pilih Pasien --</option>
                                                @foreach ($patients as $patient)
                                                    <option value="{{ $patient->id }}">{{ $patient->nama_depan }} {{ $patient->nama_belakang }}</option>
                                                    <input type="hidden" name="user_id" id="user_id" value="{{ $patient->user_id }}">
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan Periksa</label>
                                    <textarea name="keterangan" id="keterangan" cols="20" rows="5" class="form-control"></textarea>
                                </div>

                                <hr>

                                <div id="appointment-container">
                                    <div class="appointment-item">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="tgl_periksa[]">Tanggal Periksa</label>
                                                    <input type="date" class="form-control tgl-periksa" name="tgl_periksa[]">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="time-slots">Janji Temu Tersedia</label>
                                                    <div class="time-slot-box">
                                                        <div class="container-time"></div>
                                                    </div>
                                                    <input type="hidden" name="start_time[]" class="selected-start-time">
                                                    <input type="hidden" name="end_time[]" class="selected-end-time">
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-info" id="add-appointment">Tambah Tanggal</button>
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
            function fetchTimeSlots(dateInput) {
                var doctorId = $('#doctor_id').val();
                var date = dateInput.val();
                var container = dateInput.closest('.appointment-item').find('.container-time');

                if (doctorId && date) {
                    $.ajax({
                        url: "{{ route('data-patient.createAntreanKhusus') }}",
                        method: 'GET',
                        data: { doctor_id: doctorId, date: date },
                        success: function(response) {
                            container.html('');
                            response.forEach(function(slot) {
                                let btnClass = slot.is_booked ? 'btn-danger' : 'btn-success';
                                let isDisabled = slot.is_booked ? 'disabled' : '';
                                container.append(
                                    `<a href="#" class="btn ${btnClass} m-1 slot-btn" ${isDisabled}
                                        data-start="${slot.start}" data-end="${slot.end}">
                                        ${slot.start} - ${slot.end}
                                    </a>`
                                );
                            });
                        }
                    });
                }
            }

            $(document).on('change', '.tgl-periksa', function() {
                fetchTimeSlots($(this));
            });

            $(document).on('click', '.slot-btn:not(.btn-danger)', function(e) {
                e.preventDefault();
                var parent = $(this).closest('.appointment-item');
                parent.find('.slot-btn').removeClass('btn-warning').addClass('btn-success');
                $(this).removeClass('btn-success').addClass('btn-warning');
                parent.find('.selected-start-time').val($(this).data('start'));
                parent.find('.selected-end-time').val($(this).data('end'));
            });

            $('#add-appointment').click(function() {
                var newAppointment = $('.appointment-item:first').clone();
                newAppointment.find('input').val('');
                newAppointment.find('.container-time').html('');
                $('#appointment-container').append(newAppointment);
            });
        });
    </script>
@endpush
