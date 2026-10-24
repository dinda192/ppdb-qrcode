@extends('auth.layout', ['title' => 'Password Baru'])

@section('content')
        <h1 class="auth-heading">Buat password baru</h1>
        @if ($errors->any()) <div class="auth-error" role="alert">{{ $errors->first() }}</div> @endif
        <form class="auth-form" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <label class="field"><span class="field-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m4 7 8 6 8-6"></path></svg></span><input type="email" name="email" placeholder="Email" value="{{ old('email', request('email')) }}" required></label>
            <label class="field"><span class="field-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="11"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"></path></svg></span><input type="password" name="password" placeholder="Password baru" required></label>
            <label class="field"><span class="field-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="11"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"></path></svg></span><input type="password" name="password_confirmation" placeholder="Konfirmasi password" required></label>
            <button class="submit-button" type="submit">Simpan password</button>
        </form>
@endsection