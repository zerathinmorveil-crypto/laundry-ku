<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
        }
        .header p {
            margin: 3px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-size: 9px;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
            font-size: 8px;
        }
        .badge-pending { background-color: #6c757d; }
        .badge-proses { background-color: #ffc107; color: #333; }
        .badge-selesai { background-color: #17a2b8; }
        .badge-diambil { background-color: #28a745; }
        .badge-lunas { background-color: #28a745; }
        .badge-dp { background-color: #ffc107; color: #333; }
        .badge-belum { background-color: #dc3545; }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .summary {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 2px solid #333;
        }
        .summary table {
            border: none;
        }
        .summary td {
            border: none;
            padding: 3px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Data Transaksi Laundry</h2>
        <p>LAUNDRY.KU - Sistem Manajemen Laundry</p>
        <p>Tanggal Cetak: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%">No</th>
                <th style="width: 15%">Nomor Nota</th>
                <th style="width: 10%">Tanggal Masuk</th>
                <th style="width: 15%">Nama Pelanggan</th>
                <th style="width: 15%">Layanan</th>
                <th style="width: 10%">Total Harga</th>
                <th style="width: 10%">Dibayar</th>
                <th style="width: 9%">Status Bayar</th>
                <th style="width: 9%">Status Cucian</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalHarga = 0;
            @endphp
            
            @foreach($transactions as $index => $trx)
                @php
                    $totalHarga += $trx->total_harga;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-size: 9px;">
                        {{ $trx->nomor_nota }}
                        @if($trx->id_member)
                            <br><span class="badge" style="background-color: #17a2b8;">Member</span>
                        @endif
                    </td>
                    <td style="text-align: center; font-size: 9px;">
                        {{ $trx->tanggal_masuk->format('d/m/Y') }}
                    </td>
                    <td style="font-size: 9px;">
                        {{ $trx->customer->nama_pelanggan }}
                    </td>
                    <td style="font-size: 9px;">
                        {{ $trx->serpice->nama_layanan }}
                    <td style="text-align: right;">
                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </td>
                    <td style="text-align: right;">
                        Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}
                    </td>
                    <td style="text-align: center;">
                        @if($trx->status_bayar == 'Lunas')
                            <span class="badge badge-lunas">Lunas</span>
                        @elseif($trx->status_bayar == 'DP')
                            <span class="badge badge-dp">DP</span>
                        @else
                            <span class="badge badge-belum">Belum</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($trx->status == 'Pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($trx->status == 'Proses')
                            <span class="badge badge-proses">Proses</span>
                        @elseif($trx->status == 'Selesai')
                            <span class="badge badge-selesai">Selesai</span>
                        @else
                            <span class="badge badge-diambil">Diambil</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <strong>RINGKASAN:</strong>
        <table>
            <tr>
                <td style="width: 200px;"><strong>Total Transaksi:</strong></td>
                <td style="text-align: right;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
            </tr>s
            <tr style="border-top: 2px solid #333;">
                <td><strong>TOTAL PENDAPATAN:</strong></td>
                <td style="text-align: right;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Jumlah Transaksi:</strong></td>
                <td style="text-align: right;">{{ $transactions->count() }} Transaksi</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y, H:i:s') }} WIB</p>
    </div>

</body>
</html>