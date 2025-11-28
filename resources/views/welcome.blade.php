<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posyandu Design System</title>
    <style>
        /* ============================================
           RESET & BASE STYLES
           ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Primary Colors - Sesuai tema kesehatan/posyandu */
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: #3b82f6;

            /* Secondary Colors */
            --secondary: #10b981;
            --secondary-dark: #059669;

            /* Alert Colors */
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;

            /* Neutral Colors */
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;

            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --spacing-2xl: 3rem;

            /* Border Radius */
            --radius-sm: 0.25rem;
            --radius-md: 0.375rem;
            --radius-lg: 0.5rem;
            --radius-xl: 1rem;

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.5;
            color: var(--gray-900);
            background-color: var(--gray-50);
        }

        /* ============================================
           LAYOUT CLASSES
           ============================================ */
        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 var(--spacing-md);
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 256px;
            background-color: var(--primary);
            color: var(--white);
            transition: width 0.3s ease;
            z-index: 40;
        }

        .sidebar-collapsed {
            width: 80px;
        }

        .main-content {
            margin-left: 256px;
            padding: var(--spacing-xl);
            transition: margin-left 0.3s ease;
        }

        .main-content-expanded {
            margin-left: 80px;
        }

        .page-header {
            margin-bottom: var(--spacing-xl);
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        /* Grid System */
        .grid {
            display: grid;
            gap: var(--spacing-lg);
        }

        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }

        @media (max-width: 768px) {
            .grid-cols-2,
            .grid-cols-3,
            .grid-cols-4 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }

        /* Flex Utilities */
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .flex-wrap { flex-wrap: wrap; }
        .items-center { align-items: center; }
        .items-start { align-items: flex-start; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .gap-sm { gap: var(--spacing-sm); }
        .gap-md { gap: var(--spacing-md); }
        .gap-lg { gap: var(--spacing-lg); }

        /* ============================================
           CARD COMPONENTS
           ============================================ */
        .card {
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            padding-bottom: var(--spacing-md);
            border-bottom: 1px solid var(--gray-200);
            margin-bottom: var(--spacing-md);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .card-body {
            padding: var(--spacing-md) 0;
        }

        /* Stat Card */
        .stat-card {
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-sm);
        }

        .stat-card-primary {
            background-color: #eff6ff;
            border-color: #bfdbfe;
        }

        .stat-card-success {
            background-color: #f0fdf4;
            border-color: #bbf7d0;
        }

        .stat-card-danger {
            background-color: #fef2f2;
            border-color: #fecaca;
        }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        /* ============================================
           BUTTON COMPONENTS
           ============================================ */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: var(--radius-md);
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            gap: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--white);
        }

        .btn-secondary:hover {
            background-color: var(--secondary-dark);
        }

        .btn-success {
            background-color: var(--success);
            color: var(--white);
        }

        .btn-danger {
            background-color: var(--danger);
            color: var(--white);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
        }

        .btn-outline:hover {
            background-color: var(--gray-50);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }

        .btn-icon {
            padding: 0.5rem;
            border-radius: var(--radius-md);
        }

        /* ============================================
           TABLE COMPONENTS
           ============================================ */
        .table-container {
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background-color: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
        }

        .table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .table tbody tr:hover {
            background-color: var(--gray-50);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ============================================
           FORM COMPONENTS
           ============================================ */
        .form-group {
            margin-bottom: var(--spacing-lg);
        }

        .form-label {
            display: block;
            margin-bottom: var(--spacing-sm);
            font-weight: 500;
            color: var(--gray-700);
            font-size: 0.875rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-input-error {
            border-color: var(--danger);
        }

        .form-error-message {
            margin-top: var(--spacing-xs);
            font-size: 0.75rem;
            color: var(--danger);
        }

        .form-help-text {
            margin-top: var(--spacing-xs);
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        /* ============================================
           BADGE COMPONENTS
           ============================================ */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-primary {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* ============================================
           ALERT COMPONENTS
           ============================================ */
        .alert {
            padding: var(--spacing-md);
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-md);
        }

        .alert-success {
            background-color: #d1fae5;
            border: 1px solid #86efac;
            color: #065f46;
        }

        .alert-warning {
            background-color: #fef3c7;
            border: 1px solid #fde68a;
            color: #92400e;
        }

        .alert-danger {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-info {
            background-color: #dbeafe;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        /* ============================================
           MODAL COMPONENTS
           ============================================ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .modal {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: var(--spacing-lg);
            border-bottom: 1px solid var(--gray-200);
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .modal-body {
            padding: var(--spacing-lg);
        }

        .modal-footer {
            padding: var(--spacing-lg);
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: flex-end;
            gap: var(--spacing-sm);
        }

        /* ============================================
           NAVIGATION COMPONENTS
           ============================================ */
        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--white);
            text-decoration: none;
            transition: background-color 0.2s ease;
            border-radius: var(--radius-md);
            margin: 0.25rem 0.5rem;
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-item-active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .nav-icon {
            margin-right: var(--spacing-sm);
        }

        /* ============================================
           UTILITY CLASSES
           ============================================ */
        /* Spacing */
        .m-0 { margin: 0; }
        .m-sm { margin: var(--spacing-sm); }
        .m-md { margin: var(--spacing-md); }
        .m-lg { margin: var(--spacing-lg); }
        .m-xl { margin: var(--spacing-xl); }

        .mt-sm { margin-top: var(--spacing-sm); }
        .mt-md { margin-top: var(--spacing-md); }
        .mt-lg { margin-top: var(--spacing-lg); }
        .mt-xl { margin-top: var(--spacing-xl); }

        .mb-sm { margin-bottom: var(--spacing-sm); }
        .mb-md { margin-bottom: var(--spacing-md); }
        .mb-lg { margin-bottom: var(--spacing-lg); }
        .mb-xl { margin-bottom: var(--spacing-xl); }

        .p-sm { padding: var(--spacing-sm); }
        .p-md { padding: var(--spacing-md); }
        .p-lg { padding: var(--spacing-lg); }
        .p-xl { padding: var(--spacing-xl); }

        /* Text Utilities */
        .text-xs { font-size: 0.75rem; }
        .text-sm { font-size: 0.875rem; }
        .text-base { font-size: 1rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }

        .font-normal { font-weight: 400; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }

        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Color Utilities */
        .text-primary { color: var(--primary); }
        .text-success { color: var(--success); }
        .text-warning { color: var(--warning); }
        .text-danger { color: var(--danger); }
        .text-gray-500 { color: var(--gray-500); }
        .text-gray-600 { color: var(--gray-600); }
        .text-gray-700 { color: var(--gray-700); }

        .bg-white { background-color: var(--white); }
        .bg-gray-50 { background-color: var(--gray-50); }
        .bg-primary { background-color: var(--primary); }

        /* Border Utilities */
        .border { border: 1px solid var(--gray-200); }
        .border-b { border-bottom: 1px solid var(--gray-200); }
        .border-t { border-top: 1px solid var(--gray-200); }
        .rounded { border-radius: var(--radius-md); }
        .rounded-lg { border-radius: var(--radius-lg); }
        .rounded-full { border-radius: 9999px; }

        /* Display Utilities */
        .hidden { display: none; }
        .block { display: block; }
        .inline-block { display: inline-block; }

        /* Width Utilities */
        .w-full { width: 100%; }
        .w-auto { width: auto; }

        /* Shadow Utilities */
        .shadow-sm { box-shadow: var(--shadow-sm); }
        .shadow-md { box-shadow: var(--shadow-md); }
        .shadow-lg { box-shadow: var(--shadow-lg); }

        /* Position Utilities */
        .relative { position: relative; }
        .absolute { position: absolute; }
        .fixed { position: fixed; }

        /* ============================================
           RESPONSIVE UTILITIES
           ============================================ */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .hidden-mobile {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- EXAMPLE USAGE / DOKUMENTASI -->
    <div class="container" style="padding-top: 2rem;">
        <h1 class="text-3xl font-bold mb-xl">Posyandu Design System Documentation</h1>

        <!-- BUTTONS EXAMPLE -->
        <section class="card mb-xl">
            <h2 class="card-title mb-md">Buttons</h2>
            <div class="flex flex-wrap gap-md">
                <button class="btn btn-primary">Primary Button</button>
                <button class="btn btn-secondary">Secondary Button</button>
                <button class="btn btn-success">Success Button</button>
                <button class="btn btn-danger">Danger Button</button>
                <button class="btn btn-outline">Outline Button</button>
            </div>
            <div class="flex flex-wrap gap-md mt-md">
                <button class="btn btn-primary btn-sm">Small</button>
                <button class="btn btn-primary">Medium</button>
                <button class="btn btn-primary btn-lg">Large</button>
            </div>
        </section>

        <!-- STAT CARDS EXAMPLE -->
        <section class="mb-xl">
            <h2 class="text-2xl font-bold mb-md">Stat Cards</h2>
            <div class="grid grid-cols-3">
                <div class="stat-card stat-card-primary">
                    <p class="stat-label">Total Balita</p>
                    <p class="stat-value text-primary">125</p>
                </div>
                <div class="stat-card stat-card-success">
                    <p class="stat-label">Status Normal</p>
                    <p class="stat-value text-success">98</p>
                </div>
                <div class="stat-card stat-card-danger">
                    <p class="stat-label">Perlu Perhatian</p>
                    <p class="stat-value text-danger">27</p>
                </div>
            </div>
        </section>

        <!-- TABLE EXAMPLE -->
        <section class="mb-xl">
            <h2 class="text-2xl font-bold mb-md">Table</h2>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Balita</th>
                            <th>Tanggal Lahir</th>
                            <th>Status Gizi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Rojali Marpuut</td>
                            <td>15 Maret 2022</td>
                            <td><span class="badge badge-success">Normal</span></td>
                            <td>
                                <button class="btn btn-icon btn-outline">✏️</button>
                                <button class="btn btn-icon btn-outline">🗑️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Siti Nurhaliza</td>
                            <td>20 Agustus 2021</td>
                            <td><span class="badge badge-warning">Pendek</span></td>
                            <td>
                                <button class="btn btn-icon btn-outline">✏️</button>
                                <button class="btn btn-icon btn-outline">🗑️</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- FORM EXAMPLE -->
        <section class="card mb-xl">
            <h2 class="card-title mb-md">Form Components</h2>
            <form>
                <div class="form-group">
                    <label class="form-label">Nama Balita</label>
                    <input type="text" class="form-input" placeholder="Masukkan nama balita">
                    <p class="form-help-text">Nama lengkap sesuai akta kelahiran</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-select">
                        <option>Pilih jenis kelamin</option>
                        <option>Laki-laki</option>
                        <option>Perempuan</option>
                    </select>
                </div>

                <div class="flex gap-md">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-outline">Batal</button>
                </div>
            </form>
        </section>

        <!-- BADGES EXAMPLE -->
        <section class="card mb-xl">
            <h2 class="card-title mb-md">Badges</h2>
            <div class="flex flex-wrap gap-md">
                <span class="badge badge-primary">Primary</span>
                <span class="badge badge-success">Success</span>
                <span class="badge badge-warning">Warning</span>
                <span class="badge badge-danger">Danger</span>
            </div>
        </section>

        <!-- ALERTS EXAMPLE -->
        <section class="mb-xl">
            <h2 class="text-2xl font-bold mb-md">Alerts</h2>
            <div class="alert alert-success">
                ✓ Data berhasil disimpan!
            </div>
            <div class="alert alert-warning">
                ⚠ Balita ini memerlukan perhatian khusus.
            </div>
            <div class="alert alert-danger">
                ✕ Terjadi kesalahan saat menyimpan data.
            </div>
            <div class="alert alert-info">
                ℹ Ada 3 pemeriksaan yang perlu ditindaklanjuti.
            </div>
        </section>
    </div>
</body>
</html>
