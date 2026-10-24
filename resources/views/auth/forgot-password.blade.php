@extends('auth.layout', ['title' => 'Lupa Kata Sandi'])

@section('content')
        <h1 class="auth-heading">Lupa kata sandi?</h1>
        <p class="welcome-copy">Masukkan email akun Anda untuk menerima<br>tautan pengaturan password baru.</p>
        @if (session('status')) <div class="auth-success" role="status">{{ session('status') }}</div> @endif
        @if ($errors->any()) <div class="auth-error" role="alert">{{ $errors->first() }}</div> @endif
        <form class="auth-form" action="{{ route('password.email') }}" method="POST">
            @csrf
            <label class="field"><span class="field-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m4 7 8 6 8-6"></path></svg></span><input type="email" name="email" placeholder="Email" value="{{ old('email') }}" autocomplete="email" required></label>
            <button class="submit-button" type="submit">Kirim tautan</button>
            <p class="auth-links"><a class="auth-link" href="{{ route('login') }}">Kembali ke halaman masuk</a></p>
        </form>
@endsection