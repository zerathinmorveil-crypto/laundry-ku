@extends('adminlte::page')
@section('title', 'Tambah Member')
@section('content_header')
    <h1>Tambah Member</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Member Baru</h3>
        </div>
        
        <form action="{{ route('members.store') }}" method="POST">
            @csrf
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    <!-- Customer Selection -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_id">Nama Customer <span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
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
                            <small class="form-text text-muted">Customer yang sudah menjadi member tidak muncul di list</small>
                        </div>
                    </div>

                    <!-- jenis Member -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_member">Jenis Member <span class="text-danger">*</span></label>
                            <select name="jenis_member" id="jenis_member" class="form-control @error('jenis_member') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="silver" {{ old('jenis_member') == 'silver' ? 'selected' : '' }}>Silver</option>
                                <option value="gold" {{ old('jenis_member') == 'gold' ? 'selected' : '' }}>Gold</option>
                                <option value="platinum" {{ old('jenis_member') == 'platinum' ? 'selected' : '' }}>Platinum</option>
                            </select>
                            @error('jenis_member')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Bergabung -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_bergabung">Tanggal Bergabung <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" class="form-control @error('tanggal_bergabung') is-invalid @enderror" value="{{ old('tanggal_bergabung', date('Y-m-d')) }}" required>
                            @error('tanggal_bergabung')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Expired -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_expired">Tanggal Expired</label>
                            <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control @error('tanggal_expired') is-invalid @enderror" value="{{ old('tanggal_expired') }}">
                            @error('tanggal_expired')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Kosongkan jika tidak ada masa expired</small>
                        </div>
                    </div>

                    <!-- Poin -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="poin">Poin Awal</label>
                            <input type="number" name="poin" id="poin" class="form-control @error('poin') is-invalid @enderror" value="{{ old('poin', 0) }}" min="0">
                            @error('poin')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_member">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status_member" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="aktif" {{ old('status_member', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status_member', 'nonaktif') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status_member')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('members.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@stop

@section('js')
<script>
    // Auto set expired date (1 year from bergabung)
    $('#tanggal_bergabung').on('change', function() {
        if(this.value) {
            const bergabung = new Date(this.value);
            bergabung.setFullYear(bergabung.getFullYear() + 1);
            $('#tanggal_expired').val(bergabung.toISOString().split('T')[0]);
        }
    });
</script>
@stop