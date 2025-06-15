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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Pasien</label>
                                            <select name="medical_record_id" id="medical_record_id"
                                                class="form-control @error('medical_record_id') is-invalid @enderror">
                                                <option value="">-- Pilih Pasien --</option>
                                                @foreach ($medicalRecords as $medicalRecord)
                                                    <option value="{{ $medicalRecord->id }}">
                                                        {{ $medicalRecord->queue->patient->nama_depan }}
                                                        {{ $medicalRecord->queue->patient->nama_belakang }}</option>
                                                @endforeach
                                            </select>
                                            @error('medical_record_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
                                            <tbody id="obat-body">
                                                <!-- Data obat akan dimuat via JavaScript -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Total</th>
                                                    <th id="obat-total">Rp 0</th>
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

    <script>
    $(document).ready(function() {
        $('#medical_record_id').on('change', function() {
            const recordId = $(this).val();

            if (!recordId) {
                $('#obat-body').html('');
                $('#obat-total').text('Rp 0');
                $('#total_hidden').val(0);
                return;
            }

            $.ajax({
                url: `/transaction/get-medicines/${recordId}`,
                method: 'GET',
                success: function(data) {
                    let rows = '';
                    data.medicines.forEach(med => {
                        rows += `
                            <tr>
                                <td>${med.name}</td>
                                <td>Rp ${parseInt(med.price).toLocaleString('id-ID')}</td>
                            </tr>
                        `;
                    });

                    $('#obat-body').html(rows);
                    $('#obat-total').text('Rp ' + parseInt(data.total).toLocaleString('id-ID'));
                    $('#total_hidden').val(data.total);
                },
                error: function() {
                    alert('Gagal mengambil data obat.');
                }
            });
        });
    });
</script>

@endpush
