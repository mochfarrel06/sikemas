@extends('layouts.master')

@section('title-page')
    Tambah
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Rekam Medis</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}"
                                style="color: #38A6B1">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('doctor.medical-record.index') }}"
                                style="color: #38A6B1">Rekam Medis</a></li>
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
                        <form id="main-form" method="POST" action="{{ route('doctor.medical-record.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="queue_id">Pilih Antrean Pasien</label>
                                            <select name="queue_id" id="queue_id"
                                                class="form-control @error('queue_id') is-invalid @enderror">
                                                <option value="">-- Pilih Pasien --</option>
                                                @foreach ($queues as $queue)
                                                    <option value="{{ $queue->id }}">{{ $queue->patient->kode_pasien }} -
                                                        {{ $queue->patient->nama_depan }}
                                                        {{ $queue->patient->nama_belakang }} -
                                                        {{ $queue->tgl_periksa }}</option>
                                                @endforeach
                                            </select>
                                            @error('queue_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="medicine_id">Pilih Obat</label>
                                            <select name="medicine_id[]" id="medicine_id"
                                                class="form-control select2 @error('medicine_id') is-invalid @enderror"
                                                multiple>
                                                @foreach ($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('medicine_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="diagnosis">Diagnosis</label>
                                            <input list="diagnosis-list" type="text" name="diagnosis"
                                                class="form-control @error('diagnosis') is-invalid @enderror">
                                            <datalist id="diagnosis-list">
                                                @foreach ($diagnoses as $diag)
                                                    <option value="{{ $diag }}">
                                                @endforeach
                                            </datalist>
                                            @error('diagnosis')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="resep">Perawatan</label>
                                            <input type="text" class="form-control" name="resep"
                                                @error('resep') is-invalid @enderror">
                                            @error('resep')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="plano_test">Plano Test</label>
                                            <input type="text"
                                                class="form-control @error('plano_test') is-invalid @enderror"
                                                name="plano_test" value="{{ old('plano_test') }}">
                                            @error('plano_test')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gula_darah_acak">Gula Darah Acak</label>
                                            <input type="text"
                                                class="form-control @error('gula_darah_acak') is-invalid @enderror"
                                                name="gula_darah_acak" value="{{ old('gula_darah_acak') }}">
                                            @error('gula_darah_acak')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gula_darah_puasa">Gula Darah Puasa</label>
                                            <input type="text"
                                                class="form-control @error('gula_darah_puasa') is-invalid @enderror"
                                                name="gula_darah_puasa" value="{{ old('gula_darah_puasa') }}">
                                            @error('gula_darah_puasa')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gula_darah_2jm_pp">Gula Darah 2 Jam PP</label>
                                            <input type="text"
                                                class="form-control @error('gula_darah_2jm_pp') is-invalid @enderror"
                                                name="gula_darah_2jm_pp" value="{{ old('gula_darah_2jm_pp') }}">
                                            @error('gula_darah_2jm_pp')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="analisa_lemak">Analisa Lemak</label>
                                            <input type="text"
                                                class="form-control @error('analisa_lemak') is-invalid @enderror"
                                                name="analisa_lemak" value="{{ old('analisa_lemak') }}">
                                            @error('analisa_lemak')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cholesterol">Cholesterol</label>
                                            <input type="text"
                                                class="form-control @error('cholesterol') is-invalid @enderror"
                                                name="cholesterol" value="{{ old('cholesterol') }}">
                                            @error('cholesterol')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="trigliserida">Trigliserida</label>
                                            <input type="text"
                                                class="form-control @error('trigliserida') is-invalid @enderror"
                                                name="trigliserida" value="{{ old('trigliserida') }}">
                                            @error('trigliserida')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hdl">HDL</label>
                                            <input type="text" class="form-control @error('hdl') is-invalid @enderror"
                                                name="hdl" value="{{ old('hdl') }}">
                                            @error('hdl')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ldl">LDL</label>
                                            <input type="text" class="form-control @error('ldl') is-invalid @enderror"
                                                name="ldl" value="{{ old('ldl') }}">
                                            @error('ldl')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="asam_urat">Asam Urat</label>
                                            <input type="text"
                                                class="form-control @error('asam_urat') is-invalid @enderror"
                                                name="asam_urat" value="{{ old('asam_urat') }}">
                                            @error('asam_urat')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bun">BUN</label>
                                            <input type="text" class="form-control @error('bun') is-invalid @enderror"
                                                name="bun" value="{{ old('bun') }}">
                                            @error('bun')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="creatinin">Creatinin</label>
                                            <input type="text"
                                                class="form-control @error('creatinin') is-invalid @enderror"
                                                name="creatinin" value="{{ old('creatinin') }}">
                                            @error('creatinin')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sgot">SGOT</label>
                                            <input type="text"
                                                class="form-control @error('sgot') is-invalid @enderror" name="sgot"
                                                value="{{ old('sgot') }}">
                                            @error('sgot')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sgpt">SGPT</label>
                                            <input type="text"
                                                class="form-control @error('sgpt') is-invalid @enderror" name="sgpt"
                                                value="{{ old('sgpt') }}">
                                            @error('sgpt')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warna">Warna</label>
                                            <input type="text"
                                                class="form-control @error('warna') is-invalid @enderror" name="warna"
                                                value="{{ old('warna') }}">
                                            @error('warna')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ph">pH</label>
                                            <input type="text" class="form-control @error('ph') is-invalid @enderror"
                                                name="ph" value="{{ old('ph') }}">
                                            @error('ph')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="berat_jenis">Berat Jenis</label>
                                            <input type="text"
                                                class="form-control @error('berat_jenis') is-invalid @enderror"
                                                name="berat_jenis" value="{{ old('berat_jenis') }}">
                                            @error('berat_jenis')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reduksi">Reduksi</label>
                                            <input type="text"
                                                class="form-control @error('reduksi') is-invalid @enderror"
                                                name="reduksi" value="{{ old('reduksi') }}">
                                            @error('reduksi')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="protein">Protein</label>
                                            <input type="text"
                                                class="form-control @error('protein') is-invalid @enderror"
                                                name="protein" value="{{ old('protein') }}">
                                            @error('protein')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bilirubin">Bilirubin</label>
                                            <input type="text"
                                                class="form-control @error('bilirubin') is-invalid @enderror"
                                                name="bilirubin" value="{{ old('bilirubin') }}">
                                            @error('bilirubin')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="urobilinogen">Urobilinogen</label>
                                            <input type="text"
                                                class="form-control @error('urobilinogen') is-invalid @enderror"
                                                name="urobilinogen" value="{{ old('urobilinogen') }}">
                                            @error('urobilinogen')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nitrit">Nitrit</label>
                                            <input type="text"
                                                class="form-control @error('nitrit') is-invalid @enderror" name="nitrit"
                                                value="{{ old('nitrit') }}">
                                            @error('nitrit')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="keton">Keton</label>
                                            <input type="text"
                                                class="form-control @error('keton') is-invalid @enderror" name="keton"
                                                value="{{ old('keton') }}">
                                            @error('keton')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sedimen_lekosit">Sedimen Lekosit</label>
                                            <input type="text"
                                                class="form-control @error('sedimen_lekosit') is-invalid @enderror"
                                                name="sedimen_lekosit" value="{{ old('sedimen_lekosit') }}">
                                            @error('sedimen_lekosit')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sedimen_eritrosit">Sedimen Eritrosit</label>
                                            <input type="text"
                                                class="form-control @error('sedimen_eritrosit') is-invalid @enderror"
                                                name="sedimen_eritrosit" value="{{ old('sedimen_eritrosit') }}">
                                            @error('sedimen_eritrosit')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sedimen_epitel">Sedimen Epitel</label>
                                            <input type="text"
                                                class="form-control @error('sedimen_epitel') is-invalid @enderror"
                                                name="sedimen_epitel" value="{{ old('sedimen_epitel') }}">
                                            @error('sedimen_epitel')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sedimen_kristal">Sedimen Kristal</label>
                                            <input type="text"
                                                class="form-control @error('sedimen_kristal') is-invalid @enderror"
                                                name="sedimen_kristal" value="{{ old('sedimen_kristal') }}">
                                            @error('sedimen_kristal')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sedimen_bakteri">Sedimen Bakteri</label>
                                            <input type="text"
                                                class="form-control @error('sedimen_bakteri') is-invalid @enderror"
                                                name="sedimen_bakteri" value="{{ old('sedimen_bakteri') }}">
                                            @error('sedimen_bakteri')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hemoglobin">Hemoglobin</label>
                                            <input type="text"
                                                class="form-control @error('hemoglobin') is-invalid @enderror"
                                                name="hemoglobin" value="{{ old('hemoglobin') }}">
                                            @error('hemoglobin')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="leukosit">Leukosit</label>
                                            <input type="text"
                                                class="form-control @error('leukosit') is-invalid @enderror"
                                                name="leukosit" value="{{ old('leukosit') }}">
                                            @error('leukosit')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="erytrosit">Erytrosit</label>
                                            <input type="text"
                                                class="form-control @error('erytrosit') is-invalid @enderror"
                                                name="erytrosit" value="{{ old('erytrosit') }}">
                                            @error('erytrosit')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="trombosit">Trombosit</label>
                                            <input type="text"
                                                class="form-control @error('trombosit') is-invalid @enderror"
                                                name="trombosit" value="{{ old('trombosit') }}">
                                            @error('trombosit')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pcv">PCV</label>
                                            <input type="text" class="form-control @error('pcv') is-invalid @enderror"
                                                name="pcv" value="{{ old('pcv') }}">
                                            @error('pcv')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dif">Dif</label>
                                            <input type="text" class="form-control @error('dif') is-invalid @enderror"
                                                name="dif" value="{{ old('dif') }}">
                                            @error('dif')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bleeding_time">Bleeding Time</label>
                                            <input type="text"
                                                class="form-control @error('bleeding_time') is-invalid @enderror"
                                                name="bleeding_time" value="{{ old('bleeding_time') }}">
                                            @error('bleeding_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="clotting_time">Clotting time</label>
                                            <input type="text"
                                                class="form-control @error('clotting_time') is-invalid @enderror"
                                                name="clotting_time" value="{{ old('clotting_time') }}">
                                            @error('clotting_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="salmonella_o">Salmonella O</label>
                                            <input type="text"
                                                class="form-control @error('salmonella_o') is-invalid @enderror"
                                                name="salmonella_o" value="{{ old('salmonella_o') }}">
                                            @error('salmonella_o')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="salmonella_h">Salmonella H</label>
                                            <input type="text"
                                                class="form-control @error('salmonella_h') is-invalid @enderror"
                                                name="salmonella_h" value="{{ old('salmonella_h') }}">
                                            @error('salmonella_h')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="salmonella_p_a">Salmonella P A</label>
                                            <input type="text"
                                                class="form-control @error('salmonella_p_a') is-invalid @enderror"
                                                name="salmonella_p_a" value="{{ old('salmonella_p_a') }}">
                                            @error('salmonella_p_a')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="salmonella_p_b">Salmonella P B</label>
                                            <input type="text"
                                                class="form-control @error('salmonella_p_b') is-invalid @enderror"
                                                name="salmonella_p_b" value="{{ old('salmonella_p_b') }}">
                                            @error('salmonella_p_b')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hbsag">HBsAg</label>
                                            <input type="text"
                                                class="form-control @error('hbsag') is-invalid @enderror" name="hbsag"
                                                value="{{ old('hbsag') }}">
                                            @error('hbsag')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vdrl">VDRL</label>
                                            <input type="text"
                                                class="form-control @error('vdrl') is-invalid @enderror" name="vdrl"
                                                value="{{ old('vdrl') }}">
                                            @error('vdrl')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="catatan_medis">Catatan Medis</label>
                                    <textarea name="catatan_medis" class="form-control @error('catatan_medis') is-invalid @enderror"></textarea>
                                    @error('catatan_medis')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary2 mr-2">Simpan</button>
                                <a href="{{ route('doctor.medical-record.index') }}" class="btn btn-warning">Kembali</a>
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
        $(document).ready(function() {
            // const $submitBtn = $('#submit-btn');
            // $('#main-form').on('submit', function(event) {
            //     event.preventDefault();

            //     const form = $(this)[0];
            //     const formData = new FormData(form);

            //     $submitBtn.prop('disabled', true).text('Loading...');

            //     $.ajax({
            //         url: form.action,
            //         method: 'POST',
            //         data: formData,
            //         processData: false,
            //         contentType: false,
            //         success: function(response) {
            //             if (response.success && response.redirect) {
            //                 sessionStorage.setItem('success',
            //                     'Data Rekam Medis berhasil disubmit.');
            //                 window.location.href = response
            //                 .redirect; // arahkan ke halaman transaksi create
            //             } else {
            //                 $('#flash-messages').html('<div class="alert alert-danger">' +
            //                     (response.error || 'Terjadi kesalahan.') + '</div>');
            //             }
            //         }
            //         error: function(response) {
            //             const errors = response.responseJSON.errors;
            //             for (let field in errors) {
            //                 let input = $('[name=' + field + ']');
            //                 let error = errors[field][0];
            //                 input.addClass('is-invalid');
            //                 input.next('.invalid-feedback').remove();
            //                 input.after('<div class="invalid-feedback">' + error + '</div>');
            //             }

            //             const message = response.responseJSON.message ||
            //                 'Terdapat kesalahan pada proses rekam medis';
            //             $('#flash-messages').html('<div class="alert alert-danger">' + message +
            //                 '</div>');
            //         },
            //         complete: function() {
            //             $submitBtn.prop('disabled', false).text('Simpan');
            //         }
            //     });
            // });

            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').text('');
            });
        });
    </script>
@endpush
