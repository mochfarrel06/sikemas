@extends('layouts.master')

@section('title-page')
    Edit
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Jadwal Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.doctor-schedules.index') }}">Jadwal Dokter</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <form method="POST" id="main-form" action="{{ route('admin.doctor-schedules.update', $doctor->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                {{-- <div class="row mb-4">
                                    <div class="col-md-2">
                                        <img class="profile-user-img img-fluid img-circle"
                                            src="{{ $doctor->foto_dokter ? asset($doctor->foto_dokter) : asset('assets/admin/dist/img/avatar.png') }}"
                                            alt="User profile picture"
                                            style="cursor: pointer; object-fit: cover; width: 150px; height: 150px; border-radius: 50%;">

                                    </div>
                                    <div class="col-md-10">
                                        <h3>{{ $doctor->nama_depan }} {{ $doctor->nama_belakang }}</h3>
                                        <p>{{ $doctor->email }}</p>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Waktu Jeda</label>
                                            <select name="waktu_jeda" id="waktu_jeda" class="form-control"
                                                @error('waktu_jeda') is-invalid @enderror">
                                                <option>-- Pilih Waktu Jeda --</option>
                                                <option value="5"
                                                    {{ $firstSchedule && $firstSchedule->waktu_jeda === 5 ? 'selected' : '' }}>
                                                    5 Menit</option>
                                                <option value="10"
                                                    {{ $firstSchedule && $firstSchedule->waktu_jeda === 10 ? 'selected' : '' }}>
                                                    10 Menit</option>
                                                <option value="15"
                                                    {{ $firstSchedule && $firstSchedule->waktu_jeda === 15 ? 'selected' : '' }}>
                                                    15 Menit</option>
                                                <option value="30"
                                                    {{ $firstSchedule && $firstSchedule->waktu_jeda === 30 ? 'selected' : '' }}>
                                                    30 Menit</option>
                                                <option value="60"
                                                    {{ $firstSchedule && $firstSchedule->waktu_jeda === 60 ? 'selected' : '' }}>
                                                    1 Jam</option>
                                            </select>
                                            @error('waktu_jeda')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Waktu Pertemuan</label>
                                            <select name="waktu_periksa" id="waktu_periksa" class="form-control"
                                                @error('waktu_periksa') is-invalid @enderror">
                                                <option value="">-- Pilih Waktu Periksa --</option>
                                                <option value="5"
                                                    {{ $firstSchedule && $firstSchedule->waktu_periksa === 5 ? 'selected' : '' }}>
                                                    5 Menit</option>
                                                <option value="10"
                                                    {{ $firstSchedule && $firstSchedule->waktu_periksa === 10 ? 'selected' : '' }}>
                                                    10 Menit</option>
                                                <option value="15"
                                                    {{ $firstSchedule && $firstSchedule->waktu_periksa === 15 ? 'selected' : '' }}>
                                                    15 Menit</option>
                                                <option value="30"
                                                    {{ $firstSchedule && $firstSchedule->waktu_periksa === 30 ? 'selected' : '' }}>
                                                    30 Menit</option>
                                                <option value="60"
                                                    {{ $firstSchedule && $firstSchedule->waktu_periksa === 60 ? 'selected' : '' }}>
                                                    1 Jam</option>
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
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="hari[]" value="{{ $day }}"
                                                            id="{{ $day }}"
                                                            {{ isset($formattedSchedules[$day]['jam_mulai']) ? 'checked' : '' }} onchange="toggleTimeInputs('{{ $day }}')">
                                                        <label class="form-check-label"
                                                            for="{{ $day }}">{{ $dayMapping[$day] }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="start_time_{{ $day }}">Waktu Mulai</label>
                                                    <select name="jam_mulai[{{ $day }}]"
                                                        id="start_time_{{ $day }}" class="form-control">
                                                        <option value="">-- Pilih Waktu Mulai</option>
                                                        @foreach ($times as $time)
                                                            <option value="{{ $time }}"
                                                                {{ isset($formattedSchedules[$day]['jam_mulai']) && $formattedSchedules[$day]['jam_mulai'] === $time ? 'selected' : '' }}>
                                                                {{ $time }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="end_time_{{ $day }}">Waktu Selesai</label>
                                                    <select name="jam_selesai[{{ $day }}]"
                                                        id="end_time_{{ $day }}" class="form-control">
                                                        <option value="">-- Pilih Waktu Selesai</option>
                                                        @foreach ($times as $time)
                                                            <option value="{{ $time }}"
                                                                {{ isset($formattedSchedules[$day]['jam_selesai']) && $formattedSchedules[$day]['jam_selesai'] === $time ? 'selected' : '' }}>
                                                                {{ $time }}
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
    document.addEventListener("DOMContentLoaded", function () {
        let submitBtn = document.getElementById('submit-btn');
        let waktuJeda = document.getElementById('waktu_jeda');
        let waktuPeriksa = document.getElementById('waktu_periksa');
        let checkboxes = document.querySelectorAll('input[name="hari[]"]');

        function checkFormValidity() {
            let waktuJedaValue = waktuJeda.value;
            let waktuPeriksaValue = waktuPeriksa.value;
            let checkedDays = document.querySelectorAll('input[name="hari[]"]:checked').length > 0;

            // Jika waktu jeda, waktu periksa diisi dan ada hari yang dipilih, enable tombol
            if (waktuJedaValue && waktuPeriksaValue && checkedDays) {
                submitBtn.removeAttribute("disabled");
            } else {
                submitBtn.setAttribute("disabled", "disabled");
            }
        }

        // Event listener untuk dropdown waktu jeda & periksa
        waktuJeda.addEventListener("change", checkFormValidity);
        waktuPeriksa.addEventListener("change", checkFormValidity);

        // Event listener untuk checkbox hari
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", checkFormValidity);
        });

        // Mencegah submit jika tidak ada checkbox yang dipilih
        document.getElementById('main-form').addEventListener('submit', function (event) {
            let checkedDays = document.querySelectorAll('input[name="hari[]"]:checked').length;

            if (checkedDays === 0) {
                event.preventDefault();

                // Tampilkan SweetAlert2
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Harap pilih setidaknya satu hari untuk jadwal dokter!',
                });
            }
        });

        // Jalankan validasi awal
        checkFormValidity();
    });
</script>

@endpush
