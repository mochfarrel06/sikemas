@section('content')
    <div class="card-body">
        <h5>Data Pasien</h5>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Pasien</label>
                    <input type="text" class="form-control" value="{{ $medicalRecord->queue->patient->nama_depan }}"
                        disabled>
                    <input type="hidden" name="medical_record_id" value="{{ $medicalRecord->id }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Umur</label>
                    <input type="text" class="form-control"
                        value="{{ \Carbon\Carbon::parse($medicalRecord->queue->patient->tgl_lahir)->age }} Tahun" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" value="{{ $medicalRecord->queue->patient->alamat }}"
                        disabled>
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
@endsection
