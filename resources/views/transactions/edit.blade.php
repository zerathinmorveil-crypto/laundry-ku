@extends('adminlte::page')
@section('title', 'Edit Transaksi')
@section('content_header')
    <h1>Edit Transaksi</h1>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Form Edit Transaksi: {{ $transaction->nomor_nota }}</h3>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Nota</label>
                                <input type="text" class="form-control" value="{{ $transaction->nomor_nota }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk', $transaction->tanggal_masuk->format('Y-m-d')) }}" required>
                                @error('tanggal_masuk')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Customer</label>
                        <select name="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $transaction->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->nama_pelanggan }} - {{ $customer->nomor_telepon }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Layanan</label>
                        <select name="serpice_id" id="select_serpice" class="form-control @error('serpice_id') is-invalid @enderror" required>
                            @foreach($serpices as $serpice)
                                <option value="{{ $serpice->id }}" 
                                        data-harga="{{ $serpice->harga_per_kg }}"
                                        {{ old('serpice_id', $transaction->serpice_id) == $serpice->id ? 'selected' : '' }}>
                                    {{ $serpice->nama_layanan }} - Rp {{ number_format($serpice->harga_per_kg, 0, ',', '.') }}/Kg
                                </option>
                            @endforeach
                        </select>
                        @error('serpice_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga per Kg (Info)</label>
                                <input type="text" id="info_harga" class="form-control" value="Rp {{ number_format($transaction->serpice->harga_per_kg, 0, ',', '.') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Total Harga (Info)</label>
                                <input type="text" id="info_total" class="form-control text-bold text-success" value="Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Berat Cucian (Kg) <span class="text-danger">*</span></label>
                                <input type="number" name="berat_kg" id="input_berat" class="form-control @error('berat_kg') is-invalid @enderror" step="0.1" min="0.1" value="{{ old('berat_kg', $transaction->berat_kg) }}" required>
                                @error('berat_kg')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Uang Dibayar (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_bayar" class="form-control @error('jumlah_bayar') is-invalid @enderror" min="0" value="{{ old('jumlah_bayar', $transaction->jumlah_bayar) }}" required>
                                @error('jumlah_bayar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status Cucian <span class="text-danger">*</span></label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="Proses" {{ old('status', $transaction->status) == 'Proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="Selesai" {{ old('status', $transaction->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Diambil" {{ old('status', $transaction->status) == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="2">{{ old('catatan', $transaction->catatan) }}</textarea>
                        @error('catatan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update Transaksi
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@stop

@section('js')
<script>
    let hargaPerKg = {{ $transaction->serpice->harga_per_kg }};

    // Event ketika layanan diganti
    document.getElementById('select_serpice').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var harga = selectedOption.getAttribute('data-harga');
        
        hargaPerKg = parseFloat(harga) || 0;
        
        var formatRupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(harga);
        document.getElementById('info_harga').value = formatRupiah;
        
        hitungTotal();
    });

    // Event ketika berat berubah
    document.getElementById('input_berat').addEventListener('input', function() {
        hitungTotal();
    });

    function hitungTotal() {
        var berat = parseFloat(document.getElementById('input_berat').value) || 0;
        var total = berat * hargaPerKg;
        
        var formatTotal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
        document.getElementById('info_total').value = formatTotal;
    }
</script>
@stop