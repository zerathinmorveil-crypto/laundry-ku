@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>
                        <p>Pesanan Baru</p>
                    </div>
                    <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                    <a href="{{ route('transactions.index') }}" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rp 4.500.000</h3>
                        <p>Pendapatan Bulan Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                    <a href="#" class="small-box-footer">Detail Laporan <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>45</h3>
                        <p>Sedang Diproses</p>
                    </div>
                    <div class="icon"><i class="fas fa-sync-alt"></i></div>
                    <a href="#" class="small-box-footer">Lihat Antrean <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>12</h3>
                        <p>Belum Diambil</p>
                    </div>
                    <div class="icon"><i class="fas fa-tshirt"></i></div>
                    <a href="#" class="small-box-footer">Hubungi Pelanggan <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-history mr-1"></i> Tren Pendapatan 7 Hari Terakhir</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-tags mr-1"></i> Analisis Harga Transaksi</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kuantil / Metrik</th>
                                    <th>Nilai (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Harga Terendah</td>
                                    <td><span class="badge badge-secondary">15.000</span></td>
                                </tr>
                                <tr>
                                    <td>Rata-rata (Mean)</td>
                                    <td><span class="badge badge-info">35.000</span></td>
                                </tr>
                                <tr>
                                    <td>Harga Tertinggi</td>
                                    <td><span class="badge badge-success">120.000</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-muted text-sm">
                        Data diambil dari 1.000 transaksi terakhir.
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Transaksi Terbaru</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Layanan</th>
                                    <th>Status</th>
                                    <th>Total Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#LND-001</td>
                                    <td>Budi Santoso</td>
                                    <td>Cuci Kering + Setrika</td>
                                    <td><span class="badge badge-warning">Proses</span></td>
                                    <td>Rp 25.000</td>
                                    <td><a href="#" class="btn btn-xs btn-default">Detail</a></td>
                                </tr>
                                <tr>
                                    <td>#LND-002</td>
                                    <td>Siti Aminah</td>
                                    <td>Bed Cover</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                    <td>Rp 45.000</td>
                                    <td><a href="#" class="btn btn-xs btn-default">Detail</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function () {
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Pendapatan (Ribu Rp)',
                        data: [400, 600, 550, 800, 700, 1200, 950],
                        borderColor: 'rgba(60,141,188,0.8)',
                        backgroundColor: 'rgba(60,141,188,0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                }
            });
        });
    </script>
@stop