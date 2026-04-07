<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
        }
        .header p {
            margin: 3px 0;
            color: #666;
        }
        .info {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
        .total {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN DATA CUSTOMER</h2>
        <p>LAUNDRY.KU - Sistem Manajemen Laundry</p>
        <p>Jl. Contoh No. 123, Kota Anda | Telp: (021) 12345678</p>
    </div>

    <div class="info">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 150px;"><strong>Tanggal Cetak</strong></td>
                <td style="border: none;">: {{ date('d F Y, H:i') }} WIB</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Customer</strong></td>
                <td style="border: none;">: {{ $customers->count() }} Customer</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 20%">Nama Customer</th>
                <th style="width: 15%">No. Telepon</th>
                <th style="width: 30%">Alamat</th>
                <th style="width: 15%">Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $index => $customer)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $customer->nama_pelanggan }}</td>
                <td>{{ $customer->nomor_telepon }}</td>
                <td>{{ $customer->alamat }}</td>
                <td style="text-align: center;">
                    {{ $customer->tanggal ? \Carbon\Carbon::parse($customer->tanggal)->format('d/m/Y') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data customer</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y, H:i:s') }} WIB</p>
        <p>© {{ date('Y') }} LAUNDRY.KU - All Rights Reserved</p>
    </div>

</body>
</html>