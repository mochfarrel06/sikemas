@extends('layouts.master')

@section('title-page')
    Edit
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Obat</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #38A6B1">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.medicines.index') }}" style="color: #38A6B1">Obat</a></li>
                        <li class="breadcrumb-item active">Obat</li>
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
                        <form id="main-form" action="{{ route('admin.medicines.update', $medicine->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Nama Obat</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        @error('name') is-invalid @enderror"
                                        value="{{ old('name', $medicine->name) }}">
                                </div>

                                <div class="form-group">
                                    <label for="price">Harga</label>
                                    <input type="number" id="price" name="price" class="form-control"
                                        @error('price') is-invalid @enderror"
                                        value="{{ old('price', $medicine->price) }}">
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary2 mr-2">Simpan</button>
                                <a href="{{ route('admin.medicines.index') }}" class="btn btn-warning">Kembali</a>
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
                            'Obat berhasil disubmit.');
                        window.location.href =
                            "{{ route('admin.medicines.index') }}"; // Redirect to index page
                    } else if (response.info) {
                        // Flash message info
                        sessionStorage.setItem('info',
                            'Tidak melakukan perubahan data pada Obat.');
                        window.location.href =
                            "{{ route('admin.medicines.index') }}"; // Redirect to index page
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
                        input.next('.invalid-feedback').remove();
                        input.after('<div class="invalid-feedback">' + error + '</div>');
                    }

                    const message = response.responseJSON.message ||
                        'Terdapat kesalahan pada proses Obat';
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
