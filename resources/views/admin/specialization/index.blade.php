@extends('layouts.master')

@section('title-page')
    Poli
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Poli</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #38A6B1">Dashboard</a></li>
                        <li class="breadcrumb-item active">Poli</li>
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
                                <h3 class="card-title">Tabel Poli</h3>
                            </div>

                            <div class="ml-auto">
                                <a href="{{ route('admin.specializations.create') }}"
                                    class="btn btn-primary2 d-flex align-items-center"><i
                                        class="iconoir-plus-circle mr-2"></i> Tambah</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Poli</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($specializations as $specialization)
                                        <tr>
                                            <td class="index">{{ $loop->index + 1 }}</td>
                                            <td>{{ $specialization->name }}</td>
                                            <td>
                                                {{-- <div class="btn-group">
                                                    <a data-toggle="dropdown">
                                                        <i class="iconoir-more-vert"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('admin.specializations.show', $specialization->id) }}"><i
                                                                    class="iconoir-eye-solid mr-2"></i> Detail</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('admin.specializations.edit', $specialization->id) }}"><i
                                                                    class="iconoir-edit-pencil mr-2"></i> Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item delete-item"
                                                                href="{{ route('admin.specializations.destroy', $specialization->id) }}"><i
                                                                    class="iconoir-trash-solid mr-2"></i> Hapus</a>
                                                        </li>
                                                    </ul>
                                                </div> --}}
                                                <div class="d-flex align-items-center" style="gap: 10px">
                                                    <a href="{{ route('admin.specializations.show', $specialization->id) }}" class="btn btn-sm btn-warning d-flex align-items-center justify-content-center" style="gap: 5px"><i class="iconoir-eye-solid" style="font-size: 15px"></i> Detail</a>
                                                    <a href="{{ route('admin.specializations.edit', $specialization->id) }}" class="btn btn-sm btn-success d-flex align-items-center justify-content-center" style="gap: 5px"><i class="iconoir-edit-pencil" style="font-size: 15px"></i> Edit</a>
                                                    {{-- <a href="{{ route('admin.specializations.destroy', $specialization->id) }}" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center delete-item"><i class="iconoir-trash-solid" style="font-size: 15px"></i></a> --}}
                                                    <buttton type="button" data-id="{{ $specialization->id }}" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center btn-delete" style="gap: 5px"><i class="iconoir-trash-solid" style="font-size: 15px"></i> Hapus</buttton>
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
                        <!-- /.card-body -->
                    </div>
                </section>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
                        form.action = `/admin/specializations/${id}`;
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
