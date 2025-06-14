@extends('layouts.master')

@section('title-page')
    Transaksi
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi Pasien</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <form id="main-form" method="POST" action="{{ route('transaction.transaction.store') }}">
                            @csrf

                            <div class="card-body">
                                <h5>Data Pasien</h5>
                                <div class="row" style="margin-bottom: 10px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Pasien</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->queue->patient->nama_depan }}" disabled>
                                                <input type="hidden" name="medical_record_id" value="{{ $medicalRecord->id }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Umur</label>
                                            <input type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($medicalRecord->queue->patient->tgl_lahir)->age }} Tahun"
                                                disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->queue->patient->alamat }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No BPJS</label>
                                            <input type="text" class="form-control" name="no_bpjs" id="no_bpjs"
                                                value="{{ $medicalRecord->queue->patient->no_bpjs }}"
                                                {{ $medicalRecord->queue->patient->no_bpjs ? '' : '' }}>
                                        </div>
                                    </div>
                                </div>

                                <div style="width: 100%; border-top:1px solid #c5c5c5; padding: 10px 0"></div>
                                <h5>Data Dokter</h5>
                                <div class="row" style="margin-bottom: 10px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Dokter</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->queue->doctor->nama_depan }} {{ $medicalRecord->queue->doctor->nama_belakang }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Poli</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->queue->doctor->specialization->name }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div style="width: 100%; border-top:1px solid #c5c5c5; padding: 10px 0"></div>
                                <h5>Data Rekam Medis</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Dokter</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->queue->doctor->nama_depan }} {{ $medicalRecord->queue->doctor->nama_belakang }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Poli</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->queue->doctor->specialization->name }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px">
                                    <div class="col-md-12">
                                        <label for="">Obat</label>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama Obat</th>
                                                    <th>Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $total = 0; @endphp
                                                @foreach ($medicalRecord->medicines as $medicine)
                                                    <tr>
                                                        <td>{{ $medicine->name }}</td>
                                                        <td>Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @php $total += $medicine->price; @endphp
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Total</th>
                                                    <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div style="width: 100%; border-top:1px solid #c5c5c5; padding: 10px 0"></div>
                                <h5>Data Transaksi</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jenis Pembayaran</label>
                                            <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control">
                                                <option value="">-- Pilih Jenis Pembayaran --</option>
                                                <option value="bayar_tunai">Bayar Tunai</option>

                                                @if ($medicalRecord->queue->patient->no_bpjs)
                                                    <option value="bayar_bpjs">Bayar BPJS</option>
                                                @endif
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Harga</label>
                                            <input type="number" class="form-control" id="total" name="total" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary2 mr-2">Simpan</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const noBpjsInput = document.getElementById('no_bpjs');
            const jenisPembayaranSelect = document.getElementById('jenis_pembayaran');

            function toggleBpjsOption() {
                const hasValue = noBpjsInput.value.trim() !== '';

                // Cek apakah opsi BPJS sudah ada
                const optionExists = [...jenisPembayaranSelect.options].some(opt => opt.value === 'bayar_bpjs');

                if (hasValue && !optionExists) {
                    // Tambahkan opsi BPJS
                    const bpjsOption = document.createElement('option');
                    bpjsOption.value = 'bayar_bpjs';
                    bpjsOption.text = 'Bayar BPJS';
                    jenisPembayaranSelect.appendChild(bpjsOption);
                } else if (!hasValue && optionExists) {
                    // Hapus opsi BPJS
                    for (let i = 0; i < jenisPembayaranSelect.options.length; i++) {
                        if (jenisPembayaranSelect.options[i].value === 'bayar_bpjs') {
                            jenisPembayaranSelect.remove(i);
                            break;
                        }
                    }

                    // Jika sebelumnya BPJS terpilih, ubah ke tunai
                    if (jenisPembayaranSelect.value === 'bayar_bpjs') {
                        jenisPembayaranSelect.value = 'bayar_tunai';
                    }
                }
            }

            // Jalankan saat halaman load
            toggleBpjsOption();

            // Jalankan saat mengetik di field No BPJS
            noBpjsInput.addEventListener('input', toggleBpjsOption);
        });
    </script>

    <script>
        $(document).ready(function() {
            const $submitBtn = $('#submit-btn');
            $('#main-form').on('submit', function(event) {
                event.preventDefault();

                const form = $(this)[0];
                const formData = new FormData(form);

                $submitBtn.prop('disabled', true).text('Loading...');

                $.ajax({
                    url: form.action,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            sessionStorage.setItem('success',
                                'Data Poli berhasil disubmit.');
                            window.location.href =
                                "{{ route('transaction.transaction.index') }}";
                        } else {
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
                            'Terdapat kesalahan pada proses Poli';
                        $('#flash-messages').html('<div class="alert alert-danger">' + message +
                            '</div>');
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).text('Tambah');
                    }
                });
            });

            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').text('');
            });
        });
    </script>
@endpush
