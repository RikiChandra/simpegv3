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
                        <th>Aksi</th>
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
                                <td><span class="badge badge-warning">{{ $item->status }}</span></td>
                            @endif
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Proses</a>
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

                            </td>

                        </tr>
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
@endpush
