@extends('template.master')
@section('title', 'Data Jenis Cuti')
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
                            <th>Jenis Cuti</th>
                            <th>Jatah Cuti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jenisCutis as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->jenis_cuti }}</td>
                                <td>{{ $item->jatah_cuti }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-warning mr-2" data-toggle="modal"
                                            data-target="#modalEditData-{{ $item->id }}" data-id="{{ $item->id }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form id="deleteForm-{{ $item->id }}"
                                            action="{{ route('jenis-cuti.destroy', ['jenisCuti' => $item->id]) }}"
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
                                                action="{{ route('jenis-cuti.update', ['jenisCuti' => $item->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="nama">Jenis Cuti</label>
                                                    <input type="text" class="form-control" id="nama"
                                                        value="{{ old('jenis_cuti') ?? $item->jenis_cuti }}"
                                                        name="jenis_cuti" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nilai">Jatah Cuti</label>
                                                    <input type="number" class="form-control" id="nilai"
                                                        value="{{ old('jatah_cuti') ?? $item->jatah_cuti }}"
                                                        name="jatah_cuti" required>
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
                    <h5 class="modal-title" id="modalTambahDataLabel">Tambah Data Jenis Cuti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk input data baru -->
                    <form id="formTambahData" action="{{ route('jenis-cuti.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Jenis Cuti</label>
                            <input type="text" class="form-control" id="nama" name="jenis_cuti" required>
                        </div>
                        <div class="form-group">
                            <label for="nilai">Jatah Cuti</label>
                            <input type="number" class="form-control" id="nilai" name="jatah_cuti" required>
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
