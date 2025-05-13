@extends('layouts.master')

@section('title-page')
    Antrean
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profil</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <div class="text-center">
                                    <img id="profileImage" class="profile-user-img img-fluid img-circle"
                                        src="{{ $user->foto ? asset($user->foto) : asset('assets/admin/dist/img/avatar.png') }}"
                                        alt="User profile picture"
                                        style="cursor: pointer; object-fit: cover; width: 100px; height: 100px; border-radius: 50%;">
                                    <input type="file" id="foto" name="foto" style="display: none;"
                                        accept="image/*">
                                </div>

                                <h3 class="profile-username text-center">{{ $user->nama_depan }} {{ $user->nama_belakang }}
                                </h3>

                                <p class="text-muted text-center">{{ $user->role }} @if ($user->role == 'dokter')
                                        {{ $user->doctor->specialization->name }}
                                    @endif
                                </p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#informasi"
                                        data-toggle="tab">Informasi</a></li>
                            </ul>
                        </div>
                        <form id="main-form" method="POST" action="{{ route('profile.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="informasi">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama_depan">Nama Depan</label>
                                                    <input type="text"
                                                        class="form-control @error('nama_depan') is-invalid @enderror"
                                                        name="nama_depan" id="nama_depan"
                                                        value="{{ old('nama_depan', $user->nama_depan) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama_belakang">Nama Belakang</label>
                                                    <input type="text"
                                                        class="form-control @error('nama_belakang') is-invalid @enderror"
                                                        name="nama_belakang" id="nama_belakang"
                                                        value="{{ old('nama_belakang', $user->nama_belakang) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" id="email"
                                                        value="{{ old('email', $user->email) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Password</label>
                                                    <input type="password" name="password" id="password"
                                                        class="form-control" placeholder="Masukkan password">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Konfirmasi Password</label>
                                                    <input type="password" name="konfirmasi_password"
                                                        id="konfirmasi_password" class="form-control"
                                                        placeholder="Masukkan konfirmasi password">
                                                </div>
                                            </div>
                                        </div>
                                        @if ($role == 'pasien' || $role == 'dokter')
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="no_hp">Nomor Kontak</label>
                                                        <input type="text"
                                                            class="form-control @error('no_hp') is-invalid @enderror"
                                                            name="no_hp" id="no_hp"
                                                            value="{{ old('no_hp', $user->no_hp) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                                        <input type="date"
                                                            class="form-control @error('tgl_lahir') is-invalid @enderror"
                                                            name="tgl_lahir" id="tgl_lahir"
                                                            value="{{ old('tgl_lahir', $user->tgl_lahir) }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                                        <div style="display: flex; gap: 20px; align-items: center;">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio"
                                                                    id="customRadioLaki" name="jenis_kelamin"
                                                                    value="Laki-Laki"
                                                                    {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-Laki' ? 'checked' : '' }}>
                                                                <label for="customRadioLaki"
                                                                    class="custom-control-label">Laki-Laki</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio"
                                                                    id="customRadioPerempuan" name="jenis_kelamin"
                                                                    value="Perempuan"
                                                                    {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
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
                                                        <input type="text"
                                                            class="form-control @error('alamat') is-invalid @enderror"
                                                            name="alamat" id="alamat"
                                                            value="{{ old('alamat', $user->alamat) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="negara">Negara</label>
                                                        <input type="text"
                                                            class="form-control @error('negara') is-invalid @enderror"
                                                            name="negara" id="negara"
                                                            value="{{ old('negara', $user->negara) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="provinsi">Provinsi</label>
                                                        <input type="text"
                                                            class="form-control @error('provinsi') is-invalid @enderror"
                                                            name="provinsi" id="provinsi"
                                                            value="{{ old('provinsi', $user->provinsi) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="kota">Kota</label>
                                                        <input type="text"
                                                            class="form-control @error('kota') is-invalid @enderror"
                                                            name="kota" id="kota"
                                                            value="{{ old('kota', $user->kota) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="kodepos">Kode Pos</label>
                                                        <input type="number"
                                                            class="form-control @error('kodepos') is-invalid @enderror"
                                                            name="kodepos" id="kode_pos"
                                                            value="{{ old('kodepos', $user->kodepos) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary mr-2">Simpan</button>
                            </div>
                        </form>
                    </div>
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
                            'data pengguna berhasil disubmit.');
                        window.location.href =
                            "{{ route('profile.profile.index') }}"; // Redirect to index page
                    } else if (response.info) {
                        // Flash message info
                        sessionStorage.setItem('info',
                            'Tidak melakukan perubahan data pada pengguna.');
                        window.location.href =
                            "{{ route('profile.profile.index') }}"; // Redirect to index page
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
                    submitButton.prop('disabled', false).text('Simpan');
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
