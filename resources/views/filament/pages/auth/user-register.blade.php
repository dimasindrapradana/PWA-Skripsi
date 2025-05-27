<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Siswa</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @vite('resources/css/auth.css')
</head>
<body>
    <div class="login-wrapper">
        <h1>Register Siswa</h1>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.user.submit') }}">
            @csrf

            <label>Nama:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>

            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Konfirmasi Password:</label>
            <input type="password" name="password_confirmation" required>

            <button type="submit">Daftar</button>
        </form>

        <a href="{{ route('login.user') }}">Sudah punya akun? Login di sini</a>
    </div>
</body>
</html>
