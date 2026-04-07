<!DOCTYPE html>
<html>
<head>
    <title>Struk {{ $transaction->kode_invoice }}</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        padding: 20px;
    }

    .card {
        width: 350px;
        margin: auto;
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h2 {
        margin-bottom: 5px;
    }

    .divider {
        border-top: 1px solid #ddd;
        margin: 15px 0;
    }

    .row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .label {
        color: #555;
    }

    .value {
        font-weight: bold;
        text-align: right;
    }

    .highlight {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .total {
        font-size: 16px;
        font-weight: bold;
        color: #000;
    }

    .footer {
        text-align: center;
        font-size: 12px;
        margin-top: 20px;
        color: #777;
    }

    .btn-print {
        margin-top: 20px;
        text-align: center;
    }

    .btn-print button {
        padding: 10px 20px;
        border: none;
        background: #007bff;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
    }

    @media print {
        body {
            background: #fff;
        }

        .btn-print {
            display: none;
        }
    }
    
    .btn-action {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    gap: 10px;
    }
    
    .btn {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
    }
    
    .btn-print {
        background: #0d6efd;
        color: white;
    }
    
    .btn-back {
        background: #20c997;
        color: white;
    }
    
    @media print {
        .btn-action {
            display: none;
        }
    }
    </style>
</head>
<div class="card">

    <div class="header">
        <h2>LAUNDRY.KU</h2>
        <small>Struk Transaksi</small>
    </div>

    <div class="divider"></div>

    <div class="row">
        <div class="label">No. Nota</div>
        <div class="value">{{ $transaction->nomor_nota }}</div>
    </div>

    <div class="row">
        <div class="label">Tanggal</div>
        <div class="value">{{ $transaction->tanggal_masuk->format('d/m/Y') }}</div>
    </div>

    <div class="row">
        <div class="label">Nama</div>
        <div class="value">{{ $transaction->customer->nama_pelanggan }}</div>
    </div>

    <div class="row">
        <div class="label">Layanan</div>
        <div class="value">{{ $transaction->serpice->nama_layanan }}</div>
    </div>

    <div class="row">
        <div class="label">Berat</div>
        <div class="value">{{ $transaction->berat_kg }} Kg</div>
    </div>

    <div class="divider"></div>

    <div class="highlight">
        <div class="row total">
            <div>Total Bayar</div>
            <div>Rp {{ number_format($transaction->total_harga,0,',','.') }}</div>
        </div>
    </div>

    <div class="row">
        <div class="label">Dibayar</div>
        <div class="value">Rp {{ number_format($transaction->jumlah_bayar,0,',','.') }}</div>
    </div>

    <div class="row">
        <div class="label">Status</div>
        <div class="value">{{ $transaction->status_bayar }}</div>
    </div>

    <div class="divider"></div>

    <div class="footer">
        Terima kasih 🙏<br>
        Laundry.Ku
    </div>

    <div class="btn-action">
        <button onclick="window.print()" class="btn btn-print">🖨️ Print</button>
        <button onclick="window.history.back()" class="btn btn-back">⬅️ Kembali</button>
    </div>

</div>
</html>