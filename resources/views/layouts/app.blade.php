<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Digital Flow - Monitoring Alur berkas KPR')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #00529C;
            --primary-dark: #003B73;
            --accent-orange: #FF6600;
            --bg-light: #F4F6F9;
            --card-bg: #FFFFFF;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --radius-md: 10px;
            --radius-lg: 16px;
            --shadow-sm: 0 2px 8px rgba(0, 82, 156, 0.06);
            --shadow-md: 0 6px 18px rgba(0, 82, 156, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* HEADER & NAVBAR */
        .app-header {
            background: linear-gradient(135deg, #00529C 0%, #003B73 100%);
            color: white;
            padding: 0.85rem 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 59, 115, 0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-group {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .brand-logo-badge {
            background: #FFFFFF;
            color: #00529C;
            font-weight: 900;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-size: 1.15rem;
            letter-spacing: 0.04em;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .brand-title-group h1 {
            font-size: 1.15rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .brand-title-group p {
            font-size: 0.75rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 0.4rem 0.85rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .user-role-tag {
            background: var(--accent-orange);
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 0.15rem 0.45rem;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .user-name {
            font-size: 0.8rem;
            font-weight: 700;
        }

        .btn-header-action {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 0.45rem 0.85rem;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .btn-header-action:hover {
            background: white;
            color: var(--primary-dark);
        }

        /* MAIN CONTAINER */
        .main-container {
            max-width: 1400px;
            width: 100%;
            margin: 1.5rem auto;
            padding: 0 1.5rem;
            flex: 1;
        }

        /* GLASS CARD */
        .glass-card {
            background: #FFFFFF;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 1.25rem;
        }

        /* FLOATING TOAST NOTIFICATION POPUP */
        .toast-container {
            position: fixed;
            top: 80px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-width: 400px;
            width: calc(100% - 48px);
            pointer-events: none;
        }

        .toast-card {
            pointer-events: auto;
            background: #FFFFFF;
            border-radius: 14px;
            padding: 1rem 1.25rem;
            box-shadow: 0 12px 30px rgba(0, 59, 115, 0.18);
            border-left: 5px solid #00529C;
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            animation: slideInRight 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            transition: all 0.3s ease;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(120%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .toast-card.toast-fadeOut {
            transform: translateX(120%);
            opacity: 0;
        }

        .toast-icon {
            font-size: 1.35rem;
            line-height: 1;
            margin-top: 0.1rem;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-size: 0.85rem;
            font-weight: 800;
            margin-bottom: 0.2rem;
        }

        .toast-message {
            font-size: 0.78rem;
            color: #334155;
            line-height: 1.4;
        }

        .toast-close {
            background: transparent;
            border: none;
            color: #94A3B8;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            padding: 0.1rem;
            line-height: 1;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: #0F172A;
        }

        .toast-success {
            border-left-color: #10B981;
            background: #F0FDF4;
        }
        .toast-success .toast-title { color: #065F46; }

        .toast-error {
            border-left-color: #EF4444;
            background: #FEF2F2;
        }
        .toast-error .toast-title { color: #991B1B; }

        .toast-info {
            border-left-color: #00529C;
            background: #EFF6FF;
        }
        .toast-info .toast-title { color: #1E40AF; }

        /* FOOTER */
        .app-footer {
            text-align: center;
            padding: 1.25rem;
            font-size: 0.75rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            margin-top: auto;
            background: #FFFFFF;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
            .header-right {
                width: 100%;
                justify-content: space-between;
            }
            .toast-container {
                top: auto;
                bottom: 24px;
                right: 16px;
                left: 16px;
                max-width: none;
                width: auto;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- APP HEADER -->
    @auth
    <header class="app-header">
        <div class="header-content">
            <div class="brand-group">
                <div class="brand-logo-badge">DFlow</div>
                <div class="brand-title-group">
                    <h1>Digital Flow</h1>
                    <p>Monitoring Alur berkas KPR</p>
                </div>
            </div>

            <div class="header-right">
                <div class="user-badge">
                    <span class="user-role-tag">{{ Auth::user()->role }}</span>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                </div>

                @if(Auth::user()->role === 'Super Admin')
                <button type="button" class="btn-header-action" onclick="document.getElementById('registerUserModal').style.display='flex'">
                    + Akun Pegawai
                </button>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-header-action" style="background: rgba(239,68,68,0.25); border-color: rgba(239,68,68,0.3);">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>
    @endauth

    <!-- FLOATING TOAST NOTIFICATION CONTAINER -->
    <div class="toast-container" id="toastContainer">
        @if(session('success'))
            <div class="toast-card toast-success" id="toastNotice">
                <div class="toast-icon">✅</div>
                <div class="toast-content">
                    <div class="toast-title">Pemberitahuan Berhasil</div>
                    <div class="toast-message">{{ session('success') }}</div>
                </div>
                <button class="toast-close" onclick="dismissToast(this.parentElement)">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="toast-card toast-error" id="toastNotice">
                <div class="toast-icon">⚠️</div>
                <div class="toast-content">
                    <div class="toast-title">Perhatian / Akses Ditolak</div>
                    <div class="toast-message">{{ session('error') }}</div>
                </div>
                <button class="toast-close" onclick="dismissToast(this.parentElement)">✕</button>
            </div>
        @endif

        @if(session('info'))
            <div class="toast-card toast-info" id="toastNotice">
                <div class="toast-icon">ℹ️</div>
                <div class="toast-content">
                    <div class="toast-title">Informasi Sistem</div>
                    <div class="toast-message">{{ session('info') }}</div>
                </div>
                <button class="toast-close" onclick="dismissToast(this.parentElement)">✕</button>
            </div>
        @endif
    </div>

    <!-- MAIN CONTENT -->
    <main class="main-container">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="app-footer">
        <p>Digital Flow &copy; 2026 PT. Bank Rakyat Indonesia (Persero) Tbk. Monitoring Alur berkas KPR.</p>
    </footer>

    <script>
    function dismissToast(toastEl) {
        if (!toastEl) return;
        toastEl.classList.add('toast-fadeOut');
        setTimeout(() => {
            toastEl.remove();
        }, 300);
    }

    // Auto-dismiss toast notification after 6 seconds
    document.addEventListener('DOMContentLoaded', () => {
        const toasts = document.querySelectorAll('.toast-card');
        toasts.forEach(toast => {
            setTimeout(() => {
                dismissToast(toast);
            }, 6000);
        });
    });
    </script>

    @yield('scripts')
</body>
</html>
