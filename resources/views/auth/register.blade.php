@extends('auth.layout', ['title' => 'Daftar'])

@section('content')
        <h1 class="auth-heading">Daftar akun baru</h1>
        @if ($errors->any()) <div class="auth-error" role="alert">{{ $errors->first() }}</div> @endif
        <form class="auth-form" action="{{ route('register.store') }}" method="POST">
            @csrf
            <label class="field"><span class="field-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.5"></circle><path d="M5 19c.8-3 3.3-4.5 7-4.5s6.2 1.5 7 4.5"></path></svg></span><input type="text" name="name" placeholder="Nama lengkap" value="{{ old('name') }}" autocomplete="name" required></label>
            <label class="field"><span class="field-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m4 7 8 6 8-6"></path></svg></span><input type="email" name="email" placeholder="Email" value="{{ old('email') }}" autocomplete="email" required></label>
            <label class="field"><span class="field-icon" aria-hidden="true">⌂</span><select name="jenjang" aria-label="Jenjang" required><option value="">Pilih jenjang</option>@foreach(['MTs', 'MA', 'SMK'] as $jenjang)<option value="{{ $jenjang }}" @selected(old('jenjang') === $jenjang)>{{ $jenjang }}</option>@endforeach</select></label>
            <label class="field"><span class="field-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="11"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"></path></svg></span><input type="password" name="password" placeholder="Password" autocomplete="new-password" required></label>
            <label class="field"><span class="field-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="11"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"></path></svg></span><input type="password" name="password_confirmation" placeholder="Konfirmasi password" autocomplete="new-password" required></label>
            <button class="submit-button" type="submit">Daftar</button>
            <p class="auth-links">Sudah punya akun? <a class="auth-link" href="{{ route('login') }}">Masuk</a></p>
        </form>
@endsection