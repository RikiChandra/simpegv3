@extends('template.master')
@section('title', 'Pengajuan Cuti')
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
                    Tambah Pengajuan Cuti
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA KARYAWAN</th>
                        <th>JENIS CUTI</th>
                        <th>TANGGAL MULAI</th>
                        <th>TANGGAL SELESAI</th>
                        <th>JUMLAH HARI</th>
                        <th>SISA CUTI</th>
                        <th>ALASAN</th>
                        <th>KETERANGAN</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cutis as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->karyawan->nama }}</td>
                            <td>{{ $item->jenisCuti->jenis_cuti }}</td>
                            <td>{{ $item->tanggal_mulai }}</td>
                            <td>{{ $item->tanggal_selesai }}</td>
                            <td>{{ $item->jumlah_hari }} Hari</td>
                            <td>{{ $item->sisa_cuti }} Hari</td>
                            <td>{{ $item->alasan }}</td>
                            <td>{{ $item->keterangan }}</td>
                            @if ($item->status == 'Diproses')
                                <td>
                                    <div class="d-flex align-items-center">

                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#modalEditData-{{ $item->id }}"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        <div class="ml-2">
                                            <form id="deleteForm-{{ $item->id }}"
                                                action="{{ route('cuti.destroy', ['cuti' => $item->id]) }}" method="POST">
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
                                        <h5 class="modal-title" id="modalTambahDataLabel">Proses Pengajuan Cuti</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form untuk input data baru -->
                                        <form id="formEditData" action="{{ route('cuti.update', ['cuti' => $item->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="Diproses">Diproses</option>
                                                    <option value="Diterima">Diterima</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-info">Proses</button>
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
                    <form id="formTambahData" action="{{ route('cuti.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Jenis Cuti</label>
                            <select class="form-control select2" name="jenis_cuti_id" style="width: 100%;">
                                <option selected="selected">Pilih cuti yang ingin di ambil</option>
                                @foreach ($jenis_cutis as $item)
                                    <option value="{{ $item->id }}">{{ $item->jenis_cuti }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai Cuti</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai Cuti</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                        </div>
                        <div class="form-group">
                            <label for="alasan">Alasan mengajukan cuti</label>
                            <input type="text" class="form-control" id="alasan"
                                placeholder="alasan mengajukan cuti" name="alasan">
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
