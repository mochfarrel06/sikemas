@extends('layouts.master')

@section('title-page')
    Detail
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">Dokter</a></li>
                        <li class="breadcrumb-item active">Detail</li>
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
                        <form>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Profile</label>
                                            <div>
                                                <img id="profileImage" class="profile-user-img img-fluid img-circle"
                                                    src="{{ asset($doctor->foto_dokter) }}" alt="User Dokter"
                                                    style="cursor: pointer; object-fit: cover; width: 120px; height: 120px; border-radius: 50%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_depan">Nama Depan</label>
                                            <input type="text" class="form-control" name="nama_depan" id="nama_depan"
                                                value="{{ $doctor->nama_depan }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_belakang">Nama Belakang</label>
                                            <input type="text" class="form-control" name="nama_belakang"
                                                id="nama_belakang" value="{{ $doctor->nama_belakang }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                value="{{ $doctor->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_hp">Nomor Kontak</label>
                                            <input type="text" class="form-control" name="no_hp" id="no_hp"
                                                value="{{ $doctor->no_hp }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"
                                                value="{{ $doctor->tgl_lahir }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <div style="display: flex; gap: 20px; align-items: center;">
                                                <div class="custom-control custom-radio">
                                                    <input
                                                        class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                                        type="radio" id="customRadioLaki" name="jenis_kelamin"
                                                        value="Laki-Laki"
                                                        {{ $doctor->jenis_kelamin === 'Laki-Laki' ? 'checked' : '' }}
                                                        disabled>
                                                    <label for="customRadioLaki"
                                                        class="custom-control-label">Laki-Laki</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input
                                                        class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                                        type="radio" id="customRadioPerempuan" name="jenis_kelamin"
                                                        value="Perempuan"
                                                        {{ $doctor->jenis_kelamin === 'Perempuan' ? 'checked' : '' }}
                                                        disabled>
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
                                            <input type="text" class="form-control" name="pengalaman" id="pengalaman"
                                                value="{{ $doctor->pengalaman }} tahun" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Golongan Darah</label>
                                            <input type="text" class="form-control"
                                                value="{{ $doctor->golongan_darah }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Spesialisasi</label>
                                            <input type="text" class="form-control"
                                                value="{{ $doctor->specialization->name }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="font-bolder mt-4 fs-4">Informasi Alamat</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control" name="alamat" id="alamat"
                                                value="{{ $doctor->alamat }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="negara">Negara</label>
                                            <input type="text" class="form-control" name="negara" id="negara"
                                                value="{{ $doctor->negara }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="provinsi">Provinsi</label>
                                            <input type="text" class="form-control" name="provinsi" id="provinsi"
                                                value="{{ $doctor->provinsi }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kota">Kota</label>
                                            <input type="text" class="form-control" name="kota" id="kota"
                                                value="{{ $doctor->kota }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kodepos">Kode Pos</label>
                                            <input type="number" class="form-control" name="kodepos" id="kode_pos"
                                                value="{{ $doctor->kodepos }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('admin.doctors.index') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>

                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
