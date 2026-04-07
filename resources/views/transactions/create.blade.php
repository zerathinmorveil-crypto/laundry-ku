@extends('adminlte::page')
@section('title', 'Transaksi Baru')
@section('content_header')
    <h1>Transaksi Laundry Baru</h1>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Transaksi Laundry</h3>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Nota</label>
                                <input type="text" class="form-control" value="{{ $nomorNota }}" readonly>
                                <small class="text-muted">Otomatis ter-generate</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                                @error('tanggal_masuk')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Pilih Customer <span class="text-danger">*</span></label>
                        <select name="customer_id" id="select_customer" class="form-control @error('customer_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->nama_pelanggan }} - {{ $customer->nomor_telepon }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Pilih Layanan <span class="text-danger">*</span></label>
                        <select name="serpice_id" id="select_serpice" class="form-control @error('serpice_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis Layanan --</option>
                            @foreach($serpices as $serpice)
                                <option value="{{ $serpice->id }}" 
                                        data-harga="{{ $serpice->harga_per_kg }}"
                                        data-estimasi="{{ $serpice->estimasi_waktu }}"
                                        {{ old('serpice_id') == $serpice->id ? 'selected' : '' }}>
                                    {{ $serpice->nama_layanan }} - Rp {{ number_format($serpice->harga_per_kg, 0, ',', '.') }}/Kg
                                </option>
                            @endforeach
                        </select>
                        @error('serpice_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Harga per Kg (Info)</label>
                                <input type="text" id="info_harga" class="form-control text-bold text-primary" readonly placeholder="Rp 0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Estimasi Waktu (Info)</label>
                                <input type="text" id="info_estimasi" class="form-control" readonly placeholder="0 jam">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-success">Total Harga (Info)</label>
                                <input type="text" id="info_total" class="form-control text-bold text-success" readonly placeholder="Rp 0">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Berat Cucian (Kg) <span class="text-danger">*</span></label>
                                <input type="number" name="berat_kg" id="input_berat" class="form-control @error('berat_kg') is-invalid @enderror" step="0.1" min="0.1" value="{{ old('berat_kg') }}" required>
                                @error('berat_kg')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Minimal 0.1 Kg</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Uang Yang Dibayar (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_bayar" id="input_bayar" class="form-control @error('jumlah_bayar') is-invalid @enderror" min="0" value="{{ old('jumlah_bayar', 0) }}" required>
                                @error('jumlah_bayar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">0 = Belum Lunas, Sebagian = DP, Full = Lunas</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="2">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Contoh: Pisahkan warna putih, Jangan pakai pewangi, dll</small>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Transaksi
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
    let hargaPerKg = 0;

    // Event ketika layanan dipilih
    document.getElementById('select_serpice').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        
        var harga = selectedOption.getAttribute('data-harga');
        var estimasi = selectedOption.getAttribute('data-estimasi');
        
        hargaPerKg = parseFloat(harga) || 0;
        
        // Format Rupiah
        var formatRupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(harga);
        document.getElementById('info_harga').value = formatRupiah;
        
        // Estimasi waktu
        document.getElementById('info_estimasi').value = estimasi + ' jam';
        
        // Hitung total jika berat sudah diisi
        hitungTotal();
    });

    // Event ketika berat diinput
    document.getElementById('input_berat').addEventListener('input', function() {
        hitungTotal();
    });

    function hitungTotal() {
        var berat = parseFloat(document.getElementById('input_berat').value) || 0;
        var total = berat * hargaPerKg;
        
        // Format Rupiah
        var formatTotal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
        document.getElementById('info_total').value = formatTotal;
        
        // Auto fill jumlah bayar
        document.getElementById('input_bayar').value = total;
    }
</script>
@stop