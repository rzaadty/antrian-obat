<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - QueuePro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --primary-dark: #3730a3;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --border: #e2e8f0;
            --sidebar-width: 260px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #334155;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: #fff;
            z-index: 1040;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header .logo-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }

        .sidebar-header h5 { font-size: 16px; font-weight: 700; margin: 0; line-height: 1.2; }
        .sidebar-header small { font-size: 11px; color: #94a3b8; font-weight: 400; }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }

        .sidebar-nav .nav-label {
            font-size: 10px; text-transform: uppercase; letter-spacing: 1.2px;
            color: #64748b; padding: 12px 12px 8px; font-weight: 600;
        }

        .sidebar-nav .nav-item { margin-bottom: 2px; }

        .sidebar-nav .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px; color: #cbd5e1; text-decoration: none;
            border-radius: 10px; font-size: 13.5px; font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: rgba(79, 70, 229, 0.15); color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .sidebar-nav .nav-link i { width: 20px; text-align: center; font-size: 15px; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-footer .user-info {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            background: rgba(255,255,255,0.05);
        }

        .sidebar-footer .user-avatar {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--success), #059669);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px; flex-shrink: 0;
        }

        .sidebar-footer .user-name { font-size: 13px; font-weight: 600; color: #fff; line-height: 1.2; }
        .sidebar-footer .user-role { font-size: 11px; color: #94a3b8; text-transform: capitalize; }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* ===== TOP NAVBAR ===== */
        .top-navbar {
            background: #fff;
            padding: 14px 24px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 1030;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .top-navbar .page-title {
            font-size: 18px; font-weight: 700; color: var(--dark);
            display: flex; align-items: center; gap: 10px;
        }

        .top-navbar .page-title i { color: var(--primary); }
        .top-navbar .nav-actions { display: flex; align-items: center; gap: 10px; }

        .btn-icon {
            width: 40px; height: 40px; border-radius: 10px;
            border: 1px solid var(--border); background: #fff;
            display: flex; align-items: center; justify-content: center;
            color: var(--gray); cursor: pointer; transition: all 0.2s;
        }

        .btn-icon:hover {
            background: var(--light); color: var(--primary);
            border-color: var(--primary-light);
        }

        .btn-sidebar-toggle {
            display: none;
            width: 40px; height: 40px; border-radius: 10px;
            border: 1px solid var(--border); background: #fff;
            align-items: center; justify-content: center;
            color: var(--dark); cursor: pointer; font-size: 18px;
        }

        /* ===== CONTENT AREA ===== */
        .content-area { padding: 24px; }

        /* ===== STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px; margin-bottom: 24px;
        }

        .stat-card {
            background: #fff; border-radius: 16px; padding: 20px;
            border: 1px solid var(--border);
            display: flex; align-items: center; gap: 16px;
            transition: all 0.3s; position: relative; overflow: hidden;
        }

        .stat-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
        }

        .stat-card.card-total::before { background: linear-gradient(90deg, var(--primary), var(--primary-light)); }
        .stat-card.card-super::before { background: linear-gradient(90deg, var(--warning), #fbbf24); }
        .stat-card.card-admin::before { background: linear-gradient(90deg, var(--info), #22d3ee); }
        .stat-card.card-loket::before { background: linear-gradient(90deg, var(--success), #34d399); }

        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }

        .stat-icon {
            width: 50px; height: 50px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }

        .card-total .stat-icon { background: #eef2ff; color: var(--primary); }
        .card-super .stat-icon { background: #fef3c7; color: var(--warning); }
        .card-admin .stat-icon { background: #cffafe; color: var(--info); }
        .card-loket .stat-icon { background: #d1fae5; color: var(--success); }

        .stat-info h3 {
            font-size: 24px; font-weight: 800; line-height: 1;
            margin-bottom: 4px; color: var(--dark);
        }

        .stat-info p { font-size: 12px; color: var(--gray); margin: 0; font-weight: 500; }

        /* ===== QUEUE TABLE CARD ===== */
        .queue-card {
            background: #fff; border-radius: 16px;
            border: 1px solid var(--border); overflow: hidden;
        }

        .queue-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
        }

        .queue-card-header h5 {
            font-size: 16px; font-weight: 700; color: var(--dark); margin: 0;
            display: flex; align-items: center; gap: 8px;
        }

        .queue-card-header h5 i { color: var(--primary); }

        .search-box { position: relative; }

        .search-box input {
            padding: 9px 14px 9px 38px;
            border: 1px solid var(--border); border-radius: 10px;
            font-size: 13px; width: 240px;
            transition: all 0.2s; background: var(--light);
        }

        .search-box input:focus {
            outline: none; border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); background: #fff;
        }

        .search-box i {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%); color: var(--gray); font-size: 14px;
        }

        .btn-add-queue {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; border: none; padding: 10px 20px;
            border-radius: 10px; font-size: 13px; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
            cursor: pointer; transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-add-queue:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
        }

        /* ===== TABLE ===== */
        .queue-table { width: 100%; border-collapse: collapse; }

        .queue-table thead th {
            background: #f8fafc; padding: 12px 16px;
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.8px; color: var(--gray);
            border-bottom: 1px solid var(--border); white-space: nowrap;
        }

        .queue-table tbody tr {
            border-bottom: 1px solid #f1f5f9; transition: background 0.15s;
        }

        .queue-table tbody tr:hover { background: #fafbff; }
        .queue-table tbody tr:last-child { border-bottom: none; }
        .queue-table td { padding: 14px 16px; font-size: 13.5px; vertical-align: middle; }

        .queue-number {
            display: inline-flex; align-items: center; justify-content: center;
            width: 42px; height: 42px; border-radius: 12px;
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            color: var(--primary); font-weight: 800; font-size: 15px;
        }

        .patient-info { display: flex; flex-direction: column; }
        .patient-name { font-weight: 600; color: var(--dark); font-size: 14px; }

        .patient-resep {
            font-size: 12px; color: var(--gray);
            display: flex; align-items: center; gap: 4px; margin-top: 2px;
        }

        /* ===== ROLE BADGE ===== */
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
        }

        .status-badge.status-superadmin {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }

        .status-badge.status-admin {
            background: linear-gradient(135deg, #cffafe, #a5f3fc);
            color: #155e75;
        }

        .status-badge .dot { width: 7px; height: 7px; border-radius: 50%; }
        .status-superadmin .dot { background: #f59e0b; }
        .status-admin .dot { background: #06b6d4; }

        /* ===== LOKET BADGE ===== */
        .loket-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 8px;
            background: #f1f5f9; color: var(--dark);
            font-size: 12px; font-weight: 600;
        }

        .loket-badge.empty {
            background: transparent;
            color: var(--gray);
            font-style: italic;
        }

        /* ===== ACTION BUTTONS ===== */
        .action-btns { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }

        .btn-action {
            padding: 7px 12px; border-radius: 8px;
            font-size: 12px; font-weight: 600; border: none;
            cursor: pointer; display: inline-flex;
            align-items: center; gap: 5px; transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-edit { background: #fef3c7; color: #92400e; }
        .btn-edit:hover { background: #fde68a; transform: translateY(-1px); }

        .btn-delete { background: #fee2e2; color: #991b1b; }
        .btn-delete:hover { background: #fecaca; transform: translateY(-1px); }

        /* ===== MODAL STYLES ===== */
        .modal-content {
            border: none; border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.15);
        }

        .modal-header { border-radius: 20px 20px 0 0; padding: 20px 24px; }
        .modal-header.bg-success { background: linear-gradient(135deg, var(--success), #059669) !important; }
        .modal-header.bg-warning { background: linear-gradient(135deg, var(--warning), #d97706) !important; }
        .modal-body { padding: 24px; }
        .modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); }

        .form-label { font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 6px; }

        .form-control, .form-select {
            border-radius: 10px; border: 1px solid var(--border);
            padding: 10px 14px; font-size: 14px; transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-text {
            font-size: 11px; color: var(--gray);
            margin-top: 4px; font-style: italic;
        }

        .btn-modal-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; border: none; padding: 10px 24px;
            border-radius: 10px; font-weight: 600; font-size: 13px;
        }

        .btn-modal-warning {
            background: linear-gradient(135deg, var(--warning), #d97706);
            color: #fff; border: none; padding: 10px 24px;
            border-radius: 10px; font-weight: 600; font-size: 13px;
        }

        /* ===== PAGINATION ===== */
        .pagination-wrapper {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex; justify-content: center;
        }

        .pagination .page-link {
            border-radius: 8px; margin: 0 3px;
            border: 1px solid var(--border);
            color: var(--gray); font-size: 13px;
            font-weight: 500; padding: 8px 14px;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary); border-color: var(--primary); color: #fff;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state i { font-size: 48px; color: #cbd5e1; margin-bottom: 16px; }
        .empty-state h6 { font-size: 16px; font-weight: 600; color: var(--dark); margin-bottom: 6px; }
        .empty-state p { font-size: 13px; color: var(--gray); }

        /* ===== MOBILE CARDS ===== */
        .mobile-queue-list { display: none; }

        .mobile-queue-card {
            background: #fff; border: 1px solid var(--border);
            border-radius: 14px; padding: 16px; margin-bottom: 12px;
            transition: all 0.2s;
        }

        .mobile-queue-card:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.06); }

        .mobile-queue-card .mqc-top {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 12px; gap: 10px;
        }

        .mobile-queue-card .mqc-number { display: flex; align-items: center; gap: 10px; }

        .mobile-queue-card .mqc-number .queue-number {
            width: 40px; height: 40px; font-size: 14px;
        }

        .mobile-queue-card .mqc-name { font-weight: 600; font-size: 14px; color: var(--dark); }
        .mobile-queue-card .mqc-resep { font-size: 12px; color: var(--gray); }

        .mobile-queue-card .mqc-actions {
            display: flex; gap: 6px; margin-top: 12px; flex-wrap: wrap;
        }

        .mobile-queue-card .mqc-actions .btn-action {
            flex: 1; justify-content: center; padding: 10px 12px;
        }

        /* ===== SIDEBAR OVERLAY (MOBILE) ===== */
        .sidebar-overlay {
            display: none; position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5); z-index: 1035;
            backdrop-filter: blur(2px);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .search-box input { width: 180px; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .main-content { margin-left: 0; }
            .btn-sidebar-toggle { display: flex; }
            .content-area { padding: 16px; }

            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }

            .stat-card { padding: 14px; gap: 10px; }

            .stat-icon {
                width: 40px; height: 40px; font-size: 16px; border-radius: 10px;
            }

            .stat-info h3 { font-size: 20px; }
            .stat-info p { font-size: 11px; }

            .queue-card-header { padding: 16px; }
            .queue-card-header .header-left { width: 100%; }

            .search-box { width: 100%; }
            .search-box input { width: 100%; }

            .queue-table-wrapper { display: none; }
            .mobile-queue-list { display: block; padding: 16px; }

            .top-navbar { padding: 12px 16px; }
            .top-navbar .page-title { font-size: 15px; }

            .btn-add-queue span.btn-text { display: none; }
        }

        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
            .stat-card { padding: 12px; gap: 8px; }
            .stat-icon { width: 36px; height: 36px; font-size: 14px; }
            .stat-info h3 { font-size: 18px; }
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .fade-in { animation: fadeIn 0.4s ease; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .live-clock {
            font-size: 13px; font-weight: 600; color: var(--gray);
            display: flex; align-items: center; gap: 6px;
            background: var(--light); padding: 8px 14px;
            border-radius: 10px; border: 1px solid var(--border);
        }

        .live-clock i { color: var(--primary); }

        .role-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 20px;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.5px;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }

        /* ===== ERROR ALERT ===== */
        .error-alert-custom {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: fadeIn 0.4s ease;
        }

        .error-alert-custom i {
            font-size: 16px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .error-alert-custom ul {
            margin: 0;
            padding-left: 18px;
        }

        .error-alert-custom li {
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

<!-- SIDEBAR OVERLAY (Mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon"><i class="fas fa-hospital"></i></div>
        <div>
            <h5>QueuePro</h5>
            <small>Sistem Antrian Digital</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <div class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
        </div>

        <div class="nav-label">Administrasi</div>
        <div class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link active">
                <i class="fas fa-users-cog"></i> Manajemen User
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">
                    <i class="fas fa-shield-alt me-1"></i>
                    {{ auth()->user()->role }}
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- MAIN CONTENT -->
<div class="main-content">
    <!-- TOP NAVBAR -->
    <header class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn-sidebar-toggle" id="btnSidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">
                <i class="fas fa-users-cog"></i>
                <span>Manajemen Pengguna</span>
            </div>
            <span class="role-badge d-none d-md-inline-flex">
                <i class="fas fa-crown"></i>
                Superadmin
            </span>
        </div>

        <div class="nav-actions">
            <div class="live-clock d-none d-md-flex">
                <i class="fas fa-clock"></i>
                <span id="liveClock">--:--:--</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-icon" title="Logout" style="color: var(--danger);">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- CONTENT AREA -->
    <div class="content-area">

        {{-- ERROR VALIDATION --}}
        @if ($errors->any())
            <div class="error-alert-custom">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- STATS CARDS -->
        @php
            $totalUsers = $users->total() ?? count($users);
            $superCount = \App\Models\User::where('role', 'superadmin')->count();
            $adminCount = \App\Models\User::where('role', 'admin')->count();
            $loketCount = \App\Models\User::whereNotNull('loket')->where('loket', '!=', '')->count();
        @endphp

        <div class="stats-grid fade-in">
            <div class="stat-card card-total">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Pengguna</p>
                </div>
            </div>
            <div class="stat-card card-super">
                <div class="stat-icon"><i class="fas fa-crown"></i></div>
                <div class="stat-info">
                    <h3>{{ $superCount }}</h3>
                    <p>Superadmin</p>
                </div>
            </div>
            <div class="stat-card card-admin">
                <div class="stat-icon"><i class="fas fa-user-shield"></i></div>
                <div class="stat-info">
                    <h3>{{ $adminCount }}</h3>
                    <p>Admin</p>
                </div>
            </div>
            <div class="stat-card card-loket">
                <div class="stat-icon"><i class="fas fa-desktop"></i></div>
                <div class="stat-info">
                    <h3>{{ $loketCount }}</h3>
                    <p>Pengguna Loket</p>
                </div>
            </div>
        </div>

        <!-- USERS TABLE CARD -->
        <div class="queue-card fade-in">
            <div class="queue-card-header">
                <div class="d-flex align-items-center gap-3 flex-wrap header-left">
                    <h5><i class="fas fa-list-ul"></i> Daftar Pengguna</h5>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchUser" placeholder="Cari nama / username...">
                    </div>
                </div>

                <button type="button" class="btn-add-queue" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                    <i class="fas fa-plus"></i>
                    <span class="btn-text">Tambah Pengguna</span>
                </button>
            </div>

            @if(session('error'))
                <div class="error-alert-custom" style="margin: 16px 24px 0;">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- DESKTOP TABLE -->
            <div class="queue-table-wrapper">
                <table class="queue-table" id="userTable">
                    <thead>
                        <tr>
                            <th style="padding-left:24px;">No</th>
                            <th>Pengguna</th>
                            <th>Role</th>
                            <th>Loket</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr data-search="{{ strtolower($user->name . ' ' . $user->username) }}">
                            <td style="padding-left:24px;">
                                <div class="queue-number">{{ $users->firstItem() + $index }}</div>
                            </td>
                            <td>
                                <div class="patient-info">
                                    <span class="patient-name">{{ $user->name }}</span>
                                    <span class="patient-resep">
                                        <i class="fas fa-at"></i>
                                        {{ $user->username }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $user->role }}">
                                    <span class="dot"></span>
                                    <i class="fas fa-{{ $user->role == 'superadmin' ? 'crown' : 'user-shield' }}"></i>
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td>
                                @if($user->loket)
                                    <span class="loket-badge">
                                        <i class="fas fa-desktop"></i>
                                        {{ $user->loket }}
                                    </span>
                                @else
                                    <span class="loket-badge empty">
                                        <i class="fas fa-minus-circle"></i>
                                        Tidak ada
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditUser{{ $user->id }}">
                                        <i class="fas fa-pen"></i> Edit
                                    </button>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- EDIT MODAL (Desktop) --}}
                        <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Pengguna: {{ $user->name }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-user me-1"></i> Nama Lengkap</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-at me-1"></i> Username</label>
                                                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-lock me-1"></i> Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                                                <div class="form-text">Abaikan field ini jika tidak ingin mengganti password.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-user-tag me-1"></i> Role</label>
                                                <select name="role" class="form-select" required>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-desktop me-1"></i> Loket <small class="text-muted">(Opsional, khusus Admin)</small></label>
                                                <input type="text" name="loket" class="form-control" value="{{ $user->loket }}" placeholder="Contoh: Loket 1">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;font-weight:600;font-size:13px;">Batal</button>
                                            <button type="submit" class="btn btn-modal-warning"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    <h6>Belum Ada Pengguna</h6>
                                    <p>Klik tombol "Tambah Pengguna" untuk menambahkan pengguna baru.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- MOBILE CARDS -->
            <div class="mobile-queue-list" id="mobileUserList">
                @forelse($users as $index => $user)
                <div class="mobile-queue-card" data-search="{{ strtolower($user->name . ' ' . $user->username) }}">
                    <div class="mqc-top">
                        <div class="mqc-number">
                            <div class="queue-number">{{ $users->firstItem() + $index }}</div>
                            <div>
                                <div class="mqc-name">{{ $user->name }}</div>
                                <div class="mqc-resep"><i class="fas fa-at"></i> {{ $user->username }}</div>
                            </div>
                        </div>
                        <span class="status-badge status-{{ $user->role }}">
                            <span class="dot"></span>
                            {{ strtoupper($user->role) }}
                        </span>
                    </div>

                    @if($user->loket)
                    <div class="d-flex align-items-center gap-2 mb-2" style="font-size:12px;color:var(--gray);">
                        <i class="fas fa-desktop"></i>
                        <span>Loket: <strong style="color:var(--dark);">{{ $user->loket }}</strong></span>
                    </div>
                    @endif

                    <div class="mqc-actions">
                        <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditUserM{{ $user->id }}">
                            <i class="fas fa-pen"></i> Edit
                        </button>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form" style="flex:1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete w-100 justify-content-center">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>

                {{-- MOBILE EDIT MODAL --}}
                <div class="modal fade" id="modalEditUserM{{ $user->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit: {{ $user->name }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select name="role" class="form-select" required>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Loket (Opsional)</label>
                                        <input type="text" name="loket" class="form-control" value="{{ $user->loket }}" placeholder="Contoh: Loket 1">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                                    <button type="submit" class="btn btn-modal-warning"><i class="fas fa-save me-1"></i> Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <h6>Belum Ada Pengguna</h6>
                    <p>Klik tombol "Tambah Pengguna" untuk menambahkan pengguna baru.</p>
                </div>
                @endforelse
            </div>

            <!-- PAGINATION -->
            @if($users->hasPages())
            <div class="pagination-wrapper">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- MODAL TAMBAH USER -->
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user me-1"></i> Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-at me-1"></i> Username</label>
                        <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock me-1"></i> Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user-tag me-1"></i> Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-desktop me-1"></i> Loket <small class="text-muted">(Opsional, khusus Admin)</small></label>
                        <input type="text" name="loket" class="form-control" placeholder="Contoh: Loket 1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;font-weight:600;font-size:13px;">Batal</button>
                    <button type="submit" class="btn btn-modal-primary"><i class="fas fa-save me-1"></i> Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

    // ===== SIDEBAR TOGGLE (MOBILE) =====
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('btnSidebarToggle');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });

    // ===== LIVE CLOCK =====
    function updateClock() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        const dateStr = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric' });
        document.getElementById('liveClock').textContent = timeStr + ' | ' + dateStr;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // ===== SEARCH FILTER =====
    $('#searchUser').on('keyup', function() {
        const query = $(this).val().toLowerCase();

        $('#userTable tbody tr[data-search]').each(function() {
            const text = $(this).data('search');
            $(this).toggle(text.includes(query));
        });

        $('.mobile-queue-card[data-search]').each(function() {
            const text = $(this).data('search');
            $(this).toggle(text.includes(query));
        });
    });

    // ===== SWEET ALERT SUCCESS =====
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    // ===== DELETE CONFIRMATION =====
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'Hapus pengguna ini?',
            text: "Aksi ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-trash-alt me-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
</body>
</html>