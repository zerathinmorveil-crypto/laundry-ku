<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $transaction->kode_invoice }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .company-info {
            float: left;
            width: 60%;
        }
        .invoice-info {
            float: right;
            width: 35%;
            text-align: right;
        }
        .clearfix {
            clear: both;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .customer-info {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: left;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .total-section {
            float: right;
            width: 300px;
            margin-top: 20px;
        }
        .total-row {
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }
        .total-row.grand-total {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 10px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="company-info">
            <h2 style="margin: 0;">LAUNDRY.KU</h2>
            <p style="margin: 5px 0;">Jl. Contoh No. 123, Kota Anda</p>
            <p style="margin: 5px 0;">Telp: (021) 12345678</p>
            <p style="margin: 5px 0;">Email: info@laundry.ku</p>
        </div>
        <div class="invoice-info">
            <div class="invoice-title">INVOICE</div>
            <p style="margin: 10px 0;"><strong>{{ $transaction->kode_invoice }}</strong></p>
            <p style="margin: 5px 0;">Tanggal: {{ $transaction->tanggal_masuk->format('d F Y') }}</p>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="customer-info">
        <strong>INFORMASI PELANGGAN:</strong><br>
        <table style="border: none; margin: 10px 0;">
            <tr style="border: none;">
                <td style="border: none; width: 120px; padding: 3px 0;">Nama</td>
                <td style="border: none; padding: 3px 0;">: <strong>{{ $transaction->nama_pelanggan }}</strong>
                    @if($transaction->id_member)
                        <span style="background-color: #17a2b8; color: white; padding: 2px 8px; border-radius: 3px; font-size: 10px;">MEMBER</span>
                    @endif
                </td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 3px 0;">No. Telepon</td>
                <td style="border: none; padding: 3px 0;">: {{ $transaction->no_telepon }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 3px 0;">Tanggal Selesai</td>
                <td style="border: none; padding: 3px 0;">: {{ $transaction->tanggal_selesai ? $transaction->tanggal_selesai->format('d F Y') : 'Belum ditentukan' }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Layanan</th>
                <th style="text-align: center;">Berat (kg)</th>
                <th style="text-align: right;">Harga/kg</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->nama_layanan }}</td>
                <td style="text-align: center;">{{ $detail->qty }}</td>
                <td style="text-align: right;">Rp {{ number_format($detail->harga_per_kg, 0, ',', '.') }}</td>
                <td style="text-align: right;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="clearfix"></div>

    <div class="total-section">
        <div class="total-row">
            <span style="float: left;">Subtotal:</span>
            <span style="float: right;">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
            <div class="clearfix"></div>
        </div>
        
        @if($transaction->diskon > 0)
        <div class="total-row">
            <span style="float: left;">Diskon:</span>
            <span style="float: right; color: green;">- Rp {{ number_format($transaction->diskon, 0, ',', '.') }}</span>
            <div class="clearfix"></div>
        </div>
        @endif

        <div class="total-row grand-total">
            <span style="float: left;">TOTAL BAYAR:</span>
            <span style="float: right;">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</span>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div style="margin-top: 30px; padding: 15px; background-color: #e7f3ff; border: 1px solid #2196F3;">
        <strong>INFORMASI PEMBAYARAN:</strong><br>
        <table style="border: none; margin: 10px 0;">
            <tr style="border: none;">
                <td style="border: none; width: 150px; padding: 3px 0;">Status Pembayaran</td>
                <td style="border: none; padding: 3px 0;">: 
                    <strong>{{ $transaction->status_pembayaran }}</strong>
                </td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 3px 0;">Metode Pembayaran</td>
                <td style="border: none; padding: 3px 0;">: {{ $transaction->metode_pembayaran }}</td>
            </tr>
            @if($transaction->status_pembayaran != 'Lunas')
            <tr style="border: none;">
                <td style="border: none; padding: 3px 0;"><strong>Sisa Pembayaran</strong></td>
                <td style="border: none; padding: 3px 0;">: <strong style="color: red;">Rp {{ number_format($transaction->sisa_pembayaran, 0, ',', '.') }}</strong></td>
            </tr>
            @endif
        </table>
    </div>

    @if($transaction->catatan)
    <div style="margin-top: 20px; padding: 10px; background-color: #fff3cd; border: 1px solid #ffc107;">
        <strong>Catatan:</strong><br>
        {{ $transaction->catatan }}
    </div>
    @endif

    <div class="footer">
        <p><strong>Terima kasih atas kepercayaan Anda menggunakan layanan kami!</strong></p>
        <p>Invoice ini dicetak pada: {{ date('d F Y, H:i:s') }} WIB</p>
    </div>

</body>
</html>