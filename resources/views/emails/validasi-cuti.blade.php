<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Cuti</title>
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
        @if ($cuti->status === 'Diterima')
            <div class="alert-alert-success">
                <h2>Konfirmasi Cuti</h2>
                <p>Pengajuan Cuti Anda Diterima.</p>
            </div>        
        @elseif($cuti->status === 'Ditolak')
            <div class="alert-alert-success">
                <h2>Konfirmasi Cuti</h2>
                <p>Mohon Maaf Pengajuan Cuti Anda Ditolak.</p>
                <p>Keterangan : {{ $cuti->keterangan }}</p>
            </div>
        @endif
    </div>
</body>

</html>