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

        /* ── Tombol Aksi ── */
        .no-print {
            margin-bottom: 16px;
            display: flex;
            gap: 8px;
        }

        .btn-print {
            padding: 8px 20px;
            background: #2c5f8a;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-close {
            padding: 8px 20px;
            background: #888;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        /* ── Kop Surat ── */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #333;
            padding-bottom: 12px;
        }

        .header h1 {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            font-size: 13px;
            font-weight: bold;
            margin-top: 2px;
        }

        .header p {
            font-size: 11px;
            margin-top: 4px;
            color: #555;
        }

        /* ── Info Row ── */
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 12px;
        }

        /* ── Ringkasan Statistik ── */
        .summary-box {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }

        .summary-item {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px 12px;
            text-align: center;
        }

        .summary-item .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
        }

        .summary-item .value {
            font-size: 18px;
            font-weight: bold;
            margin-top: 2px;
        }

        .summary-item.normal  { border-color: #28a745; }
        .summary-item.normal .value  { color: #28a745; }

        .summary-item.kurang  { border-color: #ffc107; }
        .summary-item.kurang .value  { color: #e0a800; }

        .summary-item.lebih   { border-color: #fd7e14; }
        .summary-item.lebih .value   { color: #fd7e14; }

        .summary-item.stunting { border-color: #dc3545; }
        .summary-item.stunting .value { color: #dc3545; }

        .summary-item.total   { border-color: #2c5f8a; }
        .summary-item.total .value   { color: #2c5f8a; }

        /* ── Tabel ── */
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
            padding: 6px 8px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) {
            background-color: #f5f8fc;
        }

        .badge-normal   { color: #155724; font-weight: bold; }
        .badge-stunting { color: #721c24; font-weight: bold; }
        .badge-kurang   { color: #856404; font-weight: bold; }
        .badge-lebih    { color: #7d4e00; font-weight: bold; }

        .no-data {
            text-align: center;
            padding: 24px;
            color: #888;
        }

        /* ── Footer / TTD ── */
        .footer {
            margin-top: 32px;
            display: flex;
            justify-content: flex-end;
        }

        .ttd {
            text-align: center;
            width: 220px;
        }

        .ttd .ttd-label {
            margin-bottom: 60px;
        }

        .ttd .ttd-nama {
            border-top: 1px solid #333;
            padding-top: 4px;
            font-weight: bold;
        }

        .ttd .ttd-jabatan {
            font-size: 11px;
            color: #555;
        }

        .catatan {
            margin-top: 12px;
            font-size: 10px;
            color: #999;
            font-style: italic;
        }

        /* ── Print Media ── */
        @media print {
            body { padding: 15px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    {{-- Tombol Aksi (tidak ikut tercetak) --}}
    <div class="no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
        <button class="btn-close" onclick="window.close()">✖ Tutup</button>
    </div>

    {{-- Kop Laporan --}}
    <div class="header">
        <h1>Laporan Hasil Pemeriksaan Gizi Balita</h1>
        <h2>{{ session('posyandu_nama') }}</h2>
        <p>Periode: {{ $namaBulan }} {{ $tahun }}</p>
    </div>

    {{-- Info Kader & Tanggal Cetak --}}
    <div class="info-row">
        <span><strong>Kader:</strong> {{ ucfirst(auth()->user()->name) }}</span>
        <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</span>
    </div>

    {{-- Ringkasan Statistik --}}
    @php
        $totalAnak   = $periksas->count();
        $jmlNormal   = $periksas->where('status_gizi', 'Gizi Baik')->count();
        $jmlKurang   = $periksas->where('status_gizi', 'Gizi Kurang')->count();
        $jmlLebih    = $periksas->where('status_gizi', 'Gizi Lebih')->count();
        $jmlStunting = $periksas->where('status_gizi', 'Stunting')->count();
    @endphp
    <div class="summary-box">
        <div class="summary-item total">
            <div class="label">Total Anak</div>
            <div class="value">{{ $totalAnak }}</div>
        </div>
        <div class="summary-item normal">
            <div class="label">Gizi Baik</div>
            <div class="value">{{ $jmlNormal }}</div>
        </div>
        <div class="summary-item kurang">
            <div class="label">Gizi Kurang</div>
            <div class="value">{{ $jmlKurang }}</div>
        </div>
        <div class="summary-item lebih">
            <div class="label">Gizi Lebih</div>
            <div class="value">{{ $jmlLebih }}</div>
        </div>
        <div class="summary-item stunting">
            <div class="label">Stunting</div>
            <div class="value">{{ $jmlStunting }}</div>
        </div>
    </div>

    {{-- Tabel Data Pemeriksaan --}}
    <table>
        <thead>
            <tr>
                <th style="width:25px;">No.</th>
                <th>Nama Anak</th>
                <th>JK</th>
                <th>Nama Orang Tua</th>
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
                $badgeClass = match($periksa->status_gizi) {
                    'Gizi Baik'   => 'badge-normal',
                    'Stunting'    => 'badge-stunting',
                    'Gizi Kurang' => 'badge-kurang',
                    'Gizi Lebih'  => 'badge-lebih',
                    default       => ''
                };
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $periksa->balita->nama ?? '-' }}</td>
                <td>{{ $periksa->balita->jk ?? '-' }}</td>
                <td>{{ $periksa->nama_ortu ?? $periksa->balita->nama_ortu ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($periksa->tanggal_periksa)->format('d/m/Y') }}</td>
                <td>{{ $periksa->umur_bulan }} Bln</td>
                <td>{{ $periksa->berat_badan }}</td>
                <td>{{ $periksa->tinggi_badan }}</td>
                <td>{{ number_format($imt, 1) }}</td>
                <td class="{{ $badgeClass }}">{{ $periksa->status_gizi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="no-data">Tidak ada data pemeriksaan untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p class="catatan">* Data diambil dari sistem informasi pemantauan gizi balita posyandu.</p>

    {{-- Tanda Tangan --}}
    <div class="footer">
        <div class="ttd">
            <p class="ttd-label">Kader Posyandu,</p>
            <div class="ttd-nama">{{ ucfirst(session('user')) }}</div>
            <div class="ttd-jabatan">Kader Posyandu</div>
        </div>
    </div>

</body>
</html>
