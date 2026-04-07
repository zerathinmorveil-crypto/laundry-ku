@extends('adminlte::page')
@section('title', 'Edit Layanan')
@section('content_header')
    <h1>Edit Layanan</h1>
@stop
@section('content')
    <div class="card">
        <form action="{{ route('serpices.update', $serpice->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="form-group">
                    <label for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" id="nama_layanan" name="nama_layanan" placeholder="Contoh: Cuci Kering, Cuci Setrika, dll" value="{{ old('nama_layanan', $serpice->nama_layanan) }}" required>
                    @error('nama_layanan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="harga_per_kg">Harga per Kg <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control @error('harga_per_kg') is-invalid @enderror" id="harga_per_kg" name="harga_per_kg" placeholder="Contoh: 5000" value="{{ old('harga_per_kg', $serpice->harga_per_kg) }}" min="0" step="100" required>
                        @error('harga_per_kg')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="estimasi_waktu">Estimasi Waktu (Jam) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('estimasi_waktu') is-invalid @enderror" id="estimasi_waktu" name="estimasi_waktu" placeholder="Contoh: 24" value="{{ old('estimasi_waktu', $serpice->estimasi_waktu) }}" min="1" required>
                    @error('estimasi_waktu')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="form-text text-muted">Dalam satuan jam</small>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan tambahan tentang layanan">{{ old('keterangan', $serpice->keterangan) }}</textarea>
                    @error('keterangan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('serpices.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@stop