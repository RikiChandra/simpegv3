@extends('template.master')
@section('title', 'Manajemen Jam Kerja')
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
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">Tambah Jam Kerja</a>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jamKerjas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->hari }}</td>
                            <td>{{ $item->jam_masuk }}</td>
                            <td>{{ $item->jam_keluar }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-warning mr-2 edit-button" data-id="{{ $item->id }}"
                                        data-toggle="modal" data-target="#editModal-{{ $item->id }}"><i
                                            class="fas fa-edit"></i></button>
                                    <form action="/jam-kerja/{{ $item->id }}/delete" method="post"
                                        id="deleteForm-{{ $item->id }}">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger delete-button"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Jam Kerja</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulir untuk mengedit data -->
                                        <form action="{{ route('jam-kerja.update', ['jamKerja' => $item->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group">
                                                <label>Hari</label>
                                                <select class="form-control select2 @error('hari') is-invalid @enderror"
                                                    style="width: 100%;" name="hari">
                                                    <option value="" selected disabled>Pilih</option>
                                                    <option value="Senin"
                                                        {{ old('hari', $item->hari) == 'Senin' ? 'selected' : '' }}>Senin
                                                    </option>
                                                    <option value="Selasa"
                                                        {{ old('hari', $item->hari) == 'Selasa' ? 'selected' : '' }}>Selasa
                                                    </option>
                                                    <option value="Rabu"
                                                        {{ old('hari', $item->hari) == 'Rabu' ? 'selected' : '' }}>Rabu
                                                    </option>
                                                    <option value="Kamis"
                                                        {{ old('hari', $item->hari) == 'Kamis' ? 'selected' : '' }}>Kamis
                                                    </option>
                                                    <option value="Jumat"
                                                        {{ old('hari', $item->hari) == 'Jumat' ? 'selected' : '' }}>Jumat
                                                    </option>
                                                    <option value="Sabtu"
                                                        {{ old('hari', $item->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu
                                                    </option>
                                                </select>
                                                @error('hari')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="JamMasuk">Jam Masuk</label>
                                                <input type="time"
                                                    class="form-control @error('jam_masuk') is-invalid @enderror"
                                                    id="JamMasuk" placeholder="Masukkan Jam Masuk" name="jam_masuk"
                                                    value="{{ old('jam_masuk') ?? $item->jam_masuk }}">
                                                @error('jam_masuk')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="Jam Keluar">Jam Keluar</label>
                                                <input type="time"
                                                    class="form-control @error('jam_keluar') is-invalid @enderror"
                                                    id="Jam Keluar" placeholder="Masukkan Jam Keluar" name="jam_keluar"
                                                    value="{{ old('jam_keluar') ?? $item->jam_keluar }}">
                                                @error('jam_keluar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Latitude</label>
                                                <input type="text"
                                                    class="form-control @error('latitude') is-invalid @enderror"
                                                    id="Latitude" placeholder="Masukkan Latitude" name="latitude"
                                                    value="{{ old('latitude') ?? $item->latitude }}">
                                                @error('latitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Longitude</label>
                                                <input type="text"
                                                    class="form-control @error('longitude') is-invalid @enderror"
                                                    id="Longitude" placeholder="Masukkan Longitude" name="longitude"
                                                    value="{{ old('longitude') ?? $item->longitude }}">
                                                @error('longitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <input type="hidden" name="id" id="editItemId">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                            <input type="hidden" name="id" value="{{ $item->id }}">
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
    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Jam Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulir untuk menambah data -->
                    <form action="{{ route('jam-kerja.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Hari</label>
                            <select class="form-control select2 @error('hari') is-invalid @enderror" style="width: 100%;"
                                name="hari">
                                <option selected="selected">Pilih</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                            @error('hari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="JamMasuk">Jam Masuk</label>
                            <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror"
                                id="JamMasuk" placeholder="Masukkan Jam Masuk" name="jam_masuk">
                            @error('jam_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Jam Keluar">Jam Keluar</label>
                            <input type="time" class="form-control @error('jam_keluar') is-invalid @enderror"
                                id="Jam Keluar" placeholder="Masukkan Jam Keluar" name="jam_keluar">
                            @error('jam_keluar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Latitude</label>
                            <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                id="Latitude" placeholder="Masukkan Latitude" name="latitude">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Longitude</label>
                            <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                id="Longitude" placeholder="Masukkan Longitude" name="longitude">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Tambah Jam Kerja</button>
                        </div>
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

            $('.edit-button').on('click', function() {
                let id = $(this).data('id');
                // Lakukan AJAX untuk mengambil data berdasarkan ID dan menampilkan dalam modal
                $.ajax({
                    type: 'GET',
                    url: '/jam-kerja/' + id + '/edit',
                    success: function(response) {
                        $('#editModal form').attr('action', '/jam-kerja/' + id);
                        $('#editModal input[name="id"]').val(response.id);
                        $('#editModal select[name="hari"]').val(response.hari);
                        $('#editModal input[name="jam_masuk"]').val(response.jam_masuk);
                        $('#editModal input[name="jam_keluar"]').val(response.jam_keluar);
                        $('#editModal input[name="latitude"]').val(response.latitude);
                        $('#editModal input[name="longitude"]').val(response.longitude);
                        $('#editModal-' + id).modal('show');
                        console.log(response);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

        });
    </script>
@endpush
