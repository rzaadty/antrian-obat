<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layar Antrian Obat - QueuePro</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #334155;
            min-height: 100vh;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(79, 70, 229, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(16, 185, 129, 0.05) 0%, transparent 40%);
        }

        /* ===== NAVBAR ===== */
        .top-navbar {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            padding: 18px 0;
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.25);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .top-navbar::before {
            content: '';
            position: absolute;
            top: -50%; right: -10%;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .brand-wrapper {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 2;
        }

        .brand-logo {
            width: 52px; height: 52px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }

        .brand-text h1 {
            font-size: 22px; font-weight: 800;
            margin: 0; line-height: 1.1;
            letter-spacing: -0.3px;
        }

        .brand-text small {
            font-size: 12px;
            opacity: 0.85;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .datetime-wrapper {
            text-align: right;
            position: relative;
            z-index: 2;
        }

        .live-clock {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 1px;
            font-variant-numeric: tabular-nums;
            line-height: 1;
            text-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }

        .live-date {
            font-size: 13px;
            font-weight: 500;
            opacity: 0.9;
            margin-top: 4px;
            letter-spacing: 0.3px;
        }

        /* ===== REFRESH INDICATOR ===== */
        .refresh-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid var(--border);
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            pointer-events: none;
        }

        .refresh-indicator.show {
            opacity: 1;
            transform: translateY(0);
        }

        .refresh-indicator .spinner {
            width: 12px;
            height: 12px;
            border: 2px solid rgba(79, 70, 229, 0.2);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== CURRENT QUEUE HERO ===== */
        .current-queue-hero {
            background: #fff;
            border-radius: 20px;
            padding: 28px 32px;
            margin-top: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 24px;
            position: relative;
            overflow: hidden;
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .current-queue-hero.updating {
            opacity: 0.5;
            transform: scale(0.99);
        }

        .current-queue-hero::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 6px;
            background: linear-gradient(180deg, var(--success), var(--info));
        }

        .cq-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, var(--success), #059669);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 30px;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
            animation: pulse-icon 2s infinite;
        }

        @keyframes pulse-icon {
            0%, 100% { box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }
            50% { box-shadow: 0 8px 30px rgba(16, 185, 129, 0.6); }
        }

        .cq-content { flex: 1; }

        .cq-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 4px;
        }

        .cq-number {
            font-size: 56px;
            font-weight: 900;
            color: var(--primary);
            line-height: 1;
            letter-spacing: -1px;
            font-variant-numeric: tabular-nums;
            transition: all 0.4s ease;
        }

        .cq-name {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            transition: all 0.4s ease;
        }

        .cq-empty {
            font-size: 28px;
            font-weight: 700;
            color: var(--gray);
        }

        .cq-empty-sub {
            font-size: 14px;
            color: var(--gray);
            margin-top: 4px;
        }

        /* ===== QUEUE TABLE CARD ===== */
        .queue-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
            margin-top: 20px;
        }

        .queue-card-header {
            padding: 20px 28px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #fafbff 0%, #f8fafc 100%);
        }

        .queue-card-header h5 {
            font-size: 17px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .queue-card-header h5 i {
            color: var(--primary);
            font-size: 18px;
        }

        .live-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: #fef3c7;
            color: #92400e;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .live-indicator.syncing {
            background: #eef2ff;
            color: var(--primary);
        }

        .live-dot {
            width: 8px; height: 8px;
            background: var(--warning);
            border-radius: 50%;
            animation: pulse-dot 1.5s infinite;
        }

        .live-indicator.syncing .live-dot {
            background: var(--primary);
            animation: spin 0.8s linear infinite;
            border: 2px solid transparent;
            border-top-color: var(--primary);
            border-right-color: var(--primary);
            width: 12px;
            height: 12px;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.4); }
        }

        /* ===== TABLE ===== */
        .queue-table {
            width: 100%;
            border-collapse: collapse;
        }

        .queue-table thead th {
            background: #f8fafc;
            padding: 16px 24px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray);
            border-bottom: 2px solid var(--border);
            text-align: center;
        }

        .queue-table tbody {
            transition: opacity 0.4s ease;
        }

        .queue-table tbody.updating {
            opacity: 0.4;
        }

        .queue-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s, opacity 0.4s ease, transform 0.4s ease;
        }

        .queue-table tbody tr:hover {
            background: #fafbff;
        }

        .queue-table tbody tr:last-child {
            border-bottom: none;
        }

        .queue-table tbody tr.new-row {
            animation: slideInRow 0.5s ease;
        }

        @keyframes slideInRow {
            from {
                opacity: 0;
                transform: translateX(-20px);
                background: #eef2ff;
            }
            to {
                opacity: 1;
                transform: translateX(0);
                background: transparent;
            }
        }

        .queue-table tbody tr.updated-row {
            animation: highlightRow 1s ease;
        }

        @keyframes highlightRow {
            0%, 100% { background: transparent; }
            30% { background: #fef3c7; }
        }

        .queue-table td {
            padding: 20px 24px;
            vertical-align: middle;
            text-align: center;
        }

        .queue-number-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 90px;
            height: 70px;
            padding: 0 20px;
            border-radius: 16px;
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            color: var(--primary);
            font-weight: 900;
            font-size: 32px;
            letter-spacing: 1px;
            font-variant-numeric: tabular-nums;
            border: 2px solid rgba(79, 70, 229, 0.1);
            transition: all 0.4s ease;
        }

        .patient-name {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .patient-resep {
            font-size: 13px;
            color: var(--gray);
            margin-top: 4px;
            font-weight: 500;
        }

        .patient-resep i {
            margin-right: 4px;
            color: var(--primary-light);
        }

        /* ===== STATUS BADGE ===== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 30px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.3px;
            transition: all 0.4s ease;
        }

        .status-badge .dot {
            width: 10px; height: 10px;
            border-radius: 50%;
        }

        .status-menunggu {
            background: #fef3c7;
            color: #92400e;
        }
        .status-menunggu .dot {
            background: var(--warning);
        }

        .status-dipanggil {
            background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
            color: #155e75;
            animation: blinker 1.5s ease-in-out infinite;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.25);
        }
        .status-dipanggil .dot {
            background: var(--info);
            animation: pulse-dot 1.2s infinite;
        }

        .status-selesai {
            background: #d1fae5;
            color: #065f46;
        }
        .status-selesai .dot {
            background: var(--success);
        }

        @keyframes blinker {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.75; transform: scale(1.03); }
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-state-icon {
            width: 100px; height: 100px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            font-size: 42px;
            color: var(--gray);
        }

        .empty-state h6 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--gray);
            margin: 0;
        }

        /* ===== FOOTER ===== */
        .page-footer {
            text-align: center;
            padding: 24px 0 32px;
            color: var(--gray);
            font-size: 13px;
        }

        .page-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .page-footer a:hover {
            color: var(--primary-dark);
            gap: 10px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .brand-text h1 { font-size: 17px; }
            .live-clock { font-size: 22px; }
            .cq-number { font-size: 40px; }
            .cq-name { font-size: 16px; }
            .patient-name { font-size: 16px; }
            .queue-number-box { font-size: 24px; min-width: 70px; height: 55px; }
            .queue-table td, .queue-table thead th { padding: 12px; }
            .cq-icon { width: 56px; height: 56px; font-size: 24px; }
            .current-queue-hero { padding: 20px; gap: 16px; }
            .refresh-indicator { top: 10px; right: 10px; font-size: 10px; padding: 6px 10px; }
        }

        /* ===== FADE IN ANIMATION ===== */
        .fade-in {
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body>

    <!-- ===== REFRESH INDICATOR ===== -->
    <div id="refreshIndicator">
    </div>

    <!-- ===== NAVBAR ===== -->
    <nav class="top-navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="brand-wrapper">
                    <div class="brand-logo">
                        <i class="fas fa-prescription-bottle-medical"></i>
                    </div>
                    <div class="brand-text">
                        <h1>Layar Antrian Obat</h1>
                        <small><i class="fas fa-hospital me-1"></i> QueuePro - Sistem Antrian Digital</small>
                    </div>
                </div>

                <div class="datetime-wrapper">
                    <div class="live-clock" id="liveClock">--:--:--</div>
                    <div class="live-date" id="liveDate">Memuat tanggal...</div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-4">

        @php
            $currentQueue = $queues->where('status', 'dipanggil')->first();
        @endphp

        <!-- ===== CURRENT QUEUE HERO ===== -->
        <div class="current-queue-hero fade-in" id="currentQueueHero">
            @if($currentQueue)
                <div class="cq-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="cq-content">
                    <div class="cq-label">
                        <i class="fas fa-circle-dot me-1" style="color: var(--success);"></i>
                        Sedang Dilayani - Nomor Antrian
                    </div>
                    <div class="cq-number">
                        {{ str_pad($currentQueue->queue_number, 3, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="cq-name">
                        <i class="fas fa-user-injured me-2" style="color: var(--primary-light); font-size: 18px;"></i>
                        {{ $currentQueue->nama_pasien }}
                    </div>
                </div>
            @else
                <div class="cq-icon" style="background: linear-gradient(135deg, #94a3b8, #64748b); animation: none;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="cq-content">
                    <div class="cq-label">Status Saat Ini</div>
                    <div class="cq-empty">Belum Ada Panggilan</div>
                    <div class="cq-empty-sub">Mohon tunggu, nomor antrian Anda akan segera dipanggil</div>
                </div>
            @endif
        </div>

        <!-- ===== QUEUE TABLE ===== -->
        <div class="queue-card fade-in">
            <div class="queue-card-header">
                <h5>
                    <i class="fas fa-list-check"></i>
                    Daftar Antrian Hari Ini
                </h5>
                <div class="live-indicator" id="liveIndicator">
                    <span class="live-dot"></span>
                    <span id="liveIndicatorText">Live Update</span>
                </div>
            </div>

            <table class="queue-table">
                <thead>
                    <tr>
                        <th width="20%">No. Antrian</th>
                        <th width="50%">Nama Pasien</th>
                        <th width="30%">Status</th>
                    </tr>
                </thead>
                <tbody id="queueTableBody">
                    @forelse($queues as $q)
                    <tr data-id="{{ $q->id }}" data-status="{{ $q->status }}">
                        <td>
                            <div class="queue-number-box">
                                {{ str_pad($q->queue_number, 3, '0', STR_PAD_LEFT) }}
                            </div>
                        </td>
                        <td>
                            <div class="patient-name">{{ $q->nama_pasien }}</div>
                        </td>
                        <td>
                            @if($q->status == 'menunggu')
                                <span class="status-badge status-menunggu">
                                    <span class="dot"></span>
                                    Menunggu
                                </span>
                            @elseif($q->status == 'dipanggil')
                                <span class="status-badge status-dipanggil">
                                    <span class="dot"></span>
                                    Menuju Loket
                                </span>
                            @else
                                <span class="status-badge status-selesai">
                                    <span class="dot"></span>
                                    Selesai
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h6>Belum Ada Antrian</h6>
                                <p>Belum ada data antrian obat untuk hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ===== FOOTER ===== -->
        <div class="page-footer">
            <a href="{{ route('login') }}">
                <i class="fas fa-lock"></i>
                Login Pegawai
                <i class="fas fa-arrow-right"></i>
            </a>
            <div class="mt-2" style="font-size: 11px; opacity: 0.7;">
                © {{ date('Y') }} QueuePro - Sistem Antrian Digital
            </div>
        </div>

    </div>

    <script>
        // ===== LIVE CLOCK & DATE (TIDAK TERGANGGU REFRESH) =====
        function updateDateTime() {
            var now = new Date();
            
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            document.getElementById('liveClock').textContent = hours + ':' + minutes + ':' + seconds;
            
            var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                         'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            var dayName = days[now.getDay()];
            var date = now.getDate();
            var monthName = months[now.getMonth()];
            var year = now.getFullYear();
            
            document.getElementById('liveDate').textContent = dayName + ', ' + date + ' ' + monthName + ' ' + year;
        }
        
        setInterval(updateDateTime, 1000);
        updateDateTime();

        // ===== SMOOTH AJAX REFRESH =====
        let errorCount = 0;
        const MAX_ERRORS = 3;

        function showRefreshIndicator(show) {
            const indicator = document.getElementById('refreshIndicator');
            const liveIndicator = document.getElementById('liveIndicator');
            const liveText = document.getElementById('liveIndicatorText');
            
            if (show) {
                indicator.classList.add('show');
                liveIndicator.classList.add('syncing');
                liveText.textContent = 'Syncing...';
            } else {
                indicator.classList.remove('show');
                liveIndicator.classList.remove('syncing');
                liveText.textContent = 'Live Update';
            }
        }

        function buildStatusBadge(status) {
            if (status === 'menunggu') {
                return `<span class="status-badge status-menunggu">
                            <span class="dot"></span> Menunggu
                        </span>`;
            } else if (status === 'dipanggil') {
                return `<span class="status-badge status-dipanggil">
                            <span class="dot"></span> Menuju Loket
                        </span>`;
            } else {
                return `<span class="status-badge status-selesai">
                            <span class="dot"></span> Selesai
                        </span>`;
            }
        }

        function refreshData() {
            showRefreshIndicator(true);

            fetch(window.location.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                // Parse HTML response
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Extract current queue hero
                const newHero = doc.getElementById('currentQueueHero');
                const currentHero = document.getElementById('currentQueueHero');
                
                if (newHero && currentHero) {
                    // Only update if content actually changed
                    if (newHero.innerHTML.trim() !== currentHero.innerHTML.trim()) {
                        currentHero.classList.add('updating');
                        setTimeout(() => {
                            currentHero.innerHTML = newHero.innerHTML;
                            currentHero.classList.remove('updating');
                        }, 300);
                    }
                }

                // Extract table body
                const newTbody = doc.getElementById('queueTableBody');
                const currentTbody = document.getElementById('queueTableBody');

                if (newTbody && currentTbody) {
                    const newRows = newTbody.querySelectorAll('tr[data-id]');
                    const currentRows = currentTbody.querySelectorAll('tr[data-id]');

                    // Build map of current rows by ID
                    const currentMap = {};
                    currentRows.forEach(row => {
                        currentMap[row.dataset.id] = row;
                    });

                    // Build set of new IDs
                    const newIds = new Set();
                    newRows.forEach(row => newIds.add(row.dataset.id));

                    // Remove rows that no longer exist
                    currentRows.forEach(row => {
                        if (!newIds.has(row.dataset.id)) {
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(20px)';
                            setTimeout(() => row.remove(), 400);
                        }
                    });

                    // Update existing or add new rows
                    newRows.forEach((newRow, index) => {
                        const id = newRow.dataset.id;
                        const existingRow = currentMap[id];

                        if (existingRow) {
                            // Check if status changed
                            const oldStatus = existingRow.dataset.status;
                            const newStatus = newRow.dataset.status;

                            if (oldStatus !== newStatus) {
                                // Update status badge with animation
                                existingRow.dataset.status = newStatus;
                                const statusCell = existingRow.querySelector('td:last-child');
                                if (statusCell) {
                                    statusCell.innerHTML = newRow.querySelector('td:last-child').innerHTML;
                                    existingRow.classList.add('updated-row');
                                    setTimeout(() => existingRow.classList.remove('updated-row'), 1000);
                                }
                            }
                        } else {
                            // New row - add with animation
                            newRow.classList.add('new-row');
                            // If empty state exists, remove it
                            const emptyRow = currentTbody.querySelector('tr:not([data-id])');
                            if (emptyRow) emptyRow.remove();
                            currentTbody.appendChild(newRow);
                        }
                    });

                    // If no rows and not empty, show empty state
                    if (newRows.length === 0 && currentTbody.querySelectorAll('tr[data-id]').length === 0) {
                        const emptyState = newTbody.querySelector('.empty-state');
                        if (emptyState && !currentTbody.querySelector('.empty-state')) {
                            currentTbody.innerHTML = `<tr><td colspan="3">${emptyState.parentElement.innerHTML}</td></tr>`;
                        }
                    }
                }

                errorCount = 0;
                showRefreshIndicator(false);
            })
            .catch(error => {
                console.error('Refresh error:', error);
                errorCount++;
                showRefreshIndicator(false);

                // Fallback: jika error berkali-kali, reload halaman
                if (errorCount >= MAX_ERRORS) {
                    console.warn('Terlalu banyak error, melakukan reload halaman...');
                    window.location.reload();
                }
            });
        }

        // ===== AUTO REFRESH SETIAP 5 DETIK (TANPA FLICKER) =====
        setInterval(refreshData, 5000);

        // ===== REFRESH PERTAMA SETELAH 2 DETIK =====
        setTimeout(refreshData, 2000);
    </script>
</body>
</html>