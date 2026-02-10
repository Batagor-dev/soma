<!DOCTYPE html>
<html lang="id" class="h-100">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Error')</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: #ffffff;
            margin: 0;
        }

        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }

        .error-icon {
            font-size: 4rem;
            margin-bottom: 10px;
        }

        .error-code {
            font-size: 6rem;
            font-weight: 800;
            color: #0d6efd;
            line-height: 1;
        }

        .error-title {
            font-size: 2rem;
            font-weight: 700;
            margin-top: 10px;
        }

        .error-message {
            color: #6c757d;
            max-width: 500px;
            margin: 15px auto 30px;
        }

        .error-actions a {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .error-code {
                font-size: 4.5rem;
            }
            .error-title {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>

<div class="error-page">
    <div>

        <div class="error-code">
            @yield('error-code', '404')
        </div>

        <div class="error-title">
            @yield('error-title', 'Terjadi Kesalahan')
        </div>

        <p class="error-message">
            @yield('error-message', 'Halaman yang Anda cari tidak dapat ditemukan.')
        </p>

        <div class="error-actions">
            @yield('error-buttons')
        </div>
    </div>
</div>

</body>
</html>
