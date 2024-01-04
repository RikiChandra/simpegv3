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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($presensis as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ asset('storage/' . $item->photo) }}" alt="Foto" width="100px"></td>
                                <td>{{ $item->user->karyawan->nama }}</td>
                                <td>{{ $item->jam_masuk }}</td>
                                <td>{{ $item->jam_keluar }}</td>
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
                                <td>
                                    @if ($item->jam_keluar == null)
                                        <form action="{{ route('presensi.update', ['presensi' => $item->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('patch')
                                            <button type="submit" class="btn btn-success btn-sm">Presensi Pulang</button>
                                        </form>
                                    @else
                                        <span class="badge badge-secondary">Anda Sudah Presensi Hari Ini</span>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="presensiModalLabel">Presensi Mandiri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Camera Section -->
                        <div class="col-md-6">
                            <div class="position-relative h-100">
                                <video id="video" class="rounded-lg shadow-lg w-100 h-100 object-cover"
                                    autoplay></video>
                                <canvas id="canvas" class="position-absolute top-0 left-0 w-100 h-100"
                                    style="display: none;"></canvas>
                                <div id="cameraIcon"
                                    class="position-absolute inset-0 d-flex align-items-center justify-content-center rounded-lg bg-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-500"
                                        viewBox="0 0 20 20" fill="currentColor" id="cameraSVG">
                                        <path
                                            d="M17 4h-3.586l-1-1H7.586l-1 1H3a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zm-7 11a3 3 0 100-6 3 3 0 000 6z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <!-- Maps Section -->
                        <div class="col-md-6">
                            <div id="report-map" class="rounded-md bg-gray-200 shadow-lg h-100"
                                data-center="{{ $jam_kerja->latitude }}, {{ $jam_kerja->longitude }}" data-sources="">
                                <!-- Map or any location information goes here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="mt-6 d-flex flex-column flex-sm-row justify-content-center gap-2">
                        <button class="btn btn-indigo" id="startButton">Aktifkan Kamera</button>
                        <button class="btn btn-danger d-none" id="stopButton">Matikan Kamera</button>
                        <button class="btn btn-teal" id="absensiButton">Presensi Mandiri</button>
                        <button onclick="getLocation()" class="btn btn-secondary">Dapatkan Lokasi Saya</button>
                        <button class="btn btn-primary" id="takePhotoButton">Ambil Foto</button>
                        <button id="retakePhotoButton" style="display: none;" class="btn btn-warning">Retake</button>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitPresensi">Submit Presensi</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDazrYoL6c9EtcTRcXBo_vJw9z3P7HiH84&libraries=places">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mapElement = document.getElementById('report-map');

            var centerCoordinates = mapElement.dataset.center.split(',').map(function(coord) {
                return parseFloat(coord);
            });

            var mapOptions = {
                zoom: 30,
                center: new google.maps.LatLng(centerCoordinates[0], centerCoordinates[1]),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            // Membuat peta dengan inisialisasi di bagian ini
            map = new google.maps.Map(mapElement, mapOptions);

            // Membuat marker pusat
            var centerMarker = new google.maps.Marker({
                position: new google.maps.LatLng(centerCoordinates[0], centerCoordinates[1]),
                map: map,
                title: 'Pusat Data'
            });

            var circle = new google.maps.Circle({
                strokeColor: 'blue',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: 'blue',
                fillOpacity: 0.2,
                map: map,
                center: new google.maps.LatLng(centerCoordinates[0], centerCoordinates[1]),
                radius: 10
            });
        });

        // Kemudian, fungsi getLocation dan showPosition seperti sebelumnya
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

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


            // Fungsi untuk mengecek apakah pengguna berada dalam radius absensi
            function checkUserLocation(latitude, longitude) {
                // Ganti koordinat pusat perusahaan sesuai dengan nilai yang diinginkan
                const companyLatitude = {{ $jam_kerja->latitude }};
                const companyLongitude = {{ $jam_kerja->longitude }};
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
