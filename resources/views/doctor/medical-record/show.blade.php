@extends('layouts.master')

@section('title-page')
    Detail
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Rekam Medis</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}"
                                style="color: #38A6B1">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('doctor.medical-record.index') }}"
                                style="color: #38A6B1">Rekam Medis</a></li>
                        {{-- <li class="breadcrumb-item active">Detail</li> --}}
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
                        <form action="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Pasien</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->user->nama_depan }} {{ $medicalRecord->user->nama_belakang }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Umur</label>
                                            <input type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($medicalRecord->queue->patient->tgl_lahir)->age }} tahun"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Diagnosis</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->diagnosis }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Resep</label>
                                            <input type="text" class="form-control" value="{{ $medicalRecord->resep }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Obat</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->medicine->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Resep</label>
                                            <input type="text" class="form-control" value="{{ $medicalRecord->resep }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Catatan Medis</label>
                                            <textarea class="form-control" cols="30" rows="10" disabled>{{ $medicalRecord->catatan_medis }}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="plano_test">Plano Test</label>
                                            <input type="text"
                                                class="form-control @error('plano_test') is-invalid @enderror"
                                                name="plano_test" value="{{ $medicalRecord->plano_test ?? '' }}" disabled>
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
                                                name="gula_darah_acak" value="{{ $medicalRecord->gula_darah_acak ?? '' }}"
                                                disabled>
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
                                                name="gula_darah_puasa"
                                                value="{{ $medicalRecord->gula_darah_puasa ?? '' }}" disabled>
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
                                                name="gula_darah_2jm_pp"
                                                value="{{ $medicalRecord->gula_darah_2jm_pp ?? '' }}" disabled>
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
                                                name="analisa_lemak" value="{{ $medicalRecord->analisa_lemak ?? '' }}"
                                                disabled>
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
                                                name="cholesterol" value="{{ $medicalRecord->cholesterol ?? '' }}"
                                                disabled>
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
                                                name="trigliserida" value="{{ $medicalRecord->trigliserida ?? '' }}"
                                                disabled>
                                            @error('trigliserida')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hdl">HDL</label>
                                            <input type="text" class="form-control @error('hdl') is-invalid @enderror"
                                                name="hdl" value="{{ $medicalRecord->hdl ?? '' }}" disabled>
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
                                                name="ldl" value="{{ $medicalRecord->ldl ?? '' }}" disabled>
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
                                                name="asam_urat" value="{{ $medicalRecord->asam_urat ?? '' }}" disabled>
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
                                                name="bun" value="{{ $medicalRecord->bun ?? '' }}" disabled>
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
                                                name="creatinin" value="{{ $medicalRecord->creatinin ?? '' }}" disabled>
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
                                                value="{{ $medicalRecord->sgot ?? '' }}" disabled>
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
                                                value="{{ $medicalRecord->sgpt ?? '' }}" disabled>
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
                                                value="{{ $medicalRecord->warna ?? '' }}" disabled>
                                            @error('warna')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ph">pH</label>
                                            <input type="text" class="form-control @error('ph') is-invalid @enderror"
                                                name="ph" value="{{ $medicalRecord->ph ?? '' }}" disabled>
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
                                                name="berat_jenis" value="{{ $medicalRecord->berat_jenis ?? '' }}"
                                                disabled>
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
                                                name="reduksi" value="{{ $medicalRecord->reduksi ?? '' }}" disabled>
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
                                                name="protein" value="{{ $medicalRecord->protein ?? '' }}" disabled>
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
                                                name="bilirubin" value="{{ $medicalRecord->bilirubin ?? '' }}" disabled>
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
                                                name="urobilinogen" value="{{ $medicalRecord->urobilinogen ?? '' }}"
                                                disabled>
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
                                                value="{{ $medicalRecord->nitrit ?? '' }}" disabled>
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
                                                value="{{ $medicalRecord->keton ?? '' }}" disabled>
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
                                                name="sedimen_lekosit"
                                                value="{{ $medicalRecord->sedimen_lekosit ?? '' }}" disabled>
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
                                                name="sedimen_eritrosit"
                                                value="{{ $medicalRecord->sedimen_eritrosit ?? '' }}" disabled>
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
                                                name="sedimen_epitel" value="{{ $medicalRecord->sedimen_epitel ?? '' }}"
                                                disabled>
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
                                                name="sedimen_kristal"
                                                value="{{ $medicalRecord->sedimen_kristal ?? '' }}" disabled>
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
                                                name="sedimen_bakteri"
                                                value="{{ $medicalRecord->sedimen_bakteri ?? '' }}" disabled>
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
                                                name="hemoglobin" value="{{ $medicalRecord->hemoglobin ?? '' }}"
                                                disabled>
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
                                                name="leukosit" value="{{ $medicalRecord->leukosit ?? '' }}" disabled>
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
                                                name="erytrosit" value="{{ $medicalRecord->erytrosit ?? '' }}" disabled>
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
                                                name="trombosit" value="{{ $medicalRecord->trombosit ?? '' }}" disabled>
                                            @error('trombosit')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dif">Dif</label>
                                            <input type="text"
                                                class="form-control @error('dif') is-invalid @enderror"
                                                name="dif" value="{{ $medicalRecord->dif ?? '' }}" disabled>
                                            @error('dif')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bleeding_time">Bleeding Time</label>
                                            <input type="text"
                                                class="form-control @error('bleeding_time') is-invalid @enderror"
                                                name="bleeding_time" value="{{ $medicalRecord->bleeding_time ?? '' }}" disabled>
                                            @error('bleeding_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="clotting_time">Clotting Time</label>
                                            <input type="text"
                                                class="form-control @error('clotting_time') is-invalid @enderror"
                                                name="clotting_time" value="{{ $medicalRecord->clotting_time ?? '' }}" disabled>
                                            @error('clotting_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="salmonella_o">Salmonella O</label>
                                            <input type="text"
                                                class="form-control @error('salmonella_o') is-invalid @enderror"
                                                name="salmonella_o" value="{{ $medicalRecord->salmonella_o ?? '' }}" disabled>
                                            @error('salmonella_o')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="salmonella_h">Salmonella H</label>
                                            <input type="text"
                                                class="form-control @error('salmonella_h') is-invalid @enderror"
                                                name="salmonella_h" value="{{ $medicalRecord->salmonella_h ?? '' }}" disabled>
                                            @error('salmonella_h')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="salmonella_p_a">Salmonella P A</label>
                                            <input type="text"
                                                class="form-control @error('salmonella_p_a') is-invalid @enderror"
                                                name="salmonella_p_a" value="{{ $medicalRecord->salmonella_p_a ?? '' }}" disabled>
                                            @error('salmonella_p_a')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="salmonella_p_b">Salmonella P B</label>
                                            <input type="text"
                                                class="form-control @error('salmonella_p_b') is-invalid @enderror"
                                                name="salmonella_p_b" value="{{ $medicalRecord->salmonella_p_b ?? '' }}" disabled>
                                            @error('salmonella_p_b')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hbsag">hbsag</label>
                                            <input type="text"
                                                class="form-control @error('hbsag') is-invalid @enderror"
                                                name="hbsag" value="{{ $medicalRecord->hbsag ?? '' }}" disabled>
                                            @error('hbsag')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vdrl">VDRL</label>
                                            <input type="text"
                                                class="form-control @error('vdrl') is-invalid @enderror"
                                                name="vdrl" value="{{ $medicalRecord->vdrl ?? '' }}" disabled>
                                            @error('vdrl')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="plano_test">Plano Test</label>
                                            <input type="text"
                                                class="form-control @error('plano_test') is-invalid @enderror"
                                                name="plano_test" value="{{ $medicalRecord->plano_test ?? '' }}" disabled>
                                            @error('plano_test')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <a href="{{ route('doctor.medical-record.index') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
