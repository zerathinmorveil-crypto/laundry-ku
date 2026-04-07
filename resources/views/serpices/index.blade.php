@extends('adminlte::page')
@section('title', 'Data Layanan')
@section('content_header')
    <h1>Data Layanan</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Layanan Laundry</h3>
            <div class="card-tools">
                <a href="{{ route('serpices.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Layanan
                </a>
            </div>
        </div>
        
        <div class="card-body pb-0">
            <form action="{{ route('serpices.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Layanan" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th>Nama Layanan</th>
                        <th>Harga per Kg</th>
                        <th>Estimasi Waktu</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($serpices as $key => $serpice)
                    <tr>
                        <td>{{ $serpices->firstItem() + $key }}</td>
                        <td>{{ $serpice->nama_layanan }}</td>
                        <td>Rp {{ number_format($serpice->harga_per_kg, 0, ',', '.') }}</td>
                        <td>{{ $serpice->estimasi_waktu }} jam</td>
                        <td>{{ $serpice->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('serpices.edit', $serpice->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('serpices.destroy', $serpice->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {!! $serpices->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@stop