@extends('adminlte::page')
@section('title', 'Data Member')
@section('content_header')
    <h1>Data Member</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Member Laundry</h3>
            <div class="card-tools">
                <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-file-pdf"></i> Cetak PDF
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('members.cetak-pdf') }}" target="_blank">
                            <i class="fas fa-users"></i> Semua Member
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('members.cetak-pdf-by-jenis', 'silver') }}" target="_blank">
                            <i class="fas fa-medal"></i> Silver
                        </a>
                        <a class="dropdown-item" href="{{ route('members.cetak-pdf-by-jenis', 'gold') }}" target="_blank">
                            <i class="fas fa-trophy"></i> Gold
                        </a>
                        <a class="dropdown-item" href="{{ route('members.cetak-pdf-by-jenis', 'platinum') }}" target="_blank">
                            <i class="fas fa-crown"></i> Platinum
                        </a>
                    </div>
                </div>
                <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Member
                </a>
            </div>
        </div>
        
        <div class="card-body pb-0">
            <form action="{{ route('members.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Customer" value="{{ request('search') }}">
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
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
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
                        <th>Nama Customer</th>
                        <th>No Telepon</th>
                        <th>Tipe Member</th>
                        <th>Tanggal Bergabung</th>
                        <th>Tanggal Expired</th>
                        <th>Poin</th>
                        <th>Status</th>
                        <th style="width: 120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $key => $member)
                    <tr>
                        <td>{{ $members->firstItem() + $key }}</td>
                        <td>{{ $member->customer->nama_pelanggan }}</td>
                        <td>{{ $member->customer->nomor_telepon }}</td>
                        <td>
                            @if($member->jenis_member == 'silver')
                                <span class="badge badge-secondary">Silver</span>
                            @elseif($member->jenis_member == 'gold')
                                <span class="badge badge-warning">Gold</span>
                            @else
                                <span class="badge badge-info">Platinum</span>
                            @endif
                        </td>
                        <td>{{ $member->tanggal_bergabung->format('d/m/Y') }}</td>
                        <td>{{ $member->tanggal_expired ? $member->tanggal_expired->format('d/m/Y') : '-' }}</td>
                        <td>{{ number_format($member->poin, 0, ',', '.') }}</td>
                        <td>
                            @if($member->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus member ini?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {!! $members->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@stop