<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pemeriksaan - {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
            border-bottom: 2px solid #333;
            padding-bottom: 12px;
        }

        .header h2 {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 12px;
            margin-top: 4px;
            color: #555;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        thead tr {
            background-color: #2c5f8a;
            color: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 7px 10px;
            text-align: left;
        }

        th {
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) {
            background-color: #f5f8fc;
        }

        .badge-normal  { color: #155724; font-weight: bold; }
        .badge-stunting { color: #721c24; font-weight: bold; }
        .badge-other   { color: #856404; font-weight: bold; }

        .footer {
            margin-top: 32px;
            display: flex;
            justify-content: flex-end;
        }

        .ttd {
            text-align: center;
            width: 200px;
        }

        .ttd p {
            margin-bottom: 60px;
        }

        .ttd .nama {
            border-top: 1px solid #333;
            padding-top: 4px;
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            padding: 24px;
            color: #888;
        }

        @media print {
            body { padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    {{-- Tombol Cetak (tidak ikut tercetak) --}}
    <div class="no-print" style="margin-bottom: 16px;">
        <button onclick="window.print()" style="padding: 8px 20px; background: #2c5f8a; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 13px;">
            🖨️ Cetak
        </button>
        <button onclick="window.close()" style="padding: 8px 20px; background: #888; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; margin-left: 8px;">
            ✖ Tutup
        </button>
    </div>

    {{-- Kop Laporan --}}
    <div class="header">
        <h2>Laporan Hasil Pemeriksaan Gizi Balita</h2>
        <p>RW 03, Kelurahan Sidomulyo Timur</p>
        <p>Periode: {{ $namaBulan }} {{ $tahun }}</p>
    </div>

    <div class="info-row">
        <span><strong>Kader:</strong> {{ ucfirst(session('user')) }}</span>
        <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</span>
    </div>

    {{-- Tabel Data --}}
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No.</th>
                <th>Nama Anak</th>
                <th>Tgl Periksa</th>
                <th>Umur</th>
                <th>BB (kg)</th>
                <th>TB (cm)</th>
                <th>IMT</th>
                <th>Status Gizi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($periksas as $index => $periksa)
            @php
                $tb_m = $periksa->tinggi_badan / 100;
                $imt  = $tb_m > 0 ? $periksa->berat_badan / ($tb_m * $tb_m) : 0;
                $badgeClass = $periksa->status_gizi == 'Gizi Normal'
                    ? 'badge-normal'
                    : ($periksa->status_gizi == 'Stunting' ? 'badge-stunting' : 'badge-other');
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $periksa->balita->nama ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($periksa->tanggal_periksa)->format('d/m/Y') }}</td>
                <td>{{ $periksa->umur_bulan }} Bln</td>
                <td>{{ $periksa->berat_badan }}</td>
                <td>{{ $periksa->tinggi_badan }}</td>
                <td>{{ number_format($imt, 1) }}</td>
                <td class="{{ $badgeClass }}">{{ $periksa->status_gizi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="no-data">Tidak ada data pemeriksaan untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top: 12px; font-size: 11px; color: #777;">
        Total data: <strong>{{ $periksas->count() }}</strong> anak
    </p>

    {{-- Tanda Tangan --}}
    <div class="footer">
        <div class="ttd">
            <p>Kader Posyandu,</p>
            <div class="nama">{{ ucfirst(session('user')) }}</div>
        </div>
    </div>

</body>
</html>
