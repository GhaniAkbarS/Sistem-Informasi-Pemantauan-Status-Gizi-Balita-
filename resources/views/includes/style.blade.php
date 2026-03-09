    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">


    <!-- Custom Pages CSS (If any) -->
    <style>
        .header {
            background: white;
            color: #4e73df;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            border-radius: 8px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .container {
           /* padding: 20px; */
        }
        
        /* === RESTORED DASHBOARD STYLES === */
        .alert-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-icon {
            font-size: 24px;
        }

        .alert-content h3 {
            color: #856404;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .alert-content p {
            color: #856404;
            font-size: 14px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
            border-left: 4px solid #4e73df; /* Add Bootstrap Primary Color Accent */
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-title {
            font-size: 14px;
            color: #6b7280;
            font-weight: 700;
            text-transform: uppercase;
        }

        .stat-icon {
            font-size: 28px;
            color: #dddfeb;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #5a5c69;
            margin-bottom: 5px;
        }

        .stat-subtitle {
            font-size: 13px;
            color: #858796;
        }

        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .chart-card h2 {
            font-size: 18px;
            color: #4e73df;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .recent-table {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        /* Fix Responsive Grid */
        @media (max-width: 1024px) {
            .charts-section, .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
