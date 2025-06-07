@extends('layouts.master')

@section('title-page')
    Pasien
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pasien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #38A6B1">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pasien</li>
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
                        <div class="card-header d-flex">
                            <div class="d-flex align-items-center">
                                <i class="iconoir-table mr-2"></i>
                                <h3 class="card-title">Tabel Pasien</h3>
                            </div>

                            <div class="ml-auto">
                                <a href="{{ route('admin.patients.create') }}"
                                    class="btn btn-primary2 d-flex align-items-center"><i
                                        class="iconoir-plus-circle mr-2"></i> Tambah</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Pasien</th>
                                        <th>Pasien</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients as $patient)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $patient->kode_pasien }}</td>
                                            <td>{{ $patient->nama_depan }} {{ $patient->nama_belakang }}</td>
                                            <td>
                                                {{-- <div class="btn-group">
                                                    <a data-toggle="dropdown">
                                                        <i class="iconoir-more-vert"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('admin.patients.edit', $patient->id) }}"><i
                                                                class="iconoir-edit-pencil mr-2"></i> Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item delete-item"
                                                                href="{{ route('admin.patients.destroy', $patient->id) }}"><i
                                                                class="iconoir-trash-solid mr-2"></i> Hapus</a>
                                                        </li>
                                                    </ul>
                                                </div> --}}
                                                <div class="d-flex align-items-center" style="gap: 10px">
                                                    <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-sm btn-success d-flex align-items-center justify-content-center" style="gap: 5px"><i class="iconoir-edit-pencil" style="font-size: 15px"></i> Edit</a>
                                                    <buttton type="button" data-id="{{ $patient->id }}" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center btn-delete" style="gap: 5px"><i class="iconoir-trash-solid" style="font-size: 15px"></i> Hapus</buttton>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <form id="delete-form" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".btn-delete").forEach(function(button) {
            button.addEventListener("click", function() {
                let id = this.getAttribute("data-id");
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data ini akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.getElementById("delete-form");
                        form.action = `/admin/patients/${id}`;
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
