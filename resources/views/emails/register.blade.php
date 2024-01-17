<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Email Selamat Datang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #1a73e8;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .content {
            padding: 20px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #666;
        }

        strong {
            font-weight: bold;
            color: #333;
        }

        .thank-you {
            font-weight: bold;
            color: #1a73e8;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Selamat Datang di
                PT Atap Langit Indonesia!</h1>
        </div>
        <div class="content">
            <h2>Informasi Akun:</h2>
            <p><strong>Username:</strong> {{ $username }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            <p>Mohon simpan informasi ini dengan aman dan jangan bagikan kepada siapapun.</p>
            <p class="thank-you">Terima kasih!</p>
        </div>
    </div>
</body>

</html>
