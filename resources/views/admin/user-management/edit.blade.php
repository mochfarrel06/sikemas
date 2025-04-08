@extends('layouts.master')

@section('title-page')
    Edit
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Manajemen Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user-management.index') }}">Manajemen
                                Pengguna</a></li>
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
                        <form id="main-form" method="POST" action="{{ route('admin.user-management.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                @if ($user->role == 'admin')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_depan">Nama Depan</label>
                                                <input type="text"
                                                    class="form-control @error('nama_depan') is-invalid @enderror"
                                                    name="nama_depan" id="nama_depan" value="{{ $user->nama_depan }}">
                                                @error('nama_depan')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_belakang">Nama Belakang</label>
                                                <input type="text"
                                                    class="form-control @error('nama_belakang') is-invalid @enderror"
                                                    name="nama_belakang" id="nama_belakang"
                                                    value="{{ $user->nama_belakang }}">
                                                @error('nama_belakang')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    id="email" value="{{ old('email', $user->email) }}"
                                                    placeholder="Masukkan Email">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <select name="role" id="role"
                                                    class="form-control @error('role') is-invalid @enderror">
                                                    @if ($user->role == 'admin')
                                                        <option value="admin"
                                                            {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    @elseif ($user->role == 'dokter')
                                                        <option value="dokter"
                                                            {{ $user->role === 'dokter' ? 'selected' : '' }}>Dokter
                                                        </option>
                                                    @elseif ($user->role == 'pasien')
                                                        <option value="pasien"
                                                            {{ $user->role === 'pasien' ? 'selected' : '' }}>Pasien
                                                        </option>
                                                    @endif
                                                </select>
                                                @error('role')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Data request --}}
                                <input type="hidden" class="form-control" name="nama_depan" id="nama_depan" value="{{ $user->nama_depan }}">
                                <input type="hidden" class="form-control" name="nama_belakang" id="nama_belakang" value="{{ $user->nama_belakang }}">
                                <input type="hidden" class="form-control" name="email" id="email" value="{{ $user->email }}">
                                <input type="hidden" class="form-control" name="role" id="role" value="{{ $user->role }}">

                                <div class="row">
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
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary mr-2">Simpan</button>
                                <a href="{{ route('admin.user-management.index') }}" class="btn btn-warning">Kembali</a>
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
                            'data pengguna berhasil disubmit.');
                        window.location.href =
                            "{{ route('admin.user-management.index') }}"; // Redirect to index page
                    } else if (response.info) {
                        // Flash message info
                        sessionStorage.setItem('info',
                            'Tidak melakukan perubahan data pada pengguna.');
                        window.location.href =
                            "{{ route('admin.user-management.index') }}"; // Redirect to index page
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
