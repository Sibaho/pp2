<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Aset</title>

    <!-- Simple CSS -->
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: 100px auto;
            text-align: center;
            padding: 20px;
        }
        h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        p {
            font-size: 18px;
            color: #666;
        }
        .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
        }
        .btn:hover {
            background: #1e40af;
        }
        footer {
            margin-top: 80px;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Sistem Monitoring Aset</h1>
        <p>
            Aplikasi ini digunakan untuk melakukan pencatatan, pemantauan,
            dan pengelolaan data aset secara terpusat dan terintegrasi.
        </p>

        <a href="{{ route('admin.login') }}" class="btn">
            Login Admin
        </a>

        <footer>
            <p>&copy; {{ date('Y') }} Sistem Monitoring Aset</p>
        </footer>
    </div>

</body>
</html>
