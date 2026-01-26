    <!-- CSS files -->
    <link href="{{ asset('tabler/css/tabler.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/css/demo.min.css?1692870487') }}" rel="stylesheet"/>

    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>

    <!-- CSS app layout -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            display: flex;
            min-height: 100vh;
        }

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

        .navbar-brand-icon {
            font-size: 28px;
        }

        .navbar-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
            list-style: none;
            width: 100%;
        }

        .navbar-item {
            position: relative;
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

        .navbar-link-icon {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .navbar-right {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            border-top: 1px solid #f3f4f6;
            padding-top: 20px;
            width: 100%;
        }

        .navbar-notification {
            position: relative;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .navbar-notification:hover {
            background: #f3f4f6;
        }

        .notification-badge {
            position: absolute;
            top: 4px;
            left: 20px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 5px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
            width: 100%;
        }

        .navbar-user:hover {
            background: #f3f4f6;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 12px;
            color: #6b7280;
        }

        .navbar-toggle {
            display: none;
        }

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

        .header-content {
            width: 100%;
            /* Removed max-width to allow full width */
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .header-info {
            text-align: right;
            font-size: 14px;
        }

        .container {
            width: 100%;
            /* Removed max-width to fix gap */
            max-width: none;
            margin: 0;
            padding: 30px;
        }

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
            font-weight: 500;
        }

        .stat-icon {
            font-size: 28px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .stat-subtitle {
            font-size: 13px;
            color: #9ca3af;
        }

        .stat-trend {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .trend-up {
            background: #d1fae5;
            color: #065f46;
        }

        .trend-down {
            background: #fee2e2;
            color: #991b1b;
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
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .chart-placeholder {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            height: 300px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 14px;
        }

        .status-breakdown {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .status-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .status-label {
            flex: 1;
            font-size: 14px;
            color: #4b5563;
        }

        .status-count {
            font-weight: 700;
            font-size: 16px;
            color: #1f2937;
        }

        .status-percentage {
            font-size: 12px;
            color: #9ca3af;
            min-width: 45px;
            text-align: right;
        }

        .recent-table {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .recent-table h2 {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f9fafb;
        }

        th {
            padding: 12px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            padding: 12px;
            font-size: 14px;
            border-bottom: 1px solid #f3f4f6;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-normal {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-btn {
            padding: 6px 12px;
            background: #0891b2;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .action-btn:hover {
            background: #0e7490;
        }

        @media (max-width: 1024px) {
            .charts-section {
                grid-template-columns: 1fr;
            }

            .navbar-menu {
                display: none;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 10px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }

            .navbar-menu.active {
                display: flex;
            }

            .navbar-toggle {
                display: block;
            }

            .navbar-right {
                gap: 10px;
            }

            .user-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 20px 15px;
            }

            .navbar-container {
                padding: 0 15px;
            }

            .header {
                padding: 20px 15px;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .header-info {
                text-align: left;
            }
        }
    </style>

