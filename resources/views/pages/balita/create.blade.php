
<x-app-layout>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Balita - Posyandu Cendrawasih</title>
    @push('after-style')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            display: flex;
            min-height: 100vh;
        }

        /* Navbar Styles from Dashboard */
        .navbar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #ffffff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            z-index: 1000;
        }

        .navbar-container {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 0 20px;
            width: 100%;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
            color: #0891b2;
            text-decoration: none;
            margin-bottom: 30px;
            padding: 0 10px;
        }

        .navbar-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
            list-style: none;
            width: 100%;
        }

        .navbar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s;
            width: 100%;
        }

        .navbar-link:hover {
            background: #ecfeff;
            color: #0891b2;
        }

        .navbar-link.active {
            background: #cffafe;
            color: #0e7490;
            font-weight: 600;
        }

        .navbar-right {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            border-top: 1px solid #f3f4f6;
            padding-top: 20px;
            width: 100%;
        }
        
        /* Main Layout */
        .main-content {
            flex: 1;
            margin-left: 260px;
            width: calc(100% - 260px);
            display: flex;
            flex-direction: column;
        }

        .header {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            color: white;
            padding: 30px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
            width: 100%;
        }

        /* Form Card Styles */
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .form-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #0891b2;
            box-shadow: 0 0 0 3px rgba(8, 145, 178, 0.1);
        }

        .btn-submit {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
            float: right;
            margin-top: 10px;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }

        .alert-success {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-group.full-width {
                grid-column: span 1;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .navbar {
                display: none; /* Simplification for now, usually would have toggle */
            }
        }
    </style>
    @endpush
</head>
<body>
    

    <div class="main-content">
        <div class="header">
            <h1>Input Data Balita</h1>
            <p style="opacity: 0.9; margin-top: 5px;">Form pencatatan data balita baru</p>
        </div>

        <div class="container">
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <form action="{{ route('balita.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <!-- Nama Balita -->
                        <div class="form-group full-width">
                            <label for="nama" class="form-label">Nama Lengkap Balita</label>
                            <input type="text" id="nama" name="nama" class="form-input" placeholder="Masukkan nama lengkap balita" required>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="form-group">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-input" required>
                        </div>

                        <!-- Umur (Bulan) -->
                        <div class="form-group">
                            <label for="umur" class="form-label">Umur (Bulan)</label>
                            <input type="number" id="umur" name="umur" class="form-input" placeholder="Terisi otomatis" required>
                            <small style="color: #6b7280; font-size: 12px;">*Dihitung otomatis per hari ini</small>
                        </div>

                        <!-- Nama Orang Tua -->
                        <div class="form-group full-width">
                            <label for="nama_ortu" class="form-label">Nama Orang Tua (Ibu/Ayah)</label>
                            <input type="text" id="nama_ortu" name="nama_ortu" class="form-input" placeholder="Masukkan nama orang tua" required>
                        </div>

                        <!-- Tinggi Badan -->
                        <div class="form-group">
                            <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                            <input type="number" step="0.1" id="tinggi_badan" name="tinggi_badan" class="form-input" placeholder="Contoh: 85.5" required>
                        </div>

                        <!-- Berat Badan -->
                        <div class="form-group">
                            <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                            <input type="number" step="0.1" id="berat_badan" name="berat_badan" class="form-input" placeholder="Contoh: 10.5" required>
                        </div>
                    </div>

                    <div style="overflow: hidden; margin-top: 20px;">
                        <button type="submit" class="btn-submit">Simpan Data</button>
                    </div>
                </form>
            </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tglLahirInput = document.getElementById('tgl_lahir');
            const umurInput = document.getElementById('umur');

            function hitungUmur() {
                const nilaiTanggal = tglLahirInput.value;
                if (!nilaiTanggal) return; // Jangan hitung jika kosong

                const tglLahir = new Date(nilaiTanggal);
                const today = new Date();
                
                if (isNaN(tglLahir.getTime())) return;

                let months = (today.getFullYear() - tglLahir.getFullYear()) * 12;
                months -= tglLahir.getMonth();
                months += today.getMonth();

                // Koreksi jika tanggal hari ini belum melewati tanggal lahir di bulan ini
                if (today.getDate() < tglLahir.getDate()) {
                    months--;
                }

                // Pastikan tidak negatif
                if (months < 0) months = 0;

                umurInput.value = months;
            }

            // Dengarkan berbagai jenis event agar lebih responsif
            tglLahirInput.addEventListener('change', hitungUmur);
            tglLahirInput.addEventListener('input', hitungUmur);
            tglLahirInput.addEventListener('keyup', hitungUmur);
        });
    </script>
</body>
</html>
</x-app-layout>