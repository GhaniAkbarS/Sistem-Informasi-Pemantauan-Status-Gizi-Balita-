<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Balita - {{ session('posyandu_nama') }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; padding: 30px; }
        .header { text-align:center; border-bottom: 3px double #333; padding-bottom:12px; margin-bottom:16px; }
        .header h1 { font-size:15px; text-transform:uppercase; }
        .header h2 { font-size:13px; margin-top:2px; }
        .info-row { display:flex; justify-content:space-between; margin-bottom:16px; }
        table { width:100%; border-collapse:collapse; }
        thead tr { background:#2c5f8a; color:#fff; }
        th, td { border:1px solid #ccc; padding:6px 8px; }
        th { font-size:10px; text-transform:uppercase; }
        tbody tr:nth-child(even) { background:#f5f8fc; }
        .no-print { margin-bottom:16px; }
        @media print { .no-print { display:none; } body { padding:15px; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="padding:8px 20px;background:#2c5f8a;color:#fff;border:none;border-radius:4px;cursor:pointer;">🖨️ Cetak / Simpan PDF</button>
        <button onclick="window.close()" style="padding:8px 20px;background:#888;color:#fff;border:none;border-radius:4px;cursor:pointer;margin-left:8px;">✖ Tutup</button>
    </div>
    <div class="header">
        <h1>Laporan Data Balita</h1>
        <h2>{{ session('posyandu_nama') }}</h2>
    </div>
    <div class="info-row">
        <span><strong>Kader:</strong> {{ ucfirst(auth()->user()->name) }}</span>
        <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>No.</th><th>Nama Anak</th><th>JK</th><th>Tgl Lahir</th>
                <th>Umur (Bln)</th><th>Nama Orang Tua</th><th>BB (kg)</th><th>TB (cm)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($balitas as $i => $b)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $b->nama }}</td>
                <td>{{ $b->jk }}</td>
                <td>{{ \Carbon\Carbon::parse($b->tgl_lahir)->format('d/m/Y') }}</td>
                <td>{{ $b->umur }}</td>
                <td>{{ $b->nama_ortu }}</td>
                <td>{{ $b->berat_badan }}</td>
                <td>{{ $b->tinggi_badan }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;padding:20px;color:#888;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
    <p style="margin-top:10px;font-size:10px;color:#999;">Total: {{ $balitas->count() }} anak</p>
</body>
</html>
