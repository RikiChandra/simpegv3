@extends('template.master')
@section('title', 'Tambah Data Karyawan')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="NamaPegawai">Nama Karyawan</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="NamaPegawai"
                        placeholder="Masukkan Nama Pegawai" name="nama">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="users_id">Akun Pegawai</label>
                    <select class="form-control select2 @error('users_id') is-invalid @enderror" style="width: 100%;"
                        name="users_id" id="users_id">
                        <option value="" selected disabled>Pilih</option>
                        @foreach ($user as $item)
                            <option value="{{ $item->id }}" data-email="{{ $item->email }}">{{ $item->username }}
                            </option>
                        @endforeach
                    </select>
                    @error('users_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Upload foto -->
                <div class="form-group">
                    <label for="Foto">Foto</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" id="Foto"
                            name="foto" onchange="previewImage(event)">
                        <label class="custom-file-label" for="Foto">Pilih foto</label>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <img id="preview" src="#" alt="Foto Karyawan" class="mt-2 img-fluid"
                        style="max-width: 150px; display: none;">
                    <!-- Untuk menampilkan preview foto -->
                </div>
                <div class="form-group">
                    <label for="JenisKelamin">Jenis Kelamin</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="LakiLaki" value="L">
                        <label class="form-check-label" for="LakiLaki">Laki-laki</label>
                        <i class="fas fa-male ml-2"></i> <!-- Icon male dari Font Awesome -->
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="Perempuan" value="P">
                        <label class="form-check-label" for="Perempuan">Perempuan</label>
                        <i class="fas fa-female ml-2"></i> <!-- Icon female dari Font Awesome -->
                    </div>
                </div>
                <div class="form-group">
                    <label for="Alamat">Alamat</label>
                    <input type="text" class="form-control" id="Alamat" placeholder="Masukkan Alamat" name="alamat">
                </div>
                <div class="form-group">
                    <label for="Telepon">Telepon</label>
                    <input type="text" class="form-control" id="Telepon" placeholder="Masukkan Nomor Telepon"
                        name="telepon">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Masukkan Alamat Email"
                        name="email">
                </div>
                <div class="form-group">
                    <label for="TanggalLahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="TanggalLahir" name="tanggal_lahir">
                </div>
                <div class="form-group">
                    <label for="TempatLahir">Tempat Lahir</label>
                    <input type="text" class="form-control" id="TempatLahir" placeholder="Masukkan Tempat Lahir"
                        name="tempat_lahir">
                </div>
                <div class="form-group">
                    <label for="Agama">Agama</label>
                    <select class="form-control" id="Agama" name="agama">
                        <option value="Islam">Islam</option>
                        <option value="Kristen Protestan">Kristen Protestan</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Kong Hu Cu">Kong Hu Cu</option>
                        <option value="Kepercayaan Lainnya">Kepercayaan Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Pendidikan">Pendidikan</label>
                    <select class="form-control" id="Pendidikan" name="pendidikan">
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA/SMK">SMA/SMK</option>
                        <option value="Diploma/D1-D4">Diploma/D1-D4</option>
                        <option value="Sarjana/S1">Sarjana/S1</option>
                        <option value="Magister/S2">Magister/S2</option>
                        <option value="Doktor/S3">Doktor/S3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="Jabatan" placeholder="Masukkan Jabatan"
                        name="jabatan">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="NoKTP">Nomor KTP</label>
                    <input type="text" class="form-control" id="NoKTP" placeholder="Masukkan Nomor KTP"
                        name="no_ktp" maxlength="16">
                </div>
                <div class="form-group">
                    <label for="NoNik">NIK Karyawan</label>
                    <input type="text" class="form-control" id="NoNik" placeholder="Masukkan Nomor NIK Pegawai"
                        name="nik_pegawai">
                </div>
                <div class="form-group">
                    <label for="NoRekening">Nomor Rekening</label>
                    <input type="text" class="form-control" id="NoRekening" placeholder="Masukkan Nomor Rekening"
                        name="no_rekening">
                </div>
                <div class="form-group">
                    <label for="bank">Bank</label>
                    <select class="form-control" id="bank" name="bank">
                        <option value="BCA">Bank Central Asia</option>
                        <option value="Mandiri">Bank Mandiri</option>
                        <option value="BNI">BNI</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block'; // Menampilkan preview foto
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script>
        $(document).ready(function() {
            // Handle change event of the user selection
            $('#users_id').on('change', function() {
                // Get the selected option
                var selectedOption = $(this).find(':selected');

                // Update the email field with the data-email attribute of the selected option
                $('#email').val(selectedOption.data('email'));
            });
        });
    </script>
@endpush
