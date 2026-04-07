<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Member</title>
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
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
            font-size: 9px;
        }
        .badge-secondary { background-color: #6c757d; }
        .badge-info { background-color: #17a2b8; }
        .badge-warning { background-color: #ffc107; color: #333; }
        .badge-dark { background-color: #343a40; }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9px;
        }
        .summary {
            margin-top: 15px;
            border: 2px solid #333;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .summary-item {
            display: inline-block;
            margin-right: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN DATA MEMBER</h2>
        @if(isset($jenis_member))
            <p style="font-size: 14px; color: #000;">Jenis Member: <strong>{{ $jenis_member }}</strong></p>
        @endif
        <p>LAUNDRY.KU - Sistem Manajemen Laundry</p>
        <p>Jl. Perdagangan No. 123, perdagangan | Telp: (021) 12345678</p>
    </div>

    <div class="info">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 150px;"><strong>Tanggal Cetak</strong></td>
                <td style="border: none;">: {{ date('d F Y, H:i') }} WIB</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Total Member</strong></td>
                <td style="border: none;">: {{ $members->count() }} Member</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Member Aktif</strong></td>
                <td style="border: none;">: {{ $members->where('status', 1)->count() }} Member</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%">No</th>
                <th style="width: 17%">Nama Member</th>
                <th style="width: 12%">No. Telepon</th>
                <th style="width: 10%">Jenis Member</th>
                <th style="width: 7%">Poin</th>
                <th style="width: 10%">Tgl Bergabung</th>
                <th style="width: 10%">Tgl Expired</th>
                <th style="width: 7%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $member)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $member->customer->nama_pelanggan ?? '-' }}</td>
                <td>{{ $member->customer->nomor_telepon ?? '-' }}</td>
                <td style="text-align: center;">
                    @if($member->jenis_member == 'silver')
                        <span class="badge badge-info">Silver</span>
                    @elseif($member->jenis_member == 'gold')
                        <span class="badge badge-warning">Gold</span>
                    @else
                        <span class="badge badge-dark">Platinum</span>
                    @endif
                </td>
                <td style="text-align: center;">{{ number_format($member->poin ?? 0, 0, ',', '.') }}</td>
                <td style="text-align: center; font-size: 9px;">
                    {{ $member->tanggal_bergabung ? $member->tanggal_bergabung->format('d/m/Y') : '-' }}
                </td>
                <td style="text-align: center; font-size: 9px;">
                    {{ $member->tanggal_expired ? \Carbon\Carbon::parse($member->tanggal_expired)->format('d/m/Y') : '-' }}
                </td>
                <td style="text-align: center;">
                    @if($member->status == 'aktif')
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Nonaktif</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center;">Tidak ada data member</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <strong>RINGKASAN:</strong><br>
        <div class="summary-item">
            <strong>Total Poin:</strong> {{ number_format($members->sum('poin'), 0, ',', '.') }}
        </div>
        <div class="summary-item">
            <strong>Silver:</strong> {{ $members->where('jenis_member', 'silver')->count() }}
        </div>
        <div class="summary-item">
            <strong>Gold:</strong> {{ $members->where('jenis_member', 'gold')->count() }}
        </div>
        <div class="summary-item">
            <strong>Platinum:</strong> {{ $members->where('jenis_member', 'platinum')->count() }}
        </div>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y, H:i:s') }} WIB</p>
        <p>© {{ date('Y') }} LAUNDRY.KU - All Rights Reserved</p>
    </div>

</body>
</html>