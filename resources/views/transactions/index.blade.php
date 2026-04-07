@extends('adminlte::page')
@section('title', 'Data Transaksi')
@section('content_header')
    <h1>Riwayat Transaksi Laundry</h1>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Transaksi Laundry</h3>
                <div class="card-tools">
                    <a href="{{ route('transactions.cetak-pdf') }}" class="btn btn-danger btn-sm" target="_blank">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan
                    </a>
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Transaksi Baru
                    </a>
                </div>
            </div>
            
            <div class="card-body pb-0">
                <form action="{{ route('transactions.index') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nomor Nota / Nama Customer" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Nota</th>
                            <th>Customer</th>
                            <th>Layanan</th>
                            <th>Berat (Kg)</th>
                            <th>Total</th>
                            <th>Dibayar</th>
                            <th>Status Cucian</th>
                            <th>Status Bayar</th>
                            <th>Tanggal Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $key => $trx)
                        <tr>
                            <td>{{ $transactions->firstItem() + $key }}</td>
                            <td><strong>{{ $trx->nomor_nota }}</strong></td>
                            <td>{{ $trx->customer->nama_pelanggan }}</td>
                            <td>{{ $trx->serpice->nama_layanan }}</td>
                            <td>{{ number_format($trx->berat_kg, 1) }} Kg</td>
                            <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>
                                @if($trx->status == 'Proses')
                                    <span class="badge badge-warning">Proses</span>
                                @elseif($trx->status == 'Selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-info">Diambil</span>
                                @endif
                            </td>
                            <td>
                                @if($trx->status_bayar == 'Lunas')
                                    <span class="badge badge-success">Lunas</span>
                                @elseif($trx->status_bayar == 'DP')
                                    <span class="badge badge-warning">DP</span>
                                @else
                                    <span class="badge badge-danger">Belum Lunas</span>
                                @endif
                            </td>
                            <td>{{ $trx->tanggal_masuk->format('d/m/Y') }}</td>
                            
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('transactions.show', $trx->id) }}" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('transactions.edit', $trx->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="{{ route('transactions.struk', $trx->id) }}" class="btn btn-secondary btn-sm" title="Cetak Struk"> 
                                    <i class="fas fa-print"></i>
                                </a>

                                <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">Belum ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {!! $transactions->links('pagination::bootstrap-4') !!}
            </div>
        </div>
    </div>
</section>
@stop