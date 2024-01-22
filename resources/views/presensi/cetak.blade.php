<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi {{ $namaBulan }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        <style>body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .bg-info {
            background-color: #17a2b8 !important;
        }

        .bg-orange {
            background-color: #fd7e14 !important;
        }

        .text-white {
            color: #fff !important;
        }
    </style>

    </style>
</head>

<body>
    <div style="text-align: center;">
        <h3>Presensi {{ $namaBulan }}</h3>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="text-uppercase text-center font-weight-bold">
                <tr>
                    <th rowspan="2" class="align-middle">Nama Pegawai</th>
                    <th colspan="31" class="text-center">
                        <div class="d-flex justify-content-center space-2 items-center">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"
                                    class="w-4 text-primary cursor-pointer">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M222.1 17.94C240.8-.8035 271.2-.8035 289.9 17.94L336 64H400C426.5 64 448 85.49 448 112V176L493.6 221.6C512.3 240.3 512.3 270.7 493.6 289.5L448 335.1V400C448 426.5 426.5 448 400 448H335.1L289.9 493.1C271.2 511.9 240.8 511.9 222.1 493.1L176.9 448H112C85.49 448 64 426.5 64 400V335.1L18.41 289.5C-.3328 270.7-.3328 240.3 18.41 221.6L64 176V112C64 85.49 85.49 64 112 64H175.1L222.1 17.94zM169.4 166.5C164.9 179 171.5 192.7 183.1 197.2C196.5 201.6 210.2 195.1 214.6 182.6L215.1 181.3C216.2 178.1 219.2 176 222.6 176H280.9C289.2 176 296 182.8 296 191.1C296 196.6 293.1 201.6 288.4 204.3L244.1 229.7C236.6 234 232 241.9 232 250.5V264C232 277.3 242.7 288 256 288C269.1 288 279.8 277.5 279.1 264.4L312.3 245.9C331.9 234.7 344 213.8 344 191.1C344 156.3 315.7 128 280.9 128H222.6C198.9 128 177.8 142.9 169.8 165.3L169.4 166.5zM256 320C238.3 320 224 334.3 224 352C224 369.7 238.3 384 256 384C273.7 384 288 369.7 288 352C288 334.3 273.7 320 256 320z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-2">Kehadiran Karyawan</div>
                        </div>
                    </th>
                    <th rowspan="2" class="align-middle">Persentase</th>
                </tr>
                <tr class="text-center">
                    <?php
                            $currentMonth = date('m');
                            $currentYear = date('Y');
                            $lastDayOfMonth = date('t', strtotime("$currentYear-$currentMonth-01"));
                        
                            for ($day = 1; $day <= $lastDayOfMonth; $day++) : ?>
                    <th><?= $day ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>
                @php $lastEmployeeName = null; @endphp
                @foreach ($presensis->sortBy(['user.karyawan.nama', 'tanggal']) as $presensi)
                    @if ($lastEmployeeName != $presensi->user->karyawan->nama)
                        @php $lastEmployeeName = $presensi->user->karyawan->nama; @endphp
                        <tr>
                            <td>{{ $lastEmployeeName }}</td>
                            @php
                                $totalWeight = 0;
                            @endphp
                            @for ($day = 1; $day <= $lastDayOfMonth; $day++)
                                <?php
                                $attendanceClass = '';
                                $attendanceStatus = '';
                                $foundAttendance = false; // Track if attendance is found for the current day
                                // Iterate through $presensis to find attendance for the current day and employee
                                foreach ($presensis as $presensiItem) {
                                    if ($presensiItem->user->karyawan->nama == $lastEmployeeName && substr($presensiItem->tanggal, 8, 2) == $day) {
                                        $foundAttendance = true;
                                        switch ($presensiItem->status) {
                                            case 'Hadir':
                                                $attendanceClass = 'bg-success text-white';
                                                $attendanceStatus = 'H';
                                                $totalWeight += 1;
                                                break;
                                            case 'Terlambat':
                                                $attendanceClass = 'bg-warning text-white';
                                                $attendanceStatus = 'T';
                                                $totalWeight += 0.7;
                                                break;
                                            case 'Izin':
                                                $attendanceClass = 'bg-info text-white';
                                                $attendanceStatus = 'I';
                                                $totalWeight += 0.5;
                                                break;
                                            case 'Cuti':
                                                $attendanceClass = 'bg-orange text-white';
                                                $attendanceStatus = 'C';
                                                $totalWeight += 0.8;
                                                break;
                                            case 'Tidak Masuk':
                                                $attendanceClass = 'bg-danger text-white';
                                                $attendanceStatus = 'A';
                                                // $totalWeight += 0; // No need to add weight for 'A'
                                                break;
                                        }
                                        break;
                                    }
                                }
                                ?>
                                @if ($foundAttendance)
                                    <td class="text-center {{ $attendanceClass }}">
                                        {{ $attendanceStatus }}
                                    </td>
                                @elseif ($day < now()->day)
                                    <td class="text-center bg-danger text-white">
                                        A
                                    </td>
                                @else
                                    <td class="text-center">
                                        -
                                    </td>
                                @endif

                                {{-- <td class="text-center {{ $attendanceClass }}">
                                            @if ($foundAttendance)
                                                {{ $attendanceStatus }}
                                            @elseif ($day < now()->day)
                                                A
                                            @endif
                                        </td> --}}
                            @endfor
                            <td>
                                {{ number_format($totalWeight > 0 ? round(($totalWeight / $lastDayOfMonth) * 100, 2) : 0, 2) }}%

                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
