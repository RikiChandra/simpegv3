@extends('template.master')
@section('title', 'Data Presensi')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <style>
        /* Presensi Modal Styles */
        .modal-dialog {
            max-width: 90%;
        }

        .modal-content {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }

        .modal-header {
            border-bottom: 1px solid #eaecef;
            font-family: 'Arial', sans-serif;
            padding: 15px;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .close {
            font-size: 1.4rem;
        }

        .modal-body {
            padding: 20px;
        }

        .camera-container,
        .map-container {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            height: 250px;
            /* Adjust as needed */
        }

        .camera-container video,
        .camera-container canvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #cameraIcon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* Camera Icon styles */
        }

        .location-selector {
            margin-bottom: 15px;
        }

        .modal-footer {
            border-top: 1px solid #eaecef;
            padding: 15px;
            text-align: center;
        }

        .button-group button {
            margin: 5px;
        }

        .location-selector .form-select {
            display: block;
            width: 100%;
            padding: 0.375rem 1.75rem 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        #stopButton {
            display: none;
            /* Change to 'block' or 'inline-block' as per your JS logic */
        }

        #cameraIcon {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            /* Adjust as needed */
            height: 100%;
            /* Adjust as needed */
        }

        #cameraIcon svg {
            max-width: 100%;
            max-height: 100%;
        }



        /* Responsive Styles */
        @media (max-width: 768px) {
            .modal-lg {
                max-width: 100%;
            }

            .camera-container,
            .map-container {
                height: 200px;
                /* Adjust for smaller screens */
            }

            .modal-footer .button-group {
                flex-direction: column;
            }
        }

        /* Additional custom styles as per your preference */
    </style>

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end">
                @if ($hasAttended)
                    <span class="badge badge-success">Anda Sudah Melakukan Presensi</span>
                @else
                    @php
                        $currentTime = \Carbon\Carbon::now('Asia/Jakarta');
                        $closingTime = \Carbon\Carbon::parse('23:59:00', 'Asia/Jakarta');
                    @endphp

                    @if ($currentTime < $closingTime)
                        <button class="btn btn-primary" data-toggle="modal" data-target="#presensiModal">Presensi
                            Mandiri</button>
                    @else
                        <span class="badge badge-danger">Presensi sudah ditutup</span>
                    @endif
                @endif
            </div>
        </div>



        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($presensis as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ asset('storage/' . $item->photo) }}" alt="Foto" width="100px"></td>
                                <td>{{ $item->user->karyawan->nama }}</td>
                                <td>{{ $item->jam_masuk }}</td>
                                @if ($item->jam_keluar == null)
                                    <td>
                                        <form action="{{ route('presensi.update', ['presensi' => $item->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('patch')
                                            <button type="submit" class="btn btn-success btn-sm">Presensi Pulang</button>
                                        </form>
                                    </td>
                                @else
                                    <td>{{ $item->jam_keluar }}</td>
                                @endif
                                <td>{{ $item->tanggal }}</td>
                                <td>
                                    @if ($item->status == 'Hadir')
                                        <span class="badge badge-success">Hadir</span>
                                    @elseif($item->status == 'Terlambat')
                                        <span class="badge badge-warning">Terlambat</span>
                                    @else
                                        <span class="badge badge-danger">Tidak Masuk</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data presensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Presensi Modal -->
    <div class="modal fade" id="presensiModal" tabindex="-1" aria-labelledby="presensiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="presensiModalLabel">Presensi Mandiri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <div class="location-selector mt-2">
                        <label for="lokasiSelect" class="form-label">Pilih Lokasi</label>
                        <select class="form-select select2" id="lokasiSelect">
                            @foreach ($lokasiKerjas as $lokasiKerja)
                                <option value="{{ $lokasiKerja->id }}" data-latitude="{{ $lokasiKerja->latitude }}"
                                    data-longitude="{{ $lokasiKerja->longitude }}">{{ $lokasiKerja->nama_lokasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Camera Section -->
                        <div class="col-md-6">
                            <div class="camera-container">
                                <video id="video" autoplay></video>
                                <canvas id="canvas" style="display: none;"></canvas>
                                <div id="cameraIcon">
                                    <svg width="150px" height="150px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3 3L6.00007 6.00007M21 21L19.8455 19.8221M9.74194 4.06811C9.83646 4.04279 9.93334 4.02428 10.0319 4.01299C10.1453 4 10.2683 4 10.5141 4H13.5327C13.7786 4 13.9015 4 14.015 4.01299C14.6068 4.08078 15.1375 4.40882 15.4628 4.90782C15.5252 5.00345 15.5802 5.11345 15.6901 5.33333C15.7451 5.44329 15.7726 5.49827 15.8037 5.54609C15.9664 5.79559 16.2318 5.95961 16.5277 5.9935C16.5844 6 16.6459 6 16.7688 6H17.8234C18.9435 6 19.5036 6 19.9314 6.21799C20.3077 6.40973 20.6137 6.71569 20.8055 7.09202C21.0234 7.51984 21.0234 8.0799 21.0234 9.2V15.3496M19.8455 19.8221C19.4278 20 18.8702 20 17.8234 20H6.22344C5.10333 20 4.54328 20 4.11546 19.782C3.73913 19.5903 3.43317 19.2843 3.24142 18.908C3.02344 18.4802 3.02344 17.9201 3.02344 16.8V9.2C3.02344 8.0799 3.02344 7.51984 3.24142 7.09202C3.43317 6.71569 3.73913 6.40973 4.11546 6.21799C4.51385 6.015 5.0269 6.00103 6.00007 6.00007M19.8455 19.8221L14.5619 14.5619M14.5619 14.5619C14.0349 15.4243 13.0847 16 12 16C10.3431 16 9 14.6569 9 13C9 11.9153 9.57566 10.9651 10.4381 10.4381M14.5619 14.5619L10.4381 10.4381M10.4381 10.4381L6.00007 6.00007"
                                            stroke="#000000" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>


                            </div>
                        </div>
                        <!-- Maps Section -->
                        <div class="col-md-6">
                            <div id="report-map" class="map-container">
                                <!-- Map content here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="button-group">
                        <button class="btn btn-info" id="startButton">Aktifkan Kamera</button>
                        <button class="btn btn-danger" id="stopButton">Matikan Kamera</button>
                        <button class="btn btn-success" id="absensiButton">Presensi Mandiri</button>
                        <button class="btn btn-secondary" onclick="getLocation()">Dapatkan Lokasi Saya</button>
                        <button class="btn btn-primary" id="takePhotoButton">Ambil Foto</button>
                        <button id="retakePhotoButton" style="display: none;" class="btn btn-warning">Retake</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDazrYoL6c9EtcTRcXBo_vJw9z3P7HiH84&libraries=places">
    </script>
    <script>
        // Inisialisasi variabel map sebagai variabel global
        var map;
        var markers = [];

        $(document).ready(function() {
            // Inisialisasi peta
            function initMap() {
                var centerLatLng = {
                    lat: {{ $jam_kerja->latitude }},
                    lng: {{ $jam_kerja->longitude }}
                };
                map = new google.maps.Map(document.getElementById('report-map'), {
                    center: centerLatLng,
                    zoom: 30
                });

                // Panggil fungsi updateMap() saat halaman dimuat
                updateMap();
            }

            // Fungsi untuk menghapus marker yang ada di peta
            function clearMarkers() {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                markers = [];
            }

            // Fungsi untuk menambahkan marker ke peta
            function addMarker(location) {
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
                markers.push(marker);
            }

            // Fungsi untuk mengatur peta berdasarkan pilihan lokasi
            function updateMap() {
                clearMarkers();
                var selectedOption = $('#lokasiSelect option:selected');
                var latitude = parseFloat(selectedOption.data('latitude'));
                var longitude = parseFloat(selectedOption.data('longitude'));
                var location = {
                    lat: latitude,
                    lng: longitude
                };

                map.setCenter(location);
                addMarker(location);

                // Tambahkan radius ke peta
                var circle = new google.maps.Circle({
                    strokeColor: 'blue',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: 'blue',
                    fillOpacity: 0.2,
                    map: map,
                    center: location,
                    radius: 10 // Sesuaikan dengan radius yang diinginkan dalam meter
                });
            }

            // Event untuk mengatur peta ketika pilihan lokasi berubah
            $('#lokasiSelect').change(function() {
                updateMap();
            });

            // Panggil fungsi initMap() saat halaman dimuat
            initMap();
        });

        // Fungsi untuk mendapatkan lokasi pengguna dan menampilkannya pada peta
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        // Fungsi untuk menampilkan lokasi pengguna pada peta
        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            // Menampilkan lokasi pada peta
            var userLocation = new google.maps.LatLng(latitude, longitude);
            var userMarker = new google.maps.Marker({
                position: userLocation,
                map: map,
                title: 'Lokasi Saya'
            });
            map.setCenter(userLocation);
        }
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var video = document.getElementById('video');
            var startButton = document.getElementById('startButton');
            var stopButton = document.getElementById('stopButton');
            var stopButtonMobile = document.getElementById('stopButtonMobile');

            var constraints = {
                video: true
            };

            // Fungsi untuk memulai kamera
            function startCamera() {
                navigator.mediaDevices.getUserMedia(constraints)
                    .then(function(stream) {
                        video.srcObject = stream;
                        video.play();
                        startButton.classList.add('hidden');
                        stopButton.classList.remove('hidden');
                    })
                    .catch(function(error) {
                        console.log("Error accessing camera: ", error);
                    });
            }

            // Fungsi untuk mematikan kamera
            function stopCamera() {
                var stream = video.srcObject;
                var tracks = stream.getTracks();

                tracks.forEach(function(track) {
                    track.stop();
                });

                video.srcObject = null;
                stopButton.classList.add('hidden');
                startButton.classList.remove('hidden');
            }

            // Aktifkan kamera saat tombol ditekan
            startButton.addEventListener('click', function() {
                startCamera();
                stopButtonMobile.classList.remove('hidden');
            });

            // Matikan kamera saat tombol ditekan
            stopButton.addEventListener('click', function() {
                stopCamera();
                stopButtonMobile.classList.add('hidden');
            });
        });
    </script>
    <script>
        const video = document.getElementById('video');
        const cameraIcon = document.getElementById('cameraIcon');
        const startButton = document.getElementById('startButton');
        const stopButton = document.getElementById('stopButton');
        const cameraSVG = document.getElementById('cameraSVG');

        // Fungsi untuk menampilkan ikon kamera
        function showCameraIcon() {
            cameraIcon.style.display = 'flex';
        }

        // Fungsi untuk menyembunyikan ikon kamera
        function hideCameraIcon() {
            cameraIcon.style.display = 'none';
        }

        // Mendeteksi saat tombol 'Aktifkan Kamera' ditekan
        startButton.addEventListener('click', () => {
            video.play(); // Memulai video
            hideCameraIcon(); // Sembunyikan ikon kamera
            startButton.style.display = 'none'; // Sembunyikan tombol 'Aktifkan Kamera'
            stopButton.style.display = 'block'; // Tampilkan tombol 'Matikan Kamera'
        });

        // Mendeteksi saat tombol 'Matikan Kamera' ditekan
        stopButton.addEventListener('click', () => {
            video.pause(); // Berhenti memutar video
            showCameraIcon(); // Tampilkan kembali ikon kamera
            stopButton.style.display = 'none'; // Sembunyikan tombol 'Matikan Kamera'
            startButton.style.display = 'block'; // Tampilkan tombol 'Aktifkan Kamera'
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            const takePhotoButton = document.getElementById('takePhotoButton');
            const retakePhotoButton = document.getElementById('retakePhotoButton');
            const deletePhotoButton = document.getElementById('deletePhotoButton');
            let imgElement;

            function takePhoto() {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                if (video.srcObject === null) {
                    alert('Aktifkan kamera terlebih dahulu');
                    return; // Hentikan eksekusi jika kamera belum aktif
                }

                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const photoURL = canvas.toDataURL('image/jpeg');

                imgElement = document.createElement('img');
                imgElement.src = photoURL;
                imgElement.className = 'rounded-lg shadow-lg w-full h-full object-cover';
                video.style.display = 'none';
                imgElement.id = 'capturedImage';

                // Displaying the captured photo
                const videoParent = video.parentElement;
                if (videoParent) {
                    videoParent.insertBefore(imgElement, video);
                }

                takePhotoButton.style.display = 'none';
                retakePhotoButton.style.display = 'block';
                deletePhotoButton.style.display = 'block';
            }

            takePhotoButton.addEventListener('click', () => {
                takePhoto();
            });

            retakePhotoButton.addEventListener('click', () => {
                const capturedImage = document.getElementById('capturedImage');
                if (capturedImage) {
                    capturedImage.remove();
                }

                video.style.display = 'block';

                takePhotoButton.style.display = 'block';
                retakePhotoButton.style.display = 'none';
                deletePhotoButton.style.display = 'none';
            });

            deletePhotoButton.addEventListener('click', () => {
                const capturedImage = document.getElementById('capturedImage');
                if (capturedImage) {
                    capturedImage.remove();
                }

                takePhotoButton.style.display = 'block';
                retakePhotoButton.style.display = 'none';
                deletePhotoButton.style.display = 'none';
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ... Bagian kode yang sudah ada sebelumnya ...

            // Fungsi untuk mengirim foto dan data lokasi ke backend
            function sendPhotoAndLocationToBackend(photoData, latitude, longitude) {
                const token = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token

                $.ajax({
                    url: '/presensi/store',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        photo: photoData,
                        latitude: latitude,
                        longitude: longitude
                    }),
                    success: function(data) {
                        console.log(data); // Display server response, modify as needed
                        alert('Presensi berhasil');
                        window.location.href =
                            '/presensi'; // Ganti '/index' dengan URL halaman index yang sesuai
                    },

                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }


            // // Fungsi untuk mengecek apakah pengguna berada dalam radius absensi
            // function checkUserLocation(latitude, longitude) {
            //     // Ganti koordinat pusat perusahaan sesuai dengan nilai yang diinginkan
            //     const companyLatitude = {{ $jam_kerja->latitude }};
            //     const companyLongitude = {{ $jam_kerja->longitude }};
            //     const radius = 10; // Radius dalam meter

            //     // Hitung jarak antara lokasi pengguna dengan pusat perusahaan
            //     const distance = calculateDistance(latitude, longitude, companyLatitude, companyLongitude);

            //     // Jika jarak kurang dari radius absensi, pengguna berada dalam area perusahaan
            //     if (distance <= radius) {
            //         return true;
            //     } else {
            //         return false;
            //     }
            // }

            // Fungsi untuk menghitung jarak antara dua koordinat menggunakan formula haversine
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const earthRadius = 6371000; // Radius bumi dalam meter

                const degToRad = (degrees) => {
                    return degrees * (Math.PI / 180);
                };

                const dLat = degToRad(lat2 - lat1);
                const dLon = degToRad(lon2 - lon1);

                const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(degToRad(lat1)) * Math.cos(degToRad(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);

                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                const distance = earthRadius * c;

                return distance;
            }

            // Fungsi untuk mengecek apakah pengguna berada dalam radius absensi
            function checkUserLocation(latitude, longitude) {
                // Ganti koordinat pusat perusahaan sesuai dengan nilai yang diinginkan
                const companyLatitude = parseFloat($('#lokasiSelect option:selected').data('latitude'));
                const companyLongitude = parseFloat($('#lokasiSelect option:selected').data('longitude'));
                const radius = 10; // Radius dalam meter

                // Hitung jarak antara lokasi pengguna dengan pusat perusahaan
                const distance = calculateDistance(latitude, longitude, companyLatitude, companyLongitude);

                // Jika jarak kurang dari radius absensi, pengguna berada dalam area perusahaan
                if (distance <= radius) {
                    return true;
                } else {
                    return false;
                }
            }

            // Fungsi untuk mengambil foto dan mengirim ke backend bersama data lokasi
            function takePhotoAndSend() {
                const canvas = document.getElementById('canvas');
                const context = canvas.getContext('2d');
                const video = document.getElementById('video');
                if (video.srcObject === null) {
                    alert('Aktifkan kamera terlebih dahulu');
                    return; // Hentikan eksekusi jika kamera belum aktif
                }

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const photoData = canvas.toDataURL('image/jpeg');

                // Ambil lokasi pengguna
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        const isWithinRadius = checkUserLocation(latitude, longitude);

                        if (isWithinRadius) {
                            // Jika pengguna berada dalam radius perusahaan, kirim foto dan lokasi ke backend
                            sendPhotoAndLocationToBackend(photoData, latitude, longitude);
                        } else {
                            alert('Anda tidak berada di area perusahaan');
                        }
                    });
                } else {
                    console.log("Geolocation is not supported by this browser.");
                }
            }

            // Panggil fungsi takePhotoAndSend saat tombol absensi ditekan
            const absensiButton = document.getElementById('absensiButton'); // Ganti dengan ID tombol absensi
            absensiButton.addEventListener('click', takePhotoAndSend);

        });
    </script>
    <script>
        $(function() {
            // Inisialisasi DataTable untuk tabel dengan ID example1
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            // Menggunakan event handler jQuery untuk menampilkan SweetAlert2 saat tombol delete diklik
            $(".delete-button").on("click", function() {
                let itemId = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#deleteForm-" + itemId).submit();
                    }
                });
            });

            // Inisialisasi DataTable untuk tabel dengan ID example2
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush
