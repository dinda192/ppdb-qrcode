@extends('auth.layout', ['title' => 'Login'])

@section('content')
        <p class="welcome-copy">Selamat Datang di aplikasi PPDB<br>Darul Ihsan</p>

        @if ($errors->any())
            <div class="auth-error" role="alert">{{ $errors->first() }}</div>
        @endif
        @if (session('status'))
            <div class="auth-success" role="status">{{ session('status') }}</div>
        @endif

        <form class="auth-form" action="{{ route('login.store') }}" method="POST">
            @csrf
            <label class="field">
                <span class="field-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.5"></circle><path d="M5 19c.8-3 3.3-4.5 7-4.5s6.2 1.5 7 4.5"></path></svg>
                </span>
                <input type="email" name="email" placeholder="Email" autocomplete="username" aria-label="Email" value="{{ old('email') }}" required>
            </label>

            <label class="field">
                <span class="field-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="11"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"></path></svg>
                </span>
                <input type="password" name="password" placeholder="Password" autocomplete="current-password" aria-label="Password">
            </label>

            <button class="submit-button" type="submit">Masuk</button>
            <p class="auth-links"><a class="auth-link" href="{{ route('password.request') }}">Lupa kata sandi?</a><br>Belum punya akun? <a class="auth-link" href="{{ route('register') }}">Daftar</a></p>
        </form>
@endsection
