@extends('layouts.master')

@section('title-page')
    Edit
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">Dokter</a></li>
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
                        <form id="main-form" method="POST" action="{{ route('admin.doctors.update', $doctor->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Profile</label>
                                            <div>
                                                <!-- Gambar profil -->
                                                <img id="profileImage" class="profile-user-img img-fluid img-circle"
                                                    src="{{ $doctor->foto_dokter ? asset($doctor->foto_dokter) : asset('assets/admin/dist/img/avatar.png') }}"
                                                    alt="User profile picture"
                                                    style="cursor: pointer; object-fit: cover; width: 120px; height: 120px; border-radius: 50%;">
                                                <input type="file" id="foto_dokter" name="foto_dokter"
                                                    style="display: none;" accept="image/*">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_depan">Nama Depan</label>
                                            <input type="text" class="form-control @error('nama_depan') is-invalid @enderror" name="nama_depan" id="nama_depan"
                                                value="{{ old('nama_depan', $doctor->nama_depan) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_belakang">Nama Belakang</label>
                                            <input type="text" class="form-control @error('nama_belakang') is-invalid @enderror" name="nama_belakang"
                                                id="nama_belakang"
                                                value="{{ old('nama_belakang', $doctor->nama_belakang) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                                value="{{ old('email', $doctor->email) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_hp">Nomor Kontak</label>
                                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" id="no_hp"
                                                value="{{ old('no_hp', $doctor->no_hp) }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                placeholder="Masukkan password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Konfirmasi Password</label>
                                            <input type="password" name="konfirmasi_password" id="konfirmasi_password"
                                                class="form-control" placeholder="Masukkan konfirmasi password">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" name="tgl_lahir" id="tgl_lahir"
                                                value="{{ old('tgl_lahir', $doctor->tgl_lahir) }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <div style="display: flex; gap: 20px; align-items: center;">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio"
                                                        id="customRadioLaki" name="jenis_kelamin" value="Laki-Laki"
                                                        {{ old('jenis_kelamin', $doctor->jenis_kelamin) == 'Laki-Laki' ? 'checked' : '' }}>
                                                    <label for="customRadioLaki"
                                                        class="custom-control-label">Laki-Laki</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio"
                                                        id="customRadioPerempuan" name="jenis_kelamin" value="Perempuan"
                                                        {{ old('jenis_kelamin', $doctor->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                                    <label for="customRadioPerempuan"
                                                        class="custom-control-label">Perempuan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pengalaman">Pengalaman</label>
                                            <input type="number" class="form-control @error('pengalaman') is-invalid @enderror" name="pengalaman" id="pengalaman"
                                                value="{{ old('pengalaman', $doctor->pengalaman) }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Golongan Darah</label>
                                            <select class="custom-select @error('golongan_darah') is-invalid @enderror" name="golongan_darah">
                                                <option value="">-- Pilih Golongan Darah --</option>
                                                <option value="A"
                                                    {{ $doctor->golongan_darah === 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B"
                                                    {{ $doctor->golongan_darah === 'B' ? 'selected' : '' }}>B</option>
                                                <option value="AB"
                                                    {{ $doctor->golongan_darah === 'AB' ? 'selected' : '' }}>AB</option>
                                                <option value="O"
                                                    {{ $doctor->golongan_darah === 'O' ? 'selected' : '' }}>O</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="specialization_id">Spesialisasi</label>
                                            <select name="specialization_id" id="specialization_id"
                                                class="form-control @error('specialization_id') is-invalid @enderror">
                                                <option value="">-- Pilih Spesialisasi --</option>
                                                @foreach ($specializations as $specialization)
                                                    <option value="{{ $specialization->id }}" {{ $doctor->specialization_id === $specialization->id ? 'selected' : '' }}>{{ $specialization->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <p class="font-bold mt-4">Informasi Alamat</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"
                                                value="{{ old('alamat', $doctor->alamat) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="negara">Negara</label>
                                            <input type="text" class="form-control @error('negara') is-invalid @enderror" name="negara" id="negara"
                                                value="{{ old('negara', $doctor->negara) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="provinsi">Provinsi</label>
                                            <input type="text" class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi"
                                                value="{{ old('provinsi', $doctor->provinsi) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kota">Kota</label>
                                            <input type="text" class="form-control @error('kota') is-invalid @enderror" name="kota" id="kota"
                                                value="{{ old('kota', $doctor->kota) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kodepos">Kode Pos</label>
                                            <input type="number" class="form-control @error('kodepos') is-invalid @enderror" name="kodepos" id="kode_pos"
                                                value="{{ old('kodepos', $doctor->kodepos) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary mr-2">Simpan</button>
                                <a href="{{ route('admin.doctors.index') }}" class="btn btn-warning">Kembali</a>
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
        // Ambil elemen gambar dan input file
        const profileImage = document.getElementById('profileImage');
        const profileInput = document.getElementById('foto_dokter');

        // Tambahkan event klik pada gambar
        profileImage.addEventListener('click', function() {
            profileInput.click(); // Simulasikan klik pada input file
        });

        // Update gambar saat file dipilih
        profileInput.addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang dipilih
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    profileImage.src = e.target.result; // Perbarui src gambar
                };

                reader.readAsDataURL(file); // Baca file sebagai data URL
            }
        });
    </script>

    <script>
        // Handle form submission using AJAX
        $('#main-form').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const form = $(this);
            const formData = new FormData(form[0]); // Use FormData to handle file uploads
            const submitButton = $('#submit-btn');
            submitButton.prop('disabled', true).text('Loading...');

            $.ajax({
                url: form.attr('action'),
                method: 'POST', // Use POST for form submission
                data: formData,
                contentType: false, // Prevent jQuery from setting content type
                processData: false, // Prevent jQuery from processing data
                success: function(response) {
                    if (response.success) {
                        // Flash message sukses
                        sessionStorage.setItem('success',
                            'dokter berhasil disubmit.');
                        window.location.href =
                            "{{ route('admin.doctors.index') }}"; // Redirect to index page
                    } else if (response.info) {
                        // Flash message info
                        sessionStorage.setItem('info',
                            'Tidak melakukan perubahan data pada dokter.');
                        window.location.href =
                            "{{ route('admin.doctors.index') }}"; // Redirect to index page
                    } else {
                        // Flash message error
                        $('#flash-messages').html('<div class="alert alert-danger">' +
                            response.error + '</div>');
                    }
                },
                error: function(response) {
                    const errors = response.responseJSON.errors;
                    for (let field in errors) {
                        let input = $('[name=' + field + ']');
                        let error = errors[field][0];
                        input.addClass('is-invalid');
                        // Remove existing invalid feedback to avoid duplicates
                        input.next('.invalid-feedback').remove();
                        input.after('<div class="invalid-feedback">' + error + '</div>');
                    }

                    const message = response.responseJSON.message ||
                        'Terdapat kesalahan pada dokter.';
                    $('#flash-messages').html('<div class="alert alert-danger">' + message +
                        '</div>');
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Edit');
                }
            });
        });

        // Remove validation error on input change
        $('input, select, textarea').on('input change', function() {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
    </script>
@endpush
