@extends('template.master')
@section('title', 'Lokasi dan jam kerja')
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
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahData">
                    Tambah Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lokasi</th>
                            <th>Latitude, Longitude</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lokasi_kerjas as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_lokasi }}</td>
                                <td>{{ $item->latitude }}, {{ $item->longitude }}</td>
                                <td>{{ $item->jam_masuk }}</td>
                                <td>{{ $item->jam_keluar }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-warning mr-2" data-toggle="modal"
                                            data-target="#modalEditData-{{ $item->id }}" data-id="{{ $item->id }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form id="deleteForm-{{ $item->id }}"
                                            action="{{ route('lokasi.destroy', ['lokasiKerja' => $item->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger delete-button"
                                                data-id="{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal untuk input edit data -->
                            <div class="modal fade" id="modalEditData-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modalTambahDataLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTambahDataLabel">Edit Data Penilaian</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form untuk input data baru -->
                                            <form id="formEditData"
                                                action="{{ route('lokasi.update', ['lokasiKerja' => $item->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="nama">Nama Lokasi</label>
                                                    <input type="text" class="form-control" id="nama"
                                                        value="{{ old('nama_lokasi') ?? $item->nama_lokasi }}"
                                                        name="nama_lokasi" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama">Latitude</label>
                                                    <input type="text" class="form-control" id="nama"
                                                        value="{{ old('latitude') ?? $item->latitude }}" name="latitude"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama">Longitude</label>
                                                    <input type="text" class="form-control" id="nama"
                                                        value="{{ old('longitude') ?? $item->longitude }}" name="longitude"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nilai">Jam Masuk</label>
                                                    <input type="time" class="form-control" id="nilai"
                                                        value="{{ old('jam_masuk') ?? $item->jam_masuk }}" name="jam_masuk"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nilai">Jam Keluar</label>
                                                    <input type="time" class="form-control" id="nilai"
                                                        value="{{ old('jam_keluar') ?? $item->jam_keluar }}"
                                                        name="jam_keluar" required>
                                                </div>
                                                <button type="submit" class="btn btn-warning">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal untuk input data baru -->
    <div class="modal fade" id="modalTambahData" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDataLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk input data baru -->
                    <form id="formTambahData" action="{{ route('lokasi.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Lokasi</label>
                            <input type="text" class="form-control" id="nama" name="nama_lokasi" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Latitude</label>
                            <input type="text" class="form-control" id="nama" name="latitude" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Longitude</label>
                            <input type="text" class="form-control" id="nama" name="longitude" required>
                        </div>
                        <div class="form-group">
                            <label for="nilai">Jam Masuk</label>
                            <input type="time" class="form-control" id="nilai" name="jam_masuk" required>
                        </div>
                        <div class="form-group">
                            <label for="nilai">Jam Keluar</label>
                            <input type="time" class="form-control" id="nilai" name="jam_keluar" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
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
