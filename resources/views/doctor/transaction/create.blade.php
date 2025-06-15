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
                                                    <option value="{{ $medicalRecord->id }}" data-no-bpjs="{{ $medicalRecord->queue->patient->no_bpjs }}">
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
                                            <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control @error('jenis_pembayaran') is-invalid @enderror">
                                                <option value="">-- Pilih Jenis Pembayaran --</option>
                                                <option value="bayar_tunai">Bayar Tunai</option>
                                            </select>
                                            @error('jenis_pembayaran')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Harga</label>
                                            <input type="number" class="form-control @error('total') is-invalid @enderror" id="total" name="total" readonly />
                                            @error('total')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
        $(document).ready(function() {
            let originalTotal = 0; // Simpan total asli
            let currentPatientBpjs = ''; // Simpan no BPJS pasien yang dipilih

            // Event listener untuk perubahan pasien
            $('#medical_record_id').on('change', function() {
                const recordId = $(this).val();
                const selectedOption = $(this).find('option:selected');
                currentPatientBpjs = selectedOption.data('no-bpjs') || '';

                // Reset jenis pembayaran
                $('#jenis_pembayaran').val('');
                updatePaymentOptions();

                if (!recordId) {
                    $('#obat-body').html('');
                    $('#obat-total').text('Rp 0');
                    $('#total').val(0);
                    originalTotal = 0;
                    return;
                }

                // Ambil data obat
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

                        // Simpan total asli
                        originalTotal = data.total;

                        // Tampilkan total asli (akan berubah sesuai jenis pembayaran)
                        $('#obat-total').text('Rp ' + parseInt(data.total).toLocaleString('id-ID'));
                        $('#total').val(data.total);
                    },
                    error: function() {
                        alert('Gagal mengambil data obat.');
                    }
                });
            });

            // Function untuk update opsi pembayaran
            function updatePaymentOptions() {
                const jenisPembayaranSelect = $('#jenis_pembayaran');

                // Reset options
                jenisPembayaranSelect.html(`
                    <option value="">-- Pilih Jenis Pembayaran --</option>
                    <option value="bayar_tunai">Bayar Tunai</option>
                `);

                // Tambahkan opsi BPJS jika pasien memiliki no BPJS
                if (currentPatientBpjs && currentPatientBpjs.trim() !== '') {
                    jenisPembayaranSelect.append('<option value="bayar_bpjs">Bayar BPJS</option>');
                }
            }

            // Event listener untuk perubahan jenis pembayaran
            $('#jenis_pembayaran').on('change', function() {
                const jenisPayment = $(this).val();
                const totalInput = $('#total');
                const obatTotalDisplay = $('#obat-total');

                if (jenisPayment === 'bayar_bpjs') {
                    // Jika BPJS dipilih, set total menjadi 0
                    totalInput.val(0);
                    obatTotalDisplay.text('Rp 0');
                } else if (jenisPayment === 'bayar_tunai') {
                    // Jika tunai dipilih, kembalikan ke total asli
                    if (originalTotal > 0) {
                        totalInput.val(originalTotal);
                        obatTotalDisplay.text('Rp ' + parseInt(originalTotal).toLocaleString('id-ID'));
                    }
                } else {
                    // Jika tidak ada yang dipilih, kembalikan ke total asli
                    if (originalTotal > 0) {
                        totalInput.val(originalTotal);
                        obatTotalDisplay.text('Rp ' + parseInt(originalTotal).toLocaleString('id-ID'));
                    }
                }
            });

            // Form submission dengan AJAX
            const $submitBtn = $('#submit-btn');
            $('#main-form').on('submit', function(event) {
                event.preventDefault();

                const form = $(this)[0];
                const formData = new FormData(form);
                const jenisPayment = $('#jenis_pembayaran').val();

                // Validasi: jika BPJS, pastikan total adalah 0
                if (jenisPayment === 'bayar_bpjs') {
                    formData.set('total', '0');
                }

                $submitBtn.prop('disabled', true).text('Loading...');

                $.ajax({
                    url: form.action,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            sessionStorage.setItem('success', 'Data Transaksi berhasil disimpan.');
                            window.location.href = "{{ route('transaction.transaction.index') }}";
                        } else {
                            $('#flash-messages').html('<div class="alert alert-danger">' + response.error + '</div>');
                        }
                    },
                    error: function(response) {
                        // Clear previous error states
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();

                        if (response.responseJSON && response.responseJSON.errors) {
                            const errors = response.responseJSON.errors;
                            for (let field in errors) {
                                let input = $('[name=' + field + ']');
                                let error = errors[field][0];
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + error + '</div>');
                            }
                        }

                        const message = response.responseJSON && response.responseJSON.message ?
                            response.responseJSON.message : 'Terdapat kesalahan pada proses transaksi';

                        $('#flash-messages').html('<div class="alert alert-danger">' + message + '</div>');
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).text('Simpan');
                    }
                });
            });

            // Clear validation errors on input change
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            });

            // Display flash messages if any
            const successMessage = sessionStorage.getItem('success');
            if (successMessage) {
                $('#flash-messages').html('<div class="alert alert-success">' + successMessage + '</div>');
                sessionStorage.removeItem('success');
            }
        });
    </script>

    <!-- Script untuk compatibility dengan sistem yang sudah ada -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script ini untuk kompatibilitas dengan kode lama jika diperlukan
            const noBpjsInput = document.getElementById('no_bpjs');

            // Jika ada input no_bpjs terpisah (untuk form lain)
            if (noBpjsInput) {
                const jenisPembayaranSelect = document.getElementById('jenis_pembayaran');

                function toggleBpjsOption() {
                    const hasValue = noBpjsInput.value.trim() !== '';
                    const optionExists = [...jenisPembayaranSelect.options].some(opt => opt.value === 'bayar_bpjs');

                    if (hasValue && !optionExists) {
                        const bpjsOption = document.createElement('option');
                        bpjsOption.value = 'bayar_bpjs';
                        bpjsOption.text = 'Bayar BPJS';
                        jenisPembayaranSelect.appendChild(bpjsOption);
                    } else if (!hasValue && optionExists) {
                        for (let i = 0; i < jenisPembayaranSelect.options.length; i++) {
                            if (jenisPembayaranSelect.options[i].value === 'bayar_bpjs') {
                                jenisPembayaranSelect.remove(i);
                                break;
                            }
                        }

                        if (jenisPembayaranSelect.value === 'bayar_bpjs') {
                            jenisPembayaranSelect.value = 'bayar_tunai';
                        }
                    }
                }

                toggleBpjsOption();
                noBpjsInput.addEventListener('input', toggleBpjsOption);
            }
        });
    </script>
@endpush