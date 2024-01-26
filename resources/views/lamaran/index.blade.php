@extends('template.master')
@section('title', 'Data Lowongan')
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
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelamar</th>
                        <th>Lowongan</th>
                        <th>Email</th>
                        <th>No Telpon</th>
                        <th>Portofolio</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lamarans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ optional($item->lowongan)->nama_lowongan }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->nomor_telepon }}</td>
                            @if ($item->portofolio == '-')
                                <td>Tidak Ada Portofolio</td>
                            @else
                                <td><a href="{{ $item->portofolio }}" target="_blank">{{ $item->portofolio }}</a></td>
                            @endif
                            @if ($item->status == 'Diterima')
                                <td><span class="badge badge-success">{{ $item->status }}</span></td>
                            @elseif($item->status == 'Ditolak')
                                <td><span class="badge badge-danger">{{ $item->status }}</span></td>
                            @else
                                <td>
                                    <div class="d-flex">
                                        <span class="badge badge-warning my-2 mr-2">{{ $item->status }}</span>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                    data-target="#modalEditData-{{ $item->id }}"
                                                    data-id="{{ $item->id }}">Proses</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                    data-target="#modalShowData-{{ $item->id }}"
                                                    data-id="{{ $item->id }}">Detail</a>
                                                <div role="separator" class="dropdown-divider"></div>
                                                <!-- Modal Show -->
                                                <button type="button" class="dropdown-item view-pdf-button"
                                                    data-url="{{ $item->resume }}" data-toggle="modal"
                                                    data-target="#showModal{{ $item->id }}">Resume</button>

                                                <!-- Modal Hapus -->
                                                <form action="/lamaran/{{ $item->id }}/delete" method="post"
                                                    id="deleteForm-{{ $item->id }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="dropdown-item delete-button"
                                                        data-id="{{ $item->id }}" data-toggle="modal"
                                                        data-target="#deleteModal{{ $item->id }}">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            @endif
                        </tr>
                        <!-- Modal untuk input edit data -->
                        <div class="modal fade" id="modalEditData-{{ $item->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="modalTambahDataLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTambahDataLabel">Validasi Lamaran</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form untuk input data baru -->
                                        <form id="formEditData"
                                            action="{{ route('lamaran.update', ['lamaran' => $item->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control select2" id="status" name="status">
                                                    <option value="Diproses">Diproses</option>
                                                    <option value="Diterima">Diterima</option>
                                                    <option value="Interview">Interview</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="tanggalGroup" style="display: none;">
                                                <label for="TanggalLahir">Tanggal</label>
                                                <input type="date" class="form-control" id="TanggalLahir" name="tanggal">
                                            </div>
                                            <div class="form-group" id="keteranganGroup" style="display: none;">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                            </div>
                                            <input type="hidden" name="foto" value="{{ $item->foto }}">
                                            <input type="hidden" name="nama" value="{{ $item->nama_lengkap }}">
                                            <input type="hidden" name="email" value="{{ $item->email }}">
                                            <input type="hidden" name="telepon" value="{{ $item->nomor_telepon }}">
                                            <input type="hidden" name="alamat" value="{{ $item->alamat }}">
                                            <input type="hidden" name="tempat_lahir" value="{{ $item->tempat_lahir }}">
                                            <input type="hidden" name="tanggal_lahir"
                                                value="{{ $item->tanggal_lahir }}">
                                            <input type="hidden" name="agama" value="{{ $item->agama }}">
                                            <input type="hidden" name="pendidikan" value="{{ $item->pendidikan }}">
                                            <input type="hidden" name="jenis_kelamin"
                                                value="{{ $item->jenis_kelamin }}">

                                            <button type="submit" class="btn btn-warning">Proses</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal untuk show data -->
                        <div class="modal fade" id="modalShowData-{{ $item->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="modalTambahDataLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTambahDataLabel">Detail Lamaran</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fotoPelamar">Foto</label>
                                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="foto pelamar"
                                                        class="img-fluid" name="foto" height="400px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama_lengkap">Nama Lengkap</label>
                                                    <input type="text" readonly class="form-control" id="nama_lengkap"
                                                        value="{{ $item->nama_lengkap }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">No Telepon</label>
                                                <input type="text" readonly class="form-control" id="noTelpon"
                                                    value="{{ $item->nomor_telepon }}">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Resume</label>
                                                <div class="form-group">
                                                    <iframe src="{{ asset('storage/' . $item->resume) }}" width="100%"
                                                        height="400px"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Ijazah</label>
                                                <div class="form-group">
                                                    <iframe src="{{ asset('storage/' . $item->ijazah) }}" width="100%"
                                                        height="400px"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">KTP</label>
                                                <div class="form-group">
                                                    <img src="{{ asset('storage/' . $item->ktp) }}" alt="Foto KTP"
                                                        style="width: 85.60mm; height: 53.98mm;">
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
    <!-- Tambahkan modal ke dalam HTML -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tempatkan PDF view di sini -->
                    <iframe id="pdfEmbed" src="" width="100%" height="600px" frameborder="0"
                        type="application/pdf"></iframe>
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
        $(document).ready(function() {
            // Saat tombol "lihat" diklik
            $('.view-pdf-button').on('click', function() {
                let pdfPath = $(this).data('url'); // Ambil path PDF dari data URL tombol
                let pdfUrl = '{{ asset('storage/') }}' + '/' + pdfPath; // Gabungkan dengan URL dasar

                // Ubah src dari iframe dengan URL PDF yang sesuai
                $('#pdfEmbed').attr('src', pdfUrl);

                // Tampilkan modal
                $('#pdfModal').modal('show');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#status').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue === 'Interview') {
                    $('#tanggalGroup').show();
                    $('#keteranganGroup').hide();
                } else if (selectedValue === 'Diterima') {
                    $('#tanggalGroup').hide();
                    $('#keteranganGroup').hide();
                } else if (selectedValue === 'Ditolak') {
                    $('#tanggalGroup').hide();
                    $('#keteranganGroup').show();
                } else {
                    $('#tanggalGroup').hide();
                    $('#keteranganGroup').hide();
                }
            });
        });
    </script>
@endpush
