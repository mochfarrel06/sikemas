@extends('layouts.master')

@section('title-page')
    Edit
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Data Pasien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.patients.index') }}">Pasien</a></li>
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
                        <form id="main-form" method="POST" action="{{ route('admin.patients.update', $patient->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_depan">Nama Depan</label>
                                            <input type="text" class="form-control @error('nama_depan') is-invalid @enderror" name="nama_depan" id="nama_depan"
                                                value="{{ old('nama_depan', $patient->nama_depan) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_belakang">Nama Belakang</label>
                                            <input type="text" class="form-control @error('nama_belakang') is-invalid @enderror" name="nama_belakang"
                                                id="nama_belakang"
                                                value="{{ old('nama_belakang', $patient->nama_belakang) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                                value="{{ old('email', $patient->email) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_hp">Nomor Kontak</label>
                                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" id="no_hp"
                                                value="{{ old('no_hp', $patient->no_hp) }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
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
                                                value="{{ old('tgl_lahir', $patient->tgl_lahir) }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <div style="display: flex; gap: 20px; align-items: center;">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="customRadioLaki"
                                                        name="jenis_kelamin" value="Laki-Laki"
                                                        {{ old('jenis_kelamin', $patient->jenis_kelamin) == 'Laki-Laki' ? 'checked' : '' }}>
                                                    <label for="customRadioLaki"
                                                        class="custom-control-label">Laki-Laki</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio"
                                                        id="customRadioPerempuan" name="jenis_kelamin" value="Perempuan"
                                                        {{ old('jenis_kelamin', $patient->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                                    <label for="customRadioPerempuan"
                                                        class="custom-control-label">Perempuan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p class="font-bold mt-4">Informasi Alamat</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"
                                                value="{{ old('alamat', $patient->alamat) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="negara">Negara</label>
                                            <input type="text" class="form-control @error('negara') is-invalid @enderror" name="negara" id="negara"
                                                value="{{ old('negara', $patient->negara) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="provinsi">Provinsi</label>
                                            <input type="text" class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi"
                                                value="{{ old('provinsi', $patient->provinsi) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kota">Kota</label>
                                            <input type="text" class="form-control @error('kota') is-invalid @enderror" name="kota" id="kota"
                                                value="{{ old('kota', $patient->kota) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kodepos">Kode Pos</label>
                                            <input type="number" class="form-control @error('kodepos') is-invalid @enderror" name="kodepos" id="kode_pos"
                                                value="{{ old('kodepos', $patient->kodepos) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary mr-2">Simpan</button>
                                <a href="{{ route('admin.patients.index') }}" class="btn btn-warning">Kembali</a>
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
                            "{{ route('admin.patients.index') }}"; // Redirect to index page
                    } else if (response.info) {
                        // Flash message info
                        sessionStorage.setItem('info',
                            'Tidak melakukan perubahan data pada dokter.');
                        window.location.href =
                            "{{ route('admin.patients.index') }}"; // Redirect to index page
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
