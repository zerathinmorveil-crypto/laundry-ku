@extends('adminlte::page')

@section('title', 'Detail Transaksi')

@section('content_header')
    <h1>Detail Transaksi</h1>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        
        <!-- INFO UTAMA -->
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-receipt"></i> Informasi Transaksi</h3>
                        <div class="card-tools">
                            <span class="badge badge-light">{{ $transaction->nomor_nota }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="200"><strong>Nomor Nota:</strong></td>
                                <td><span class="badge badge-primary badge-lg">{{ $transaction->nomor_nota }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Masuk:</strong></td>
                                <td>{{ $transaction->tanggal_masuk->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Selesai:</strong></td>
                                <td>{{ $transaction->tanggal_selesai->format('d F Y') }}</td>
                            </tr>
                            @if($transaction->tanggal_ambil)
                            <tr>
                                <td><strong>Tanggal Diambil:</strong></td>
                                <td>{{ $transaction->tanggal_ambil->format('d F Y') }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Status Cucian:</strong></td>
                                <td>
                                    @if($transaction->status == 'Proses')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-sync-alt"></i> Proses
                                        </span>
                                    @elseif($transaction->status == 'Selesai')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Selesai
                                        </span>
                                    @else
                                        <span class="badge badge-info">
                                            <i class="fas fa-box-open"></i> Diambil
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status Pembayaran:</strong></td>
                                <td>
                                    @if($transaction->status_bayar == 'Lunas')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-double"></i> Lunas
                                        </span>
                                    @elseif($transaction->status_bayar == 'DP')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-exclamation-circle"></i> DP
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle"></i> Belum Lunas
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- DETAIL LAYANAN -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-tshirt"></i> Detail Layanan</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Jenis Layanan</th>
                                    <th width="150">Berat (Kg)</th>
                                    <th width="150">Harga/Kg</th>
                                    <th width="200">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>{{ $transaction->serpice->nama_layanan }}</strong><br>
                                        <small class="text-muted">{{ $transaction->serpice->keterangan }}</small>
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ number_format($transaction->berat_kg, 1) }} Kg</strong>
                                    </td>
                                    <td class="text-right">
                                        Rp {{ number_format($transaction->serpice->harga_per_kg, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        <strong>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td colspan="3" class="text-right"><strong>TOTAL:</strong></td>
                                    <td class="text-right">
                                        <strong class="text-success" style="font-size: 1.1em;">
                                            Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- CATATAN -->
                @if($transaction->catatan)
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-sticky-note"></i> Catatan</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $transaction->catatan }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- SIDEBAR INFO -->
            <div class="col-md-4">
                <!-- INFO CUSTOMER -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user"></i> Data Customer</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-user-circle fa-4x text-muted"></i>
                        </div>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="100"><strong>Nama:</strong></td>
                                <td>{{ $transaction->customer->nama_pelanggan }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon:</strong></td>
                                <td>
                                    <a href="https://wa.me/{{ $transaction->customer->nomor_telepon }}" target="_blank" class="text-success">
                                        <i class="fab fa-whatsapp"></i> {{ $transaction->customer->nomor_telepon }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Alamat:</strong></td>
                                <td>{{ $transaction->customer->alamat ?? '-' }}</td>
                            </tr>
                            @if($transaction->customer->member)
                            <tr>
                                <td colspan="2" class="pt-3">
                                    <div class="alert alert-success mb-0">
                                        <i class="fas fa-star"></i> <strong>Member {{ $transaction->customer->member->tipe_member }}</strong><br>
                                        <small>Poin: {{ $transaction->customer->member->poin }}</small>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- INFO PEMBAYARAN -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-money-bill-wave"></i> Pembayaran</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td>Total Tagihan:</td>
                                <td class="text-right">
                                    <strong>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Sudah Dibayar:</td>
                                <td class="text-right">
                                    <strong class="text-success">Rp {{ number_format($transaction->jumlah_bayar, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                            <tr class="table-active">
                                <td><strong>Sisa Bayar:</strong></td>
                                <td class="text-right">
                                    @php
                                        $sisa = $transaction->total_harga - $transaction->jumlah_bayar;
                                    @endphp
                                    <strong class="{{ $sisa > 0 ? 'text-danger' : 'text-success' }}">
                                        Rp {{ number_format($sisa, 0, ',', '.') }}
                                    </strong>
                                </td>
                            </tr>
                        </table>

                        @if($sisa > 0)
                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Belum Lunas!</strong><br>
                            Masih kurang: <strong>Rp {{ number_format($sisa, 0, ',', '.') }}</strong>
                        </div>
                        @else
                        <div class="alert alert-success mt-3 mb-0">
                            <i class="fas fa-check-circle"></i>
                            <strong>Pembayaran Lunas</strong>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- AKSI CEPAT -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-cogs"></i> Aksi</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('transactions.struk', $transaction->id) }}" class="btn btn-secondary btn-block" target="_blank">
                            <i class="fas fa-print"></i> Cetak Struk
                        </a>
                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-block">
                            <i class="fas fa-edit"></i> Edit Transaksi
                        </a>
                        <hr>
                        <a href="{{ route('transactions.index') }}" class="btn btn-default btn-block">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        
                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash"></i> Hapus Transaksi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- TIMELINE / RIWAYAT -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-history"></i> Timeline Transaksi</h3>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <!-- Timeline Item 1: Created -->
                            <div>
                                <i class="fas fa-plus bg-primary"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                                    <h3 class="timeline-header">Transaksi Dibuat</h3>
                                    <div class="timeline-body">
                                        Transaksi dengan nomor nota <strong>{{ $transaction->nomor_nota }}</strong> telah dibuat.
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline Item 2: In Progress -->
                            @if($transaction->status == 'Proses' || $transaction->status == 'Selesai' || $transaction->status == 'Diambil')
                            <div>
                                <i class="fas fa-sync-alt bg-warning"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{ $transaction->tanggal_masuk->format('d/m/Y') }}</span>
                                    <h3 class="timeline-header">Proses Pencucian</h3>
                                    <div class="timeline-body">
                                        Cucian sedang dalam proses. Estimasi selesai: <strong>{{ $transaction->tanggal_selesai->format('d F Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Timeline Item 3: Completed -->
                            @if($transaction->status == 'Selesai' || $transaction->status == 'Diambil')
                            <div>
                                <i class="fas fa-check bg-success"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{ $transaction->tanggal_selesai->format('d/m/Y') }}</span>
                                    <h3 class="timeline-header">Cucian Selesai</h3>
                                    <div class="timeline-body">
                                        Cucian telah selesai dan siap diambil.
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Timeline Item 4: Picked Up -->
                            @if($transaction->status == 'Diambil' && $transaction->tanggal_ambil)
                            <div>
                                <i class="fas fa-box-open bg-info"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{ $transaction->tanggal_ambil->format('d/m/Y H:i') }}</span>
                                    <h3 class="timeline-header">Cucian Diambil</h3>
                                    <div class="timeline-body">
                                        Cucian telah diambil oleh customer.
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- End Timeline -->
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@stop

@section('css')
<style>
    .badge-lg {
        font-size: 1.1em;
        padding: 8px 12px;
    }
    .timeline {
        position: relative;
        margin: 0 0 30px 0;
        padding: 0;
        list-style: none;
    }
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #ddd;
        left: 31px;
        margin: 0;
        border-radius: 2px;
    }
    .timeline > div {
        position: relative;
        margin-right: 10px;
        margin-bottom: 15px;
    }
    .timeline > div > .timeline-item {
        margin-top: 0;
        background: #fff;
        color: #444;
        margin-left: 60px;
        margin-right: 15px;
        padding: 10px;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,.1);
        border-radius: 3px;
    }
    .timeline > div > .fa,
    .timeline > div > .fas,
    .timeline > div > .far,
    .timeline > div > .fab,
    .timeline > div > .fal,
    .timeline > div > .fad,
    .timeline > div > .ion {
        width: 30px;
        height: 30px;
        font-size: 15px;
        line-height: 30px;
        position: absolute;
        color: #fff;
        background: #999;
        border-radius: 50%;
        text-align: center;
        left: 18px;
        top: 0;
    }
    .timeline > div > .timeline-item > .time {
        color: #999;
        float: right;
        padding: 5px;
        font-size: 12px;
    }
    .timeline > div > .timeline-item > .timeline-header {
        margin: 0;
        color: #555;
        border-bottom: 1px solid #f4f4f4;
        padding: 5px;
        font-size: 16px;
        line-height: 1.1;
    }
    .timeline > div > .timeline-item > .timeline-body {
        padding: 10px;
    }
</style>
@stop