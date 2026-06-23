<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Antrian - Admin Panel</title>
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
        .stat-card.card-waiting::before { background: linear-gradient(90deg, var(--warning), #fbbf24); }
        .stat-card.card-called::before { background: linear-gradient(90deg, var(--info), #22d3ee); }
        .stat-card.card-done::before { background: linear-gradient(90deg, var(--success), #34d399); }

        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }

        .stat-icon {
            width: 50px; height: 50px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }

        .card-total .stat-icon { background: #eef2ff; color: var(--primary); }
        .card-waiting .stat-icon { background: #fef3c7; color: var(--warning); }
        .card-called .stat-icon { background: #cffafe; color: var(--info); }
        .card-done .stat-icon { background: #d1fae5; color: var(--success); }

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
            width: 48px; height: 48px; border-radius: 12px;
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            color: var(--primary); font-weight: 800; font-size: 16px;
        }

        .patient-info { display: flex; flex-direction: column; }
        .patient-name { font-weight: 600; color: var(--dark); font-size: 14px; }

        .patient-resep {
            font-size: 12px; color: var(--gray);
            display: flex; align-items: center; gap: 4px; margin-top: 2px;
        }

        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
        }

        .status-badge.status-menunggu { background: #fef3c7; color: #92400e; }
        .status-badge.status-dipanggil { background: #cffafe; color: #155e75; }
        .status-badge.status-selesai { background: #d1fae5; color: #065f46; }

        .status-badge .dot { width: 7px; height: 7px; border-radius: 50%; }
        .status-menunggu .dot { background: #f59e0b; }
        .status-dipanggil .dot { background: #06b6d4; animation: pulse-dot 1.5s infinite; }
        .status-selesai .dot { background: #10b981; }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        .officer-info { display: flex; align-items: center; gap: 8px; }

        .officer-avatar {
            width: 30px; height: 30px; border-radius: 8px;
            background: #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; color: var(--gray); flex-shrink: 0;
        }

        .officer-name { font-size: 13px; font-weight: 500; color: var(--dark); }

        .action-btns { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }

        .btn-action {
            padding: 7px 12px; border-radius: 8px;
            font-size: 12px; font-weight: 600; border: none;
            cursor: pointer; display: inline-flex;
            align-items: center; gap: 5px; transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-call {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .btn-call:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4); }

        .btn-call:disabled {
            background: #94a3b8; box-shadow: none;
            transform: none; cursor: not-allowed;
        }

        .btn-edit { background: #fef3c7; color: #92400e; }
        .btn-edit:hover { background: #fde68a; }

        .btn-delete { background: #fee2e2; color: #991b1b; }
        .btn-delete:hover { background: #fecaca; }

        .btn-recall {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: #fff; box-shadow: 0 2px 8px rgba(6, 182, 212, 0.3);
        }

        .btn-recall:hover { transform: translateY(-1px); }

        .locked-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 6px 12px; border-radius: 8px;
            background: #fee2e2; color: #991b1b;
            font-size: 12px; font-weight: 600;
        }

        /* ===== CALL TIMER OVERLAY ===== */
        .call-timer-overlay {
            display: none; position: fixed;
            bottom: 24px; right: 24px;
            background: #fff; border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            border: 1px solid var(--border);
            z-index: 9999; min-width: 280px;
            animation: slideInUp 0.4s ease;
        }

        @keyframes slideInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .call-timer-overlay .timer-header {
            display: flex; align-items: center; gap: 10px; margin-bottom: 12px;
        }

        .call-timer-overlay .timer-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, var(--success), #059669);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 16px;
            animation: pulse-icon 1.5s infinite;
        }

        @keyframes pulse-icon {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        }

        .call-timer-overlay .timer-title { font-size: 14px; font-weight: 700; color: var(--dark); }
        .call-timer-overlay .timer-subtitle { font-size: 12px; color: var(--gray); }

        .timer-progress {
            height: 6px; background: #e2e8f0;
            border-radius: 3px; overflow: hidden; margin-top: 10px;
        }

        .timer-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--success), var(--info));
            border-radius: 3px; transition: width 1s linear; width: 100%;
        }

        .timer-countdown {
            text-align: center; font-size: 28px; font-weight: 800;
            color: var(--primary); margin-top: 8px;
            font-variant-numeric: tabular-nums;
        }

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

        /* ===== MOBILE QUEUE CARDS ===== */
        .mobile-queue-list { display: none; }

        .mobile-queue-card {
            background: #fff; border: 1px solid var(--border);
            border-radius: 14px; padding: 16px; margin-bottom: 12px;
            transition: all 0.2s;
        }

        .mobile-queue-card:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.06); }

        .mobile-queue-card .mqc-top {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 12px;
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

            .call-timer-overlay {
                bottom: 16px; right: 16px; left: 16px;
                min-width: auto;
            }

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

        /* Role badge di navbar */
        .role-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 20px;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.5px;
        }

        .role-badge.superadmin {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }

        .role-badge.admin {
            background: linear-gradient(135deg, #cffafe, #a5f3fc);
            color: #155e75;
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
            <a href="#" class="nav-link active">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
        </div>

        @if(auth()->user()->role === 'superadmin')
        <div class="nav-label">Administrasi</div>
        <div class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="fas fa-users-cog"></i> Manajemen User
            </a>
        </div>
        @endif
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
                <i class="fas fa-th-large"></i>
                <span>Dashboard Antrian</span>
            </div>
            <span class="role-badge {{ auth()->user()->role }} d-none d-md-inline-flex">
                <i class="fas fa-{{ auth()->user()->role === 'superadmin' ? 'crown' : 'user-shield' }}"></i>
                {{ auth()->user()->role }}
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
        <!-- STATS CARDS -->
        @php
            $total = $queues->total() ?? count($queues);
            $menunggu = $queues->where('status', 'menunggu')->count() ?? 0;
            $dipanggil = $queues->where('status', 'dipanggil')->count() ?? 0;
            $selesai = $queues->where('status', 'selesai')->count() ?? 0;
        @endphp

        <div class="stats-grid fade-in">
            <div class="stat-card card-total">
                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                <div class="stat-info">
                    <h3>{{ $total }}</h3>
                    <p>Total Antrian</p>
                </div>
            </div>
            <div class="stat-card card-waiting">
                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-info">
                    <h3 id="countMenunggu">{{ $menunggu }}</h3>
                    <p>Menunggu</p>
                </div>
            </div>
            <div class="stat-card card-called">
                <div class="stat-icon"><i class="fas fa-bullhorn"></i></div>
                <div class="stat-info">
                    <h3 id="countDipanggil">{{ $dipanggil }}</h3>
                    <p>Dipanggil</p>
                </div>
            </div>
            <div class="stat-card card-done">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <h3 id="countSelesai">{{ $selesai }}</h3>
                    <p>Selesai</p>
                </div>
            </div>
        </div>

        <!-- QUEUE TABLE CARD -->
        <div class="queue-card fade-in">
            <div class="queue-card-header">
                <div class="d-flex align-items-center gap-3 flex-wrap header-left">
                    <h5><i class="fas fa-list-ul"></i> Daftar Antrian</h5>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchQueue" placeholder="Cari nama pasien / no resep...">
                    </div>
                </div>

                {{-- TOMBOL TAMBAH ANTRIAN HANYA MUNCUL UNTUK SUPERADMIN --}}
                @if(auth()->user()->role === 'superadmin')
                <button type="button" class="btn-add-queue" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fas fa-plus"></i>
                    <span class="btn-text">Tambah Antrian</span>
                </button>
                @endif
            </div>

            @if(session('error'))
                <div class="alert alert-danger m-3 mb-0 d-flex align-items-center gap-2" style="border-radius: 10px; font-size: 13px;">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- DESKTOP TABLE -->
            <div class="queue-table-wrapper">
                <table class="queue-table" id="queueTable">
                    <thead>
                        <tr>
                            <th style="padding-left:24px;">No. Antrian</th>
                            <th>Pasien</th>
                            <th>Status</th>
                            <th>Petugas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($queues as $q)
                        @php
                            $isLocked = $q->admin_id && $q->admin_id !== auth()->id() && auth()->user()->role !== 'superadmin';
                        @endphp
                        <tr data-search="{{ strtolower($q->nama_pasien . ' ' . $q->no_resep) }}">
                            <td style="padding-left:24px;">
                                <div class="queue-number">{{ str_pad($q->queue_number, 3, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td>
                                <div class="patient-info">
                                    <span class="patient-name">{{ $q->nama_pasien }}</span>
                                    <span class="patient-resep">
                                        <i class="fas fa-prescription"></i>
                                        {{ $q->no_resep }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $q->status }}">
                                    <span class="dot"></span>
                                    {{ ucfirst($q->status) }}
                                </span>
                            </td>
                            <td>
                                @if($q->admin_id)
                                    <div class="officer-info">
                                        <div class="officer-avatar"><i class="fas fa-user"></i></div>
                                        <span class="officer-name">{{ $q->admin->name }}</span>
                                    </div>
                                @else
                                    <span style="color: var(--gray); font-size: 13px;">
                                        <i class="fas fa-minus-circle"></i> Belum ditangani
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns">
                                    @if($isLocked)
                                        <span class="locked-badge">
                                            <i class="fas fa-lock"></i> Terkunci
                                        </span>
                                    @else
                                        @if($q->status == 'dipanggil')
                                            <button class="btn-action btn-recall btn-panggil" data-id="{{ $q->id }}" data-nama="{{ $q->nama_pasien }}" data-nomor="{{ str_pad($q->queue_number, 3, '0', STR_PAD_LEFT) }}">
                                                <i class="fas fa-redo"></i> Panggil Ulang
                                            </button>
                                        @else
                                            <button class="btn-action btn-call btn-panggil {{ $q->status == 'selesai' ? 'disabled' : '' }}" data-id="{{ $q->id }}" data-nama="{{ $q->nama_pasien }}" data-nomor="{{ str_pad($q->queue_number, 3, '0', STR_PAD_LEFT) }}" {{ $q->status == 'selesai' ? 'disabled' : '' }}>
                                                <i class="fas fa-volume-up"></i> Panggil
                                            </button>
                                        @endif

                                        <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $q->id }}">
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        {{-- TOMBOL HAPUS HANYA UNTUK SUPERADMIN --}}
                                        @if(auth()->user()->role === 'superadmin')
                                        <form action="{{ route('queues.destroy', $q->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- EDIT MODAL (Desktop) --}}
                        @if(!$isLocked)
                        <div class="modal fade" id="modalEdit{{ $q->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('queues.update', $q->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Antrian #{{ str_pad($q->queue_number, 3, '0', STR_PAD_LEFT) }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-prescription me-1"></i> Nomor Resep</label>
                                                <input type="text" name="no_resep" class="form-control" value="{{ $q->no_resep }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-user me-1"></i> Nama Pasien</label>
                                                <input type="text" name="nama_pasien" class="form-control" value="{{ $q->nama_pasien }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-flag me-1"></i> Status Antrian</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="menunggu" {{ $q->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                    <option value="dipanggil" {{ $q->status == 'dipanggil' ? 'selected' : '' }}>Dipanggil / Menuju Loket</option>
                                                    <option value="selesai" {{ $q->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                </select>
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
                        @endif
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h6>Belum Ada Antrian</h6>
                                    <p>Belum ada data antrian untuk hari ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- MOBILE QUEUE CARDS -->
            <div class="mobile-queue-list" id="mobileQueueList">
                @forelse($queues as $q)
                @php
                    $isLocked = $q->admin_id && $q->admin_id !== auth()->id() && auth()->user()->role !== 'superadmin';
                @endphp
                <div class="mobile-queue-card" data-search="{{ strtolower($q->nama_pasien . ' ' . $q->no_resep) }}">
                    <div class="mqc-top">
                        <div class="mqc-number">
                            <div class="queue-number">{{ str_pad($q->queue_number, 3, '0', STR_PAD_LEFT) }}</div>
                            <div>
                                <div class="mqc-name">{{ $q->nama_pasien }}</div>
                                <div class="mqc-resep"><i class="fas fa-prescription"></i> {{ $q->no_resep }}</div>
                            </div>
                        </div>
                        <span class="status-badge status-{{ $q->status }}">
                            <span class="dot"></span>
                            {{ ucfirst($q->status) }}
                        </span>
                    </div>

                    @if($q->admin_id)
                    <div class="d-flex align-items-center gap-2 mb-2" style="font-size:12px;color:var(--gray);">
                        <i class="fas fa-user-circle"></i>
                        <span>Ditangani: <strong style="color:var(--dark);">{{ $q->admin->name }}</strong></span>
                    </div>
                    @endif

                    <div class="mqc-actions">
                        @if($isLocked)
                            <span class="locked-badge w-100 justify-content-center">
                                <i class="fas fa-lock"></i> Antrian Terkunci
                            </span>
                        @else
                            @if($q->status == 'dipanggil')
                                <button class="btn-action btn-recall btn-panggil" data-id="{{ $q->id }}" data-nama="{{ $q->nama_pasien }}" data-nomor="{{ str_pad($q->queue_number, 3, '0', STR_PAD_LEFT) }}">
                                    <i class="fas fa-redo"></i> Panggil Ulang
                                </button>
                            @else
                                <button class="btn-action btn-call btn-panggil {{ $q->status == 'selesai' ? 'disabled' : '' }}" data-id="{{ $q->id }}" data-nama="{{ $q->nama_pasien }}" data-nomor="{{ str_pad($q->queue_number, 3, '0', STR_PAD_LEFT) }}" {{ $q->status == 'selesai' ? 'disabled' : '' }}>
                                    <i class="fas fa-volume-up"></i> Panggil
                                </button>
                            @endif
                            <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditM{{ $q->id }}">
                                <i class="fas fa-pen"></i> Edit
                            </button>
                            {{-- HAPUS HANYA SUPERADMIN --}}
                            @if(auth()->user()->role === 'superadmin')
                            <form action="{{ route('queues.destroy', $q->id) }}" method="POST" class="d-inline delete-form" style="flex:1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete w-100 justify-content-center">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- MOBILE EDIT MODAL --}}
                @if(!$isLocked)
                <div class="modal fade" id="modalEditM{{ $q->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('queues.update', $q->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit #{{ str_pad($q->queue_number, 3, '0', STR_PAD_LEFT) }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Resep</label>
                                        <input type="text" name="no_resep" class="form-control" value="{{ $q->no_resep }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Pasien</label>
                                        <input type="text" name="nama_pasien" class="form-control" value="{{ $q->nama_pasien }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="menunggu" {{ $q->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="dipanggil" {{ $q->status == 'dipanggil' ? 'selected' : '' }}>Dipanggil</option>
                                            <option value="selesai" {{ $q->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
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
                @endif
                @empty
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h6>Belum Ada Antrian</h6>
                    <p>Belum ada data antrian hari ini.</p>
                </div>
                @endforelse
            </div>

            <!-- PAGINATION -->
            @if($queues->hasPages())
            <div class="pagination-wrapper">
                {{ $queues->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- CALL TIMER OVERLAY -->
<div class="call-timer-overlay" id="callTimerOverlay">
    <div class="timer-header">
        <div class="timer-icon"><i class="fas fa-bullhorn"></i></div>
        <div>
            <div class="timer-title" id="timerPatientName">Memanggil Pasien...</div>
            <div class="timer-subtitle">Panggilan suara aktif (20 detik)</div>
        </div>
    </div>
    <div class="timer-countdown" id="timerCountdown">20</div>
    <div class="timer-progress">
        <div class="timer-progress-bar" id="timerProgressBar"></div>
    </div>
</div>

{{-- MODAL TAMBAH ANTRIAN - HANYA SUPERADMIN --}}
@if(auth()->user()->role === 'superadmin')
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('queues.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Antrian Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-prescription me-1"></i> Nomor Resep</label>
                        <input type="text" name="no_resep" class="form-control" required placeholder="Contoh: RSP-001">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user me-1"></i> Nama Pasien</label>
                        <input type="text" name="nama_pasien" class="form-control" required placeholder="Nama lengkap pasien">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;font-weight:600;font-size:13px;">Batal</button>
                    <button type="submit" class="btn btn-modal-primary"><i class="fas fa-save me-1"></i> Simpan Antrian</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

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
    $('#searchQueue').on('keyup', function() {
        const query = $(this).val().toLowerCase();

        $('#queueTable tbody tr[data-search]').each(function() {
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
            title: 'Hapus Antrian?',
            text: "Data antrian akan dihapus secara permanen.",
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

    // ===== CALL PATIENT WITH 20 SECOND TIMER =====
    let callTimerInterval = null;
    let callTimerSeconds = 20;

    function startCallTimer(patientName, queueNumber) {
        const overlay = document.getElementById('callTimerOverlay');
        const countdown = document.getElementById('timerCountdown');
        const progressBar = document.getElementById('timerProgressBar');
        const timerTitle = document.getElementById('timerPatientName');

        callTimerSeconds = 20;
        timerTitle.textContent = `Antrian ${queueNumber} - ${patientName}`;
        countdown.textContent = callTimerSeconds;
        progressBar.style.width = '100%';
        progressBar.style.background = 'linear-gradient(90deg, var(--success), var(--info))';
        countdown.style.color = 'var(--primary)';
        overlay.style.display = 'block';

        if (callTimerInterval) clearInterval(callTimerInterval);

        callTimerInterval = setInterval(() => {
            callTimerSeconds--;
            countdown.textContent = callTimerSeconds;
            progressBar.style.width = ((callTimerSeconds / 20) * 100) + '%';

            if (callTimerSeconds <= 5) {
                countdown.style.color = '#ef4444';
                progressBar.style.background = 'linear-gradient(90deg, #ef4444, #f59e0b)';
            }

            if (callTimerSeconds <= 0) {
                clearInterval(callTimerInterval);
                overlay.style.display = 'none';

                Swal.fire({
                    icon: 'info',
                    title: 'Panggilan Selesai',
                    text: `Waktu panggilan 20 detik untuk ${patientName} telah berakhir.`,
                    timer: 2500,
                    showConfirmButton: false
                });

                location.reload();
            }
        }, 1000);
    }

    // ===== PANGGIL BUTTON =====
    $(document).on('click', '.btn-panggil:not(:disabled)', function() {
        let queueId = $(this).data('id');
        let namaPasien = $(this).data('nama');
        let nomorAntrian = $(this).data('nomor');
        let btn = $(this);

        Swal.fire({
            title: '<i class="fas fa-bullhorn me-2"></i> Panggil Pasien?',
            html: `Memanggil antrian <strong>#${nomorAntrian}</strong><br>atas nama <strong>${namaPasien}</strong><br><small class="text-muted">Panggilan berlaku selama 20 detik</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-volume-up me-1"></i> Ya, Panggil!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memanggil...');

                $.ajax({
                    url: `/queues/${queueId}/call`,
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            let textToSpeak = `Nomor antrian, ${data.nomor}, atas nama pasien, ${data.nama}, silakan menuju ke loket, ${data.loket}.`;

                            let speech = new SpeechSynthesisUtterance(textToSpeak);
                            speech.lang = 'id-ID';
                            speech.rate = 0.85;
                            speech.pitch = 1;
                            window.speechSynthesis.speak(speech);

                            startCallTimer(namaPasien, nomorAntrian);

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: `Memanggil #${nomorAntrian}`,
                                text: namaPasien,
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true
                            });

                            btn.html('<i class="fas fa-check"></i> Dipanggil');
                        } else {
                            btn.prop('disabled', false).html('<i class="fas fa-volume-up"></i> Panggil');
                            Swal.fire({ icon: 'error', title: 'Ditolak', text: response.message });
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-volume-up"></i> Panggil');
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan pada sistem.' });
                    }
                });
            }
        });
    });
});
</script>
</body>
</html>