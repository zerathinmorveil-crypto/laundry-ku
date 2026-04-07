@extends('adminlte::page')
@section('title', 'Data Customer')
@section('content_header')
    <h1>Data Customer</h1>
@stop
@section('content')
    <div class="card">

        {{-- Header --}}
        <div class="card-header">
            <h3 class="card-title">Daftar Customer</h3>
            <div class="card-tools">
                <a href="{{ route('customers.cetak-pdf') }}" class="btn btn-danger btn-sm" target="_blank">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a>
                <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Customer
                </a>
            </div>
        </div>

        {{-- Search & Alert --}}
        <div class="card-body pb-0">
            <form action="{{ route('customer.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama atau No. HP" value="{{ request('search') }}">
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
        {{-- Table --}}
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Tanggal</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $key => $customer)
                        <tr>
                            <td>{{ $customers->firstItem() + $key }}</td>
                            <td>{{ $customer->nama_pelanggan }}</td>
                            <td>{{ $customer->nomor_telepon }}</td>
                            <td>{{ $customer->tanggal }}</td>
                            <td>{{ $customer->alamat }}</td>
                            <td>
                                {{-- Detail --}}
                                <a href="{{ route('customer.show', $customer->id) }}" class="btn btn-info btn-sm" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- Hapus --}}
                                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Data tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="card-footer clearfix">
            {!! $customers->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@stop
