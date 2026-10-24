<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Autentikasi' }} | PPDB Darul Ihsan</title>
    <style>
        :root { --page-bg:#1f1f1f; --panel-bg:#6bd16f; --field-bg:#dedede; --button-bg:#4654ca; --ink:#111; --link:#087fe8; }
        * { box-sizing:border-box; }
        body { min-height:100vh; margin:0; display:grid; place-items:center; padding:24px 16px; background:var(--page-bg); color:var(--ink); font-family:Arial,Helvetica,sans-serif; }
        .auth-panel { width:min(100%,648px); min-height:510px; display:flex; flex-direction:column; align-items:center; padding:44px 32px 48px; background:var(--panel-bg); border:3px solid #218dff; }
        .brand-mark { width:124px; height:124px; margin-bottom:17px; display:block; }
        .welcome-copy { margin:0 0 20px; text-align:center; font-size:12px; font-weight:700; line-height:1.7; }
        .auth-heading { margin:0 0 18px; font-size:16px; }
        .auth-form { width:min(100%,348px); }
        .auth-error,.auth-success { width:100%; margin:0 0 16px; padding:9px 12px; border-radius:5px; font-size:11px; font-weight:700; text-align:center; }
        .auth-error { border:1px solid #a90000; background:#ffd6d6; color:#720000; }
        .auth-success { border:1px solid #257c2c; background:#dff6df; color:#185c1d; }
        .field { position:relative; display:flex; align-items:center; height:36px; margin-bottom:16px; overflow:hidden; border-radius:5px; background:var(--field-bg); }
        .field-icon { width:42px; flex:0 0 42px; display:grid; place-items:center; }
        .field-icon svg { width:20px; height:20px; fill:none; stroke:var(--ink); stroke-linecap:round; stroke-linejoin:round; stroke-width:2; }
        .field input { width:100%; height:100%; padding:0 12px 0 7px; border:0; outline:0; background:transparent; color:var(--ink); font-size:12px; font-weight:700; }
        .field input::placeholder { color:var(--ink); opacity:1; }
        .field select { width:100%; height:100%; padding:0 12px 0 7px; border:0; outline:0; background:transparent; color:var(--ink); font-size:12px; font-weight:700; }
        .submit-button { display:block; width:156px; height:40px; margin:6px auto 0; border:0; border-radius:5px; background:var(--button-bg); color:#fff; font-size:12px; font-weight:700; cursor:pointer; transition:filter 160ms ease,transform 160ms ease; }
        .submit-button:hover { filter:brightness(.94); transform:translateY(-1px); }
        .submit-button:focus-visible,.field input:focus-visible,.auth-link:focus-visible { outline:2px solid #fff; outline-offset:2px; }
        .auth-links { margin:13px 0 0; text-align:center; font-size:11px; font-weight:700; line-height:1.8; }
        .auth-link { color:var(--link); text-decoration:none; }
        .auth-link:hover { text-decoration:underline; }
        @media (max-width:520px) { body { padding:16px; } .auth-panel { min-height:540px; padding:38px 22px 40px; } }
    </style>
</head>
<body>
    <main class="auth-panel">
        <svg class="brand-mark" viewBox="0 0 124 124" role="img" aria-label="Logo Darul Ihsan">
            <rect width="124" height="124" fill="#fff"/>
            <path d="M62 6 68 18c16 2 30 12 37 26l-8 2c3 5 5 11 5 18 0 25-18 45-40 52C40 109 22 89 22 64c0-7 2-13 5-18l-8-2c7-14 21-24 37-26L62 6Z" fill="#f4f4f4" stroke="#202020" stroke-width="2"/>
            <path d="M62 17c-15 0-28 8-35 20l7 2c-3 7-5 14-5 23 0 17 12 31 28 37V55c-7-4-12-10-14-18 5-4 11-6 19-6s14 2 19 6c-2 8-7 14-14 18v44c16-6 28-20 28-37 0-9-2-16-5-23l7-2c-7-12-20-20-35-20Z" fill="#66b84c" stroke="#202020" stroke-width="2"/>
            <circle cx="62" cy="31" r="11" fill="#fff" stroke="#202020" stroke-width="2"/>
            <path d="M64 23c-6 0-10 4-10 9s4 9 10 9c3 0 6-1 8-4-2 1-4 1-6 1-4 0-6-3-6-6 0-4 2-6 6-7 1 0 3 0 4 1-2-2-3-3-6-3Z" fill="#66b84c"/>
            <path d="M43 58h38v23H43z" fill="#fff" stroke="#202020" stroke-width="2"/><path d="M48 63h28M48 69h28M48 75h20" stroke="#777" stroke-width="1"/>
            <text x="62" y="99" text-anchor="middle" font-size="19" font-family="Arial,sans-serif" font-weight="700" fill="#202020">YDL</text>
        </svg>
        @yield('content')
    </main>
</body>
</html>