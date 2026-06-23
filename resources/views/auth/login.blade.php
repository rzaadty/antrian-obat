<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pegawai - QueuePro</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --primary-dark: #3730a3;
            --success: #10b981;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --border: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #f1f5f9;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
            background-image:
                radial-gradient(circle at 15% 30%, rgba(79, 70, 229, 0.08) 0%, transparent 45%),
                radial-gradient(circle at 85% 70%, rgba(16, 185, 129, 0.06) 0%, transparent 45%);
        }

        /* ===== LOGIN CARD ===== */
        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.08);
            border: 1px solid var(--border);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== HEADER BRANDING ===== */
        .login-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            color: #fff;
            padding: 32px 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
            border-radius: 50%;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -100px;
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .brand-icon {
            width: 60px; height: 60px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 14px;
            position: relative;
            z-index: 2;
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }

        .login-header h2 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 4px;
            position: relative;
            z-index: 2;
            letter-spacing: -0.3px;
        }

        .login-header p {
            font-size: 13px;
            opacity: 0.9;
            margin: 0;
            position: relative;
            z-index: 2;
            font-weight: 500;
        }

        /* ===== FORM BODY ===== */
        .login-body {
            padding: 32px 28px;
        }

        .login-body h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 4px;
            text-align: center;
        }

        .login-body .welcome-text {
            font-size: 13px;
            color: var(--gray);
            text-align: center;
            margin-bottom: 24px;
        }

        /* ===== FORM GROUP ===== */
        .form-group-custom {
            margin-bottom: 18px;
        }

        .form-group-custom label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .form-group-custom label i {
            color: var(--primary);
            font-size: 12px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 14px;
            transition: color 0.2s;
            pointer-events: none;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: var(--dark);
            background: var(--light);
            transition: all 0.2s;
            font-family: inherit;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .input-wrapper input:focus ~ .input-icon {
            color: var(--primary);
        }

        .input-wrapper input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        /* ===== SUBMIT BUTTON ===== */
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.3);
            margin-top: 6px;
            font-family: inherit;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(79, 70, 229, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* ===== FOOTER ===== */
        .login-footer {
            text-align: center;
            padding: 16px 28px 24px;
            border-top: 1px solid var(--border);
            background: #fafbff;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .login-footer a:hover {
            color: var(--primary-dark);
            gap: 10px;
        }

        .copyright {
            font-size: 11px;
            color: var(--gray);
            margin-top: 10px;
            opacity: 0.8;
        }

        /* ===== ERROR ALERT ===== */
        .error-alert {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-alert i {
            font-size: 15px;
            flex-shrink: 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            body { padding: 0; align-items: stretch; }
            .login-card {
                max-width: 100%;
                border-radius: 0;
                min-height: 100vh;
                box-shadow: none;
                border: none;
            }
            .login-header { padding: 28px 20px; }
            .login-body { padding: 28px 20px; }
            .login-header h2 { font-size: 20px; }
        }
    </style>
</head>
<body>

    <div class="login-card">

        <!-- ===== HEADER BRANDING ===== -->
        <div class="login-header">
            <div class="brand-icon">
                <i class="fas fa-hospital"></i>
            </div>
            <h2>QueuePro</h2>
            <p>Sistem Antrian Digital</p>
        </div>

        <!-- ===== FORM BODY ===== -->
        <div class="login-body">
            <h3>Login Pegawai</h3>
            <p class="welcome-text">Masuk untuk mengelola antrian</p>

            {{-- ERROR MESSAGE --}}
            @if($errors->any())
                <div class="error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf

                <div class="form-group-custom">
                    <label for="username">
                        <i class="fas fa-user"></i>
                        Username
                    </label>
                    <div class="input-wrapper">
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Masukkan username"
                            required
                            autofocus>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required>
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
            </form>
        </div>

        <!-- ===== FOOTER ===== -->
        <div class="login-footer">
            <a href="{{ route('home') }}">
                <i class="fas fa-tv"></i>
                Kembali ke Layar Antrian
                <i class="fas fa-arrow-right"></i>
            </a>
            <div class="copyright">
                © {{ date('Y') }} QueuePro - Sistem Antrian Digital
            </div>
        </div>

    </div>

</body>
</html>