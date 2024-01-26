@extends('template.master')
@section('title', 'Data Karyawan')
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
                <a href="{{ route('karyawan.create') }}" class="btn btn-primary">Tambah Data</a>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="img-fluid"
                                    width="100">
                            </td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('karyawan.edit', $item->id) }}" class="btn btn-warning mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- <form action="{{ route('karyawan.destroy', $item->id) }}" method="post"
                                        id="deleteForm-{{ $item->id }}">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger delete-button"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form> --}}
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#modalShowData-{{ $item->id }}" data-id="{{ $item->id }}">
                                        <i class="fas fa-eye"></i>
                                        <!-- Ganti dengan ikon validasi sesuai kebutuhan -->
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="modalShowData-{{ $item->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="modalTambahDataLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTambahDataLabel">Detail Karyawan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fotoPelamar">Foto</label><br>
                                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="foto pelamar"
                                                        name="foto" height="200px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama_lengkap">Nama Lengkap</label>
                                                    <input type="text" readonly class="form-control" id="nama_lengkap"
                                                        value="{{ $item->nama }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">No Telepon</label>
                                                <input type="text" readonly class="form-control" id="noTelpon"
                                                    value="{{ $item->telepon }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama_lengkap">Jenis Kelamin</label><br>
                                                    @if ($item->jenis_kelamin == 'L')
                                                        <input type="text" readonly class="form-control"
                                                            id="jenis_kelamin" value="Laki-laki">
                                                    @else
                                                        <input type="text" readonly class="form-control"
                                                            id="jenis_kelamin" value="Perempuan">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Email</label>
                                                <input type="text" readonly class="form-control" id="noTelpon"
                                                    value="{{ $item->email }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <input type="text" readonly class="form-control" id="alamat"
                                                        value="{{ $item->alamat }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Tanggal Lahir</label>
                                                <input type="text" readonly class="form-control" id="ttl"
                                                    value="{{ $item->tanggal_lahir }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                    <input type="text" readonly class="form-control" id="tempat_lahir"
                                                        value="{{ $item->tempat_lahir }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Agama</label>
                                                <input type="text" readonly class="form-control" id="agama"
                                                    value="{{ $item->agama }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pendidikan">Pendidikan</label>
                                                    <input type="text" readonly class="form-control" id="pendidikan"
                                                        value="{{ $item->pendidikan }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pendidikan">No KTP</label>
                                                    <input type="text" readonly class="form-control" id="pendidikan"
                                                        value="{{ $item->no_ktp }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pendidikan">No Rekening</label>
                                                    <input type="text" readonly class="form-control" id="pendidikan"
                                                        value="{{ $item->no_rekening }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pendidikan">Bank</label>
                                                    <input type="text" readonly class="form-control" id="pendidikan"
                                                        value="{{ $item->bank }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
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
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
