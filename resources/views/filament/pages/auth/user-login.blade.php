<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa</title>
      <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
      @vite('resources/css/auth.css')
</head>
<body>
    <div class="login-wrapper">
        <h1>Login Siswa</h1>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.user.submit') }}">
            @csrf

            <label>Email:</label>
            <input type="text" name="email" required value="{{ old('email') }}">

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <a href="{{ route('register.user') }}">Belum punya akun? Daftar di sini</a>
    </div>
</body>
</html>
