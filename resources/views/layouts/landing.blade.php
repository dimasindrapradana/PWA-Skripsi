<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        body {
            background-color: #111827;
            color: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .landing-container {
            background-color: #1f2937;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            max-width: 420px;
            width: 90%;
            text-align: center;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            font-weight: bold;
        }

        .login-btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            margin: 0.5rem 0;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-siswa {
            background-color: #3b82f6;
            color: white;
        }

        .btn-siswa:hover {
            background-color: #2563eb;
        }

        .btn-guru {
            background-color: #10b981;
            color: white;
        }

        .btn-guru:hover {
            background-color: #059669;
        }

        @media screen and (max-width: 480px) {
            h1 {
                font-size: 1.5rem;
            }

            .login-btn {
                font-size: 0.95rem;
                padding: 0.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <h1>Selamat Datang</h1>
        <a href="{{ route('login.user') }}" class="login-btn btn-siswa">Login Siswa</a>
        <a href="{{ route('filament.admin.auth.login') }}" class="login-btn btn-guru">Login Guru / Admin</a>
    </div>
</body>
</html>
