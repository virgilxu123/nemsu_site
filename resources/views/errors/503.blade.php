<!-- @extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable')) -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Under Maintenance | North Eastern Mindanao State University</title>

    {{-- Favicon --}}
    <link rel="icon" href="/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-navy: #08045f;
            --brand-blue: #1711d4;
            --brand-blue-hover: #0f0ab8;
            --brand-teal: #0b6680;
            --brand-maroon: #9b1c31;
            --brand-gold: #f2b705;
            --brand-gold-dark: #d49f00;
            --bg-page: #f7f8f5;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg-page: #0b0f19;
                --card-bg: #131b2e;
                --card-border: rgba(255, 255, 255, 0.08);
                --text-primary: #f8fafc;
                --text-secondary: #cbd5e1;
                --text-muted: #94a3b8;
            }
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Brand Strip */
        .top-bar {
            background-color: var(--brand-blue);
            color: #ffffff;
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
            font-weight: 500;
            letter-spacing: 0.01em;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.25rem;
            position: relative;
            overflow: hidden;
        }

        /* Background ambient glow shapes */
        .bg-glow-1 {
            position: absolute;
            top: -10%;
            left: 50%;
            transform: translateX(-50%);
            width: 700px;
            height: 450px;
            background: radial-gradient(circle, rgba(23, 17, 212, 0.09) 0%, rgba(242, 183, 5, 0.04) 50%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .bg-glow-2 {
            position: absolute;
            bottom: -5%;
            right: 10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(11, 102, 128, 0.08) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .card-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-w: 680px;
            max-width: 680px;
        }

        .maintenance-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 1.5rem;
            padding: 2.75rem 2.25rem;
            box-shadow: 0 20px 40px -15px rgba(8, 4, 95, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.02);
            text-align: center;
            backdrop-filter: blur(12px);
        }

        @media (max-width: 640px) {
            .maintenance-card {
                padding: 2rem 1.25rem;
                border-radius: 1.25rem;
            }
        }

        .logo-container {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .logo-img {
            width: 84px;
            height: 84px;
            object-fit: contain;
            border-radius: 50%;
            padding: 4px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(23, 17, 212, 0.15), 0 0 0 3px rgba(23, 17, 212, 0.08);
            transition: transform 0.3s ease;
        }

        .logo-img:hover {
            transform: scale(1.04);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.875rem;
            border-radius: 9999px;
            background: rgba(242, 183, 5, 0.15);
            border: 1px solid rgba(242, 183, 5, 0.35);
            color: #926200;
            font-size: 0.8125rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }

        @media (prefers-color-scheme: dark) {
            .status-badge {
                background: rgba(242, 183, 5, 0.12);
                color: #fbbf24;
                border-color: rgba(242, 183, 5, 0.3);
            }
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: var(--brand-gold);
            border-radius: 50%;
            position: relative;
        }

        .status-dot::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background-color: var(--brand-gold);
            opacity: 0.5;
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse-ring {
            0%, 100% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(2.2);
                opacity: 0;
            }
        }

        .univ-title {
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--brand-blue);
            margin-bottom: 0.35rem;
        }

        @media (prefers-color-scheme: dark) {
            .univ-title {
                color: #93c5fd;
            }
        }

        .headline {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1.2;
            color: var(--text-primary);
            letter-spacing: -0.025em;
            margin-bottom: 0.875rem;
        }

        @media (max-width: 640px) {
            .headline {
                font-size: 1.625rem;
            }
        }

        .description {
            font-size: 1rem;
            color: var(--text-secondary);
            max-width: 540px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        /* Information Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
            text-align: left;
        }

        @media (max-width: 580px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        .info-item {
            background-color: rgba(23, 17, 212, 0.03);
            border: 1px solid rgba(23, 17, 212, 0.08);
            border-radius: 0.875rem;
            padding: 1.125rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        @media (prefers-color-scheme: dark) {
            .info-item {
                background-color: rgba(255, 255, 255, 0.03);
                border-color: rgba(255, 255, 255, 0.06);
            }
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
        }

        .info-value {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .info-subtext {
            font-size: 0.8125rem;
            color: var(--text-secondary);
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.875rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background-color: var(--brand-blue);
            color: #ffffff;
            font-size: 0.9375rem;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.625rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(23, 17, 212, 0.25);
        }

        .btn-primary:hover {
            background-color: var(--brand-blue-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(23, 17, 212, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background-color: transparent;
            color: var(--text-primary);
            font-size: 0.9375rem;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.625rem;
            text-decoration: none;
            border: 1px solid var(--card-border);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background-color: rgba(0, 0, 0, 0.04);
            border-color: rgba(0, 0, 0, 0.15);
        }

        @media (prefers-color-scheme: dark) {
            .btn-secondary:hover {
                background-color: rgba(255, 255, 255, 0.06);
                border-color: rgba(255, 255, 255, 0.15);
            }
        }

        /* Footer */
        .footer {
            padding: 1.5rem 1rem;
            text-align: center;
            font-size: 0.8125rem;
            color: var(--text-muted);
            border-top: 1px solid var(--card-border);
            background-color: var(--card-bg);
        }

        .footer a {
            color: var(--brand-blue);
            text-decoration: none;
        }

        @media (prefers-color-scheme: dark) {
            .footer a {
                color: #93c5fd;
            }
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Rotating animation on reload icon */
        .spin-on-click.is-refreshing svg {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    {{-- Header Bar --}}
    <div class="top-bar">
        <span>North Eastern Mindanao State University &bull; Walk a Journey of Excellence and Success</span>
    </div>

    {{-- Main Container --}}
    <main class="main-container">
        <div class="bg-glow-1"></div>
        <div class="bg-glow-2"></div>

        <div class="card-wrapper">
            <div class="maintenance-card">
                {{-- University Logo --}}
                <div class="logo-container">
                    <img
                        src="/storage/images/branding/logos/nemsu-logo.png"
                        onerror="this.onerror=null; this.src='/favicon.png';"
                        alt="NEMSU Seal"
                        class="logo-img"
                    >
                </div>

                {{-- Status Badge --}}
                <div>
                    <div class="status-badge">
                        <span class="status-dot"></span>
                        <span>System Maintenance</span>
                    </div>
                </div>

                {{-- Headings --}}
                <div class="univ-title">North Eastern Mindanao State University</div>
                <h1 class="headline">We're Upgrading Our Website</h1>

                <p class="description">
                    The NEMSU website is temporarily undergoing scheduled maintenance and updates. We will be back online shortly.
                </p>

                {{-- Info Boxes --}}
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Current Status</span>
                        <span class="info-value">Maintenance in Progress</span>
                        <span class="info-subtext">Core systems being updated</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Urgent Concerns</span>
                        <span class="info-value">ict@nemsu.edu.ph</span>
                        <span class="info-subtext">MIS &amp; ICT Support Office</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="action-group">
                    <button type="button" class="btn-primary spin-on-click" id="refreshBtn" onclick="refreshPage()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                            <path d="M3 3v5h5"/>
                            <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                            <path d="M16 21h5v-5"/>
                        </svg>
                        <span>Check Again</span>
                    </button>
                </div>

                <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.75rem;">
                    Auto-checking for status restoration in <span id="countdown" style="font-weight: 700; color: var(--brand-blue);">30</span>s
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div>
            &copy; {{ date('Y') }} <strong>North Eastern Mindanao State University</strong> (NEMSU). All Rights Reserved.
        </div>
    </footer>

    <script>
        let timeLeft = 30;
        const countdownEl = document.getElementById('countdown');
        const refreshBtn = document.getElementById('refreshBtn');

        function refreshPage() {
            refreshBtn.classList.add('is-refreshing');
            setTimeout(function() {
                window.location.reload();
            }, 300);
        }

        setInterval(function() {
            timeLeft--;
            if (countdownEl) {
                countdownEl.textContent = timeLeft;
            }
            if (timeLeft <= 0) {
                refreshPage();
            }
        }, 1000);
    </script>
</body>
</html>