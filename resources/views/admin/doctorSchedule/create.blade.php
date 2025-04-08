@extends('layouts.master')

@section('title-page')
    Tambah
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Jadwal Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.doctor-schedules.index') }}">Jadwal Dokter</a>
                        </li>
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
                        <form id="main-form" method="POST" action="{{ route('admin.doctor-schedules.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Dokter</label>
                                            <select class="custom-select @error('doctor_id') is-invalid @enderror"
                                                name="doctor_id" id="doctor_id">
                                                <option value="">-- Pilih Dokter --</option>
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}">{{ $doctor->nama_depan }}
                                                        {{ $doctor->nama_belakang }}</option>
                                                @endforeach
                                            </select>
                                            @error('doctor_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Waktu Jeda</label>
                                            <select name="waktu_jeda" id="waktu_jeda"
                                                class="form-control @error('waktu_jeda') is-invalid @enderror"
                                                @error('waktu_jeda') is-invalid @enderror">
                                                <option value="">-- Pilih Waktu Jeda --</option>
                                                <option value="5">5 Menit</option>
                                                <option value="10">10 Menit</option>
                                                <option value="15">15 Menit</option>
                                                <option value="30">30 Menit</option>
                                                <option value="60">1 Jam</option>
                                            </select>
                                            @error('waktu_jeda')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Waktu Pertemuan</label>
                                            <select name="waktu_periksa" id="waktu_periksa"
                                                class="form-control @error('waktu_periksa') is-invalid @enderror"
                                                @error('waktu_periksa') is-invalid @enderror">
                                                <option value="">-- Pilih Waktu Periksa --</option>
                                                <option value="5">5 Menit</option>
                                                <option value="10">10 Menit</option>
                                                <option value="15">15 Menit</option>
                                                <option value="30">30 Menit</option>
                                                <option value="60">1 Jam</option>
                                            </select>
                                            @error('waktu_periksa')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    @php
                                        $dayMapping = [
                                            'Monday' => 'Senin',
                                            'Tuesday' => 'Selasa',
                                            'Wednesday' => 'Rabu',
                                            'Thursday' => 'Kamis',
                                            'Friday' => 'Jumat',
                                            'Saturday' => 'Sabtu',
                                            'Sunday' => 'Minggu',
                                        ];
                                    @endphp

                                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        @php
                                            $times = [];
                                            $startTime = strtotime('08:00');
                                            $endTime = strtotime('22:00');

                                            while ($startTime <= $endTime) {
                                                $times[] = date('H:i', $startTime);
                                                $startTime = strtotime('+15 minutes', $startTime);
                                            }
                                        @endphp

                                        <div class="col-md-12 mb-3">
                                            <div class="row align-items-center">
                                                <!-- Checkbox di paling kiri -->
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="hari[]" value="{{ $day }}" class="form-check-input custom-checkbox""
                                                            id="{{ $day }}"
                                                            onchange="toggleTimeInputs('{{ $day }}')" style="width: 18px; height: 18px; cursor: pointer;">
                                                        <label class="form-check-label ml-2"
                                                            for="{{ $day }}">{{ $dayMapping[$day] }}</label>
                                                    </div>
                                                </div>

                                                <!-- Waktu Mulai -->
                                                <div class="col-md-5">
                                                    <label for="start_time_{{ $day }}">Waktu Mulai</label>
                                                    <select name="jam_mulai[{{ $day }}]"
                                                        id="start_time_{{ $day }}" class="form-control">
                                                        <option value="">-- Pilih Waktu Mulai --</option>
                                                        @foreach ($times as $time)
                                                            <option value="{{ $time }}">{{ $time }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Waktu Selesai -->
                                                <div class="col-md-5">
                                                    <label for="end_time_{{ $day }}">Waktu Selesai</label>
                                                    <select name="jam_selesai[{{ $day }}]"
                                                        id="end_time_{{ $day }}" class="form-control">
                                                        <option value="">-- Pilih Waktu Selesai --</option>
                                                        @foreach ($times as $time)
                                                            <option value="{{ $time }}">{{ $time }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary mr-2">Simpan</button>
                                <a href="{{ route('admin.doctor-schedules.index') }}" class="btn btn-warning">Kembali</a>
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
        function toggleTimeInputs(day) {
            let checkbox = document.getElementById(day);
            let startTime = document.getElementById(`start_time_${day}`);
            let endTime = document.getElementById(`end_time_${day}`);

            if (checkbox.checked) {
                startTime.removeAttribute("disabled");
                endTime.removeAttribute("disabled");
            } else {
                startTime.value = ""; // Reset nilai input
                endTime.value = ""; // Reset nilai input
                startTime.setAttribute("disabled", "disabled");
                endTime.setAttribute("disabled", "disabled");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('input[type="checkbox"][name="hari[]"]').forEach(function(checkbox) {
                toggleTimeInputs(checkbox.id);
            });
        });
    </script>

    <script>
        document.getElementById('main-form').addEventListener('submit', function(event) {
            let doctor = document.getElementById('doctor_id').value;
            let waktuJeda = document.getElementById('waktu_jeda').value;
            let waktuPeriksa = document.getElementById('waktu_periksa').value;
            let checkedDays = document.querySelectorAll('input[name="hari[]"]:checked');

            // Hanya menampilkan alert jika dokter, waktu jeda, dan waktu periksa sudah diisi
            if (doctor && waktuJeda && waktuPeriksa) {
                if (checkedDays.length === 0) {
                    event.preventDefault();

                    // Tampilkan SweetAlert2
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Harap pilih setidaknya satu hari untuk jadwal dokter!',
                    });
                }

                let errorFound = false; // Flag untuk mendeteksi error

                checkedDays.forEach(function(checkbox) {
                    let day = checkbox.value;
                    let startTime = document.getElementById(`start_time_${day}`).value;
                    let endTime = document.getElementById(`end_time_${day}`).value;

                    if (!startTime || !endTime) {
                        errorFound = true;
                    }
                });

                if (errorFound) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Harap isi waktu mulai dan waktu selesai untuk semua hari yang dicentang!',
                    });
                }
            }
        });
    </script>
@endpush
