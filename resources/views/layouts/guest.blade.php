<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'StudentMarket') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #0E0E10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .guest-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 48px;
            border-bottom: 0.5px solid rgba(255,255,255,0.06);
        }
        .logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .logo-icon {
            width: 32px; height: 32px;
            background: #E8FF5A;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-icon i { font-size: 16px; color: #0E0E10; }
        .logo-text {
            font-family: 'Syne', sans-serif;
            font-size: 16px; font-weight: 700;
            color: #fff;
        }
        .guest-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 16px;
        }
        .guest-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255,255,255,0.03);
            border: 0.5px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 40px;
        }
        .guest-label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: rgba(255,255,255,0.5);
            margin-bottom: 6px;
        }
        .guest-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 0.5px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            color: #fff;
            outline: none;
            transition: border-color 0.15s;
            font-family: 'DM Sans', sans-serif;
        }
        .guest-input:focus { border-color: #E8FF5A; }
        .guest-input option { background: #1a1a1c; color: #fff; }
        .guest-error { font-size: 12px; color: #f87171; margin-top: 4px; }
        .guest-btn {
            width: 100%;
            padding: 12px;
            background: #E8FF5A;
            color: #0E0E10;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: opacity 0.15s;
        }
        .guest-btn:hover { opacity: 0.85; }
        .guest-link {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: color 0.15s;
        }
        .guest-link:hover { color: #E8FF5A; }
        .guest-divider {
            border: none;
            border-top: 0.5px solid rgba(255,255,255,0.06);
            margin: 24px 0;
        }
        .guest-title {
            font-family: 'Syne', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
        }
        .guest-subtitle {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            margin-bottom: 32px;
        }
        .error-flash {
            background: rgba(248,113,113,0.1);
            border: 0.5px solid rgba(248,113,113,0.3);
            color: #f87171;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .status-flash {
            background: rgba(74,222,128,0.1);
            border: 0.5px solid rgba(74,222,128,0.3);
            color: #4ade80;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .checkbox-custom {
            accent-color: #E8FF5A;
            width: 14px; height: 14px;
        }
    </style>
</head>
<body>
    <nav class="guest-nav">
        <a href="/" class="logo">
            <div class="logo-icon"><i class="ti ti-bolt"></i></div>
            <span class="logo-text">StudentMarket</span>
        </a>
    </nav>
    <div class="guest-wrapper">
        <div class="guest-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
