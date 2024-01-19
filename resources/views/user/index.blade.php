@extends('template.master')
@section('title', 'DATA PENGGUNA')
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
                            <th>Username</th>
                            <th>Email</th>
                            <th>Hak Akses</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->role }}</td>
                                @if ($item->is_active == 1)
                                    <td><span class="badge badge-pill badge-success">Aktif</span></td>
                                @else
                                    <td><span class="badge badge-pill badge-danger">Tidak Aktif</span></td>
                                @endif
                                <td>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-warning mr-2" data-toggle="modal"
                                            data-target="#modalEditData-{{ $item->id }}" data-id="{{ $item->id }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal untuk input edit data -->
                            <div class="modal fade" id="modalEditData-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modalTambahDataLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTambahDataLabel">Edit Pengguna</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form untuk input data baru -->
                                            <form id="formEditData"
                                                action="{{ route('user.update', ['user' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="nama">Username</label>
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" value="{{ old('username') ?? $item->username }}"
                                                        disabled required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nilai">Email</label>
                                                    <input type="email" class="form-control" id="" name="email"
                                                        value="{{ old('email') ?? $item->email }}" required disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Hak Akses</label>
                                                    <select class="form-control" id="status" name="role">
                                                        <option value="direktur"
                                                            {{ (old('role') ?? $item->role) == 'direktur' ? 'selected' : '' }}>
                                                            Direktur</option>
                                                        <option value="karyawan"
                                                            {{ (old('role') ?? $item->role) == 'karyawan' ? 'selected' : '' }}>
                                                            Karyawan</option>
                                                        <option value="hrd"
                                                            {{ (old('role') ?? $item->role) == 'hrd' ? 'selected' : '' }}>
                                                            HRD</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Is Active</label>
                                                    <select class="form-control" id="status" name="is_active">
                                                        <option value="1"
                                                            {{ (old('is_active') ?? $item->is_active) == 1 ? 'selected' : '' }}>
                                                            Aktif
                                                        </option>
                                                        <option value="0"
                                                            {{ (old('is_active') ?? $item->is_active) == 0 ? 'selected' : '' }}>
                                                            Tidak Aktif
                                                        </option>
                                                    </select>
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
                    <h5 class="modal-title" id="modalTambahDataLabel">Tambah Data Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk input data baru -->
                    <form id="formTambahData" action="{{ route('user.tambahPengguna') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="nilai">Email</label>
                            <input type="email" class="form-control" id="" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Hak Akses</label>
                            <select class="form-control" id="status" name="role">
                                <option value="direktur">Direktur</option>
                                <option value="karyawan">Karyawan</option>
                                <option value="hrd">HRD</option>
                            </select>
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
