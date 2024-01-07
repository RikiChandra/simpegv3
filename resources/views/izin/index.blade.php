@extends('template.master')
@section('title', 'Data Izin')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahData">
                    Pengajuan Izin
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Alasan</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>File</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izins as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->karyawan->nama }}</td>
                                <td>{{ $item->alasan }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    @if ($item->file == null)
                                        <span class="badge badge-pill badge-danger">Tidak ada file</span>
                                    @else
                                        <a href="{{ asset('storage/' . $item->file) }}" class="btn btn-info"
                                            target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                </td>
                                @if ($item->status == 'Diproses')
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if (Auth::user()->role == 'hrd')
                                                <button type="button" class="btn btn-success" data-toggle="modal"
                                                    data-target="#modalEditData-{{ $item->id }}"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fas fa-check-circle"></i>
                                                    <!-- Ganti dengan ikon validasi sesuai kebutuhan -->
                                                </button>
                                            @endif
                                            <div class="ml-2">
                                                <form id="deleteForm-{{ $item->id }}"
                                                    action="{{ route('izin.destroy', ['izin' => $item->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger delete-button"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                @elseif ($item->status == 'Diterima')
                                    <td><span class="badge badge-pill badge-success">Diterima</span></td>
                                @else
                                    <td><span class="badge badge-pill badge-danger">Ditolak</span></td>
                                @endif

                            </tr>
                            <!-- Modal untuk input edit data -->
                            <div class="modal fade" id="modalEditData-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modalTambahDataLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTambahDataLabel">Validasi Izin</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form untuk input data baru -->
                                            <form id="formEditData"
                                                action="{{ route('izin.update', ['izin' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control select2" id="status" name="status">
                                                        <option value="Diproses">Diproses</option>
                                                        <option value="Diterima">Diterima</option>
                                                        <option value="Ditolak">Ditolak</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="keterangan">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
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
                    <h5 class="modal-title" id="modalTambahDataLabel">Tambah Pengajuan Izin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk input data baru -->
                    <form id="formTambahData" action="{{ route('izin.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Alasan</label>
                            <textarea class="form-control" id="keterangan" name="alasan" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="nilai">Tanggal</label>
                            <input type="date" class="form-control" id="nilai" name="tanggal" required>
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
