@extends('layouts.master')

@section('title-page')
    Transaksi
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #38A6B1">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaksi</li>
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
                                <h3 class="card-title">Tabel Transaksi</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pasien</th>
                                        <th>Dokter</th>
                                        <th>Pembayaran</th>
                                        <th>Tgl Periksa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td class="index">{{ $loop->index + 1 }}</td>
                                            <td>{{ $transaction->medicalRecord->queue->patient->nama_depan }} {{ $transaction->medicalRecord->queue->patient->nama_belakang }}</td>
                                            <td>{{ $transaction->medicalRecord->queue->doctor->nama_depan}} {{ $transaction->medicalRecord->queue->doctor->nama_belakang}}</td>
                                            <td>
                                                @if($transaction->jenis_pembayaran == 'bayar_bpjs')
                                                    BAYAR BPJS
                                                @else
                                                    BAYAR TUNAI
                                                @endif
                                            </td>
                                            <td>{{ $transaction->medicalRecord->queue->tgl_periksa}}</td>
                                            <td>
                                                 <a href="{{ route('transaction.transaction.nota', $transaction->id) }}" target="_blank" class="btn btn-sm btn-success d-flex align-items-center justify-content-center" style="gap: 5px"><i class="iconoir-printer" style="font-size: 15px"></i> Nota</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
