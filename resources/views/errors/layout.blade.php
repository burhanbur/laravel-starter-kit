<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #6366f1;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --success-color: #10b981;
            --dark-color: #1f2937;
            --gray-color: #6b7280;
            --light-gray: #f3f4f6;
            --border-color: #e5e7eb;
            /* semantic tokens */
            --bg-color: #f3f4f6;
            --surface-color: #ffffff;
            --text-color: var(--dark-color);
            --muted-color: var(--gray-color);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--bg-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text-color);
        }

        .error-container {
            max-width: 900px;
            width: 100%;
            background: var(--surface-color);
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(16, 24, 40, 0.12);
            overflow: hidden;
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-header {
            background: var(--primary-color);
            padding: 40px;
            text-align: center;
            color: white;
        }

        .error-code {
            font-size: 120px;
            font-weight: 900;
            line-height: 1;
            text-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .error-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .error-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .error-body {
            padding: 40px;
        }

        .error-message {
            font-size: 18px;
            color: var(--muted-color);
            margin-bottom: 30px;
            line-height: 1.6;
            text-align: center;
        }

        .error-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
            font-size: 15px;
        }

        .btn-primary {
            background: var(--text-color);
            color: var(--surface-color);
        }

        .btn-primary:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(16,24,40,0.08);
        }

        .btn-secondary {
            background: var(--surface-color);
            color: var(--muted-color);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: color-mix(in srgb, var(--surface-color) 93%, black 7%);
            transform: translateY(-2px);
        }

        .error-details {
            background: var(--surface-color);
            border-radius: 10px;
            padding: 18px;
            margin-top: 18px;
            border: 1px solid var(--border-color);
        }

        .error-details-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .error-details-content {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: var(--muted-color);
            background: var(--surface-color);
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            max-height: 300px;
            overflow-y: auto;
            border: 1px dashed var(--border-color);
        }

        .error-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            background: var(--surface-color);
            padding: 14px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .info-label {
            font-size: 12px;
            color: var(--muted-color);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 14px;
            color: var(--text-color);
            font-weight: 500;
            word-break: break-word;
            max-width: 100%;
        }

        /* Request id should be monospace and easier to copy */
        #request-id {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: var(--text-color);
            word-break: break-all;
            line-height: 1.35;
        }

        .copy-btn {
            padding: 6px 10px;
            border-radius: 8px;
            background: var(--text-color);
            color: var(--surface-color);
            font-weight: 600;
            font-size: 13px;
            border: none;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(16,24,40,0.06);
        }

        .copy-btn:active { transform: translateY(1px); }

        #copy-feedback { margin-left: 8px; min-width:64px; display:inline-block; }

        .error-footer {
            text-align: center;
            padding: 20px;
            background: var(--surface-color);
            font-size: 14px;
            color: var(--muted-color);
            border-top: 1px solid var(--border-color);
        }

        .suggestions {
            background: color-mix(in srgb, var(--surface-color) 96%, #fef3c7 4%);
            border-left: 4px solid var(--warning-color);
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .suggestions-title {
            font-weight: 600;
            color: var(--warning-color);
            margin-bottom: 10px;
            font-size: 15px;
        }

        .suggestions ul {
            list-style: none;
            padding-left: 0;
        }

        .suggestions li {
            padding: 5px 0;
            color: var(--muted-color);
            font-size: 14px;
        }

        .suggestions li:before {
            content: "→ ";
            font-weight: bold;
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 80px;
            }

            .error-title {
                font-size: 22px;
            }

            .error-header, .error-body {
                padding: 30px 20px;
            }

            .error-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Dark mode tokens similar to welcome.blade.php */
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-color: #0a0a0a;
                --surface-color: #161615;
                --text-color: #EDEDEC;
                --muted-color: #A1A09A;
                --border-color: #3E3E3A;
            }
        }

        /* explicit theme override via data-theme attribute (localStorage) */
        :root[data-theme='dark'] {
            --bg-color: #0a0a0a;
            --surface-color: #161615;
            --text-color: #EDEDEC;
            --muted-color: #A1A09A;
            --border-color: #3E3E3A;
        }

        :root[data-theme='light'] {
            --bg-color: #FDFDFC;
            --surface-color: #ffffff;
            --text-color: #1b1b18;
            --muted-color: #706f6c;
            --border-color: #e3e3e0;
        }

        /* Icon styles */
        .icon {
            display: inline-block;
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-header">
            <div class="error-code">@yield('code')</div>
            <div class="error-title">@yield('title')</div>
            <div class="error-subtitle">@yield('subtitle')</div>
        </div>

        <div class="error-body">
            <div class="error-message">
                @yield('message')
            </div>

            @hasSection('suggestions')
            <div class="suggestions">
                <div class="suggestions-title">💡 Saran</div>
                @yield('suggestions')
            </div>
            @endif

            <div class="error-actions">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Home
                </a>
                <a onclick="history.back()" class="btn btn-secondary">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Halaman Sebelumnya
                </a>
            </div>

            @if(config('app.debug'))
            <div class="error-details">
                <div class="error-details-title">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Debug (Development Mode)
                </div>
                <div class="error-info-grid">
                    <div class="info-item">
                        <div style="flex:1; min-width:0;">
                            <div class="info-label">Request ID</div>
                            <div class="info-value" id="request-id">{{ (string) Str::uuid() }}</div>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <button type="button" id="copy-request-id" class="copy-btn" onclick="copyToClipboard('request-id')" aria-label="Copy Request ID">Copy</button>
                            <span id="copy-feedback" style="font-size:13px;color:var(--success-color);display:none;" aria-live="polite"></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div style="flex:1; min-width:0;">
                            <div class="info-label">Timestamp</div>
                            <div class="info-value">{{ now()->format('Y-m-d H:i:s') }}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div style="flex:1; min-width:0;">
                            <div class="info-label">URL</div>
                            <div class="info-value">{{ url()->current() }}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div style="flex:1; min-width:0;">
                            <div class="info-label">Method</div>
                            <div class="info-value">{{ request()->method() }}</div>
                        </div>
                    </div>
                </div>
                @hasSection('debug')
                <div class="error-details-content">
                    @yield('debug')
                </div>
                @endif
            </div>
            @endif

            @yield('extra')
        </div>

        <div class="error-footer">
            © {{ date('Y') }} {{ config('app.name', 'Laravel Starter Kit') }}
        </div>
    </div>

<script>
    (function(){
        try {
            var saved = null;
            try { saved = localStorage.getItem('theme'); } catch(e){}
            var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            var useDark = saved === 'dark' || (saved === null && prefersDark);
            if (useDark) document.documentElement.setAttribute('data-theme', 'dark');
            else document.documentElement.setAttribute('data-theme', 'light');

            // helper to allow toggling from other pages if needed
            window.setTheme = function(theme){
                try {
                    if (theme === 'dark' || theme === 'light') {
                        document.documentElement.setAttribute('data-theme', theme);
                        try { localStorage.setItem('theme', theme); } catch(e){}
                    } else {
                        document.documentElement.removeAttribute('data-theme');
                        try { localStorage.removeItem('theme'); } catch(e){}
                    }
                } catch(e){}
            };
        } catch(e){}
    })();

    function copyToClipboard(id) {
        try {
            var el = document.getElementById(id);
            if (!el) return;
            var text = el.innerText || el.textContent || '';
            text = text.trim();
            if (!text) return;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function(){
                    showCopyFeedback();
                }).catch(function(){ showCopyFeedback(false); });
            } else {
                var textarea = document.createElement('textarea');
                textarea.value = text;
                document.body.appendChild(textarea);
                textarea.select();
                try { document.execCommand('copy'); } catch (e) {}
                textarea.remove();
                showCopyFeedback();
            }
        } catch (e) { }
    }

    function showCopyFeedback(success = true) {
        try {
            var fb = document.getElementById('copy-feedback');
            if (!fb) return;
            fb.textContent = success ? 'Copied!' : 'Copy failed';
            fb.style.display = 'inline';
            setTimeout(function(){ fb.style.display = 'none'; fb.textContent = ''; }, 2000);
        } catch (e) {}
    }
</script>

</body>

</html>
