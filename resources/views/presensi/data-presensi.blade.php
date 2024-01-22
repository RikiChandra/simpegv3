@extends('template.master')
@section('title', 'Data Presensi Karyawan')
@section('content')
    <style>
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            /* Change to your preferred font */
        }

        .table-custom thead th {
            background-color: #f8f9fa;
            /* Light gray background */
            color: #333;
            /* Dark text for contrast */
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        .table-custom tbody td {
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: center;
            vertical-align: middle;
        }

        .table-custom .bg-success {
            background-color: #28a745;
            /* Green for presence */
            color: white;
        }

        .table-custom .bg-warning {
            background-color: #ffc107;
            /* Yellow for late arrivals */
            color: white;
        }

        .table-custom .bg-danger {
            background-color: #dc3545;
            /* Red for absence */
            color: white;
        }

        .table-custom .align-middle {
            vertical-align: middle;
        }

        /* Add media queries for responsiveness */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                /* Enable horizontal scrolling on small devices */
            }
        }
    </style>
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <form method="get" action="{{ route('presensi.data') }}" id="presensiForm">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="bulan">Bulan:</label>
                            <select name="bulan" id="bulan" class="form-control select2">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tahun">Tahun:</label>
                            <select name="tahun" id="tahun" class="form-control select2">
                                @for ($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block"><i class="nav-icon fas fa-search"></i>
                            </button>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label>&nbsp;</label>
                            <a href="#" id="printButton" class="btn btn-success btn-block" target="_blank"><i
                                    class="nav-icon fas fa-print"></i> Print</a>
                        </div>
                    </div>
                </form>

            </div>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead class="text-uppercase text-center font-weight-bold">
                        <tr>
                            <th rowspan="2" class="align-middle">Nama Karyawan</th>
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
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Attach a click event handler to the print button
            $('#printButton').click(function(e) {
                e.preventDefault();

                // Get the selected month value
                var selectedMonth = $('#bulan').val();

                // Generate the print URL
                var printUrl = "{{ route('presensi.cetak', ['bulan' => ':bulan']) }}";
                printUrl = printUrl.replace(':bulan', selectedMonth);

                // Open a new window for print preview
                window.open(printUrl, '_blank');
            });
        });
    </script>
@endpush
