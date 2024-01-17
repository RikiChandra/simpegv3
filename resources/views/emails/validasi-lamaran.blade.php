<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Lamaran</title>
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
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .thank-you {
            font-weight: bold;
            color: #1a73e8;
        }
    </style>
</head>

<body>
    <div class="container">
        @if ($lamaran->status === 'Diterima')
            <div class="alert-alert-success">
                <p class="thank-you">Selamat!</p>
                <p>Pengajuan Lamaran Anda Diterima</p>
                <p>Silahkan menghubungi kontak perusahaan yang tersedia dan membawa berkas persyaratan ke kantor perusahaan.</p>
            </div>        
        @elseif($lamaran->status === 'Ditolak')
            <div class="alert-alert-success">
                <h2>Konfirmasi Lamaran</h2>
                <p>Mohon Maaf Pengajuan Lamaran Anda Ditolak.</p>
            </div>
        @endif
    </div>
</body>

</html>