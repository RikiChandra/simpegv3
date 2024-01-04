@extends('template.master')
@section('title', 'Edit Data Karyawan')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('karyawan.update', ['karyawan' => $karyawan->id]) }}" method="POST"
                enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="NamaPegawai">Nama Karyawan</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="NamaPegawai"
                        placeholder="Masukkan Nama Pegawai" name="nama" value="{{ old('nama') ?? $karyawan->nama }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Akun Pegawai</label>
                    <select class="form-control select2 @error('users_id') is-invalid @enderror" style="width: 100%;"
                        name="users_id">
                        <option value="" selected disabled>Pilih</option>
                        @foreach ($user as $item)
                            <option value="{{ $item->id }}"
                                {{ old('users_id', $karyawan->users_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->username }}
                            </option>
                        @endforeach
                    </select>
                    @error('users_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


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
                </div>
                <!-- Bagian Jenis Kelamin -->
                <div class="form-group">
                    <label for="JenisKelamin">Jenis Kelamin</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="LakiLaki" value="L"
                            {{ (old('jenis_kelamin') ?? $karyawan->jenis_kelamin) == 'L' ? 'checked' : '' }}>
                        <label class="form-check-label" for="LakiLaki">Laki-laki</label>
                        <i class="fas fa-male ml-2"></i>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="Perempuan" value="P"
                            {{ (old('jenis_kelamin') ?? $karyawan->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                        <label class="form-check-label" for="Perempuan">Perempuan</label>
                        <i class="fas fa-female ml-2"></i>
                    </div>
                    @error('jenis_kelamin')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="Alamat">Alamat</label>
                    <input type="text" class="form-control" id="Alamat" placeholder="Masukkan Alamat" name="alamat"
                        value="{{ old('alamat') ?? $karyawan->alamat }}">
                    @error('alamat')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="Telepon">Telepon</label>
                    <input type="text" class="form-control" id="Telepon" placeholder="Masukkan Nomor Telepon"
                        name="telepon" value="{{ old('telepon') ?? $karyawan->telepon }}">
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" class="form-control" id="Email" placeholder="Masukkan Alamat Email"
                        name="email" value="{{ old('email') ?? $karyawan->email }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div class="form-group">
                    <label for="TanggalLahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="TanggalLahir" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir') ?? $karyawan->tanggal_lahir }}">
                    @error('tanggal_lahir')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tempat Lahir -->
                <div class="form-group">
                    <label for="TempatLahir">Tempat Lahir</label>
                    <input type="text" class="form-control" id="TempatLahir" placeholder="Masukkan Tempat Lahir"
                        name="tempat_lahir" value="{{ old('tempat_lahir') ?? $karyawan->tempat_lahir }}">
                    @error('tempat_lahir')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Agama -->
                <div class="form-group">
                    <label for="Agama">Agama</label>
                    <select class="form-control" id="Agama" name="agama">
                        <option value="Islam" {{ (old('agama') ?? $karyawan->agama) == 'Islam' ? 'selected' : '' }}>Islam
                        </option>
                        <option value="Kristen Protestan"
                            {{ (old('agama') ?? $karyawan->agama) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen
                            Protestan</option>
                        <option value="Katolik" {{ (old('agama') ?? $karyawan->agama) == 'Katolik' ? 'selected' : '' }}>
                            Katolik</option>
                        <option value="Hindu" {{ (old('agama') ?? $karyawan->agama) == 'Hindu' ? 'selected' : '' }}>Hindu
                        </option>
                        <option value="Buddha" {{ (old('agama') ?? $karyawan->agama) == 'Buddha' ? 'selected' : '' }}>
                            Buddha</option>
                        <option value="Kong Hu Cu"
                            {{ (old('agama') ?? $karyawan->agama) == 'Kong Hu Cu' ? 'selected' : '' }}>Kong Hu Cu</option>
                        <option value="Kepercayaan Lainnya"
                            {{ (old('agama') ?? $karyawan->agama) == 'Kepercayaan Lainnya' ? 'selected' : '' }}>Kepercayaan
                            Lainnya</option>
                    </select>
                    @error('agama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pendidikan -->
                <div class="form-group">
                    <label for="Pendidikan">Pendidikan</label>
                    <select class="form-control" id="Pendidikan" name="pendidikan">
                        <option value="SD"
                            {{ (old('pendidikan') ?? $karyawan->pendidikan) == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP"
                            {{ (old('pendidikan') ?? $karyawan->pendidikan) == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA/SMK"
                            {{ (old('pendidikan') ?? $karyawan->pendidikan) == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK
                        </option>
                        <option value="Diploma/D1-D4"
                            {{ (old('pendidikan') ?? $karyawan->pendidikan) == 'Diploma/D1-D4' ? 'selected' : '' }}>
                            Diploma/D1-D4</option>
                        <option value="Sarjana/S1"
                            {{ (old('pendidikan') ?? $karyawan->pendidikan) == 'Sarjana/S1' ? 'selected' : '' }}>Sarjana/S1
                        </option>
                        <option value="Magister/S2"
                            {{ (old('pendidikan') ?? $karyawan->pendidikan) == 'Magister/S2' ? 'selected' : '' }}>
                            Magister/S2</option>
                        <option value="Doktor/S3"
                            {{ (old('pendidikan') ?? $karyawan->pendidikan) == 'Doktor/S3' ? 'selected' : '' }}>Doktor/S3
                        </option>
                    </select>
                    @error('pendidikan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jabatan -->
                <div class="form-group">
                    <label for="Jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="Jabatan" placeholder="Masukkan Jabatan"
                        name="jabatan" value="{{ old('jabatan') ?? $karyawan->jabatan }}">
                    @error('jabatan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="aktif" {{ (old('status') ?? $karyawan->status) == 'aktif' ? 'selected' : '' }}>
                            Aktif</option>
                        <option value="tidak aktif"
                            {{ (old('status') ?? $karyawan->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nomor KTP -->
                <div class="form-group">
                    <label for="NoKTP">Nomor KTP</label>
                    <input type="text" class="form-control" id="NoKTP" placeholder="Masukkan Nomor KTP"
                        name="no_ktp" value="{{ old('no_ktp') ?? $karyawan->no_ktp }}">
                    @error('no_ktp')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nomor Rekening -->
                <div class="form-group">
                    <label for="NoRekening">Nomor Rekening</label>
                    <input type="text" class="form-control" id="NoRekening" placeholder="Masukkan Nomor Rekening"
                        name="no_rekening" value="{{ old('no_rekening') ?? $karyawan->no_rekening }}">
                    @error('no_rekening')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

            </form>
        </div>
    </div>
    {{-- <div class="card">
        <div class="card-body">
            <form action="{{ route('karyawan.update', ['karyawan' => $karyawan->id]) }}" method="post">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="NamaPegawai">Nama Karyawan</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="NamaPegawai"
                        placeholder="Masukkan Nama Pegawai" name="nama" value="{{ old('nama') ?? $karyawan->nama }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="Foto">Foto</label>
                    <div class="custom-file">
                        <input type="hidden" name="oldImage" value="{{ $karyawan->gambar }}">
                        <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" id="Foto"
                            name="foto" onchange="previewImage(event)">
                        <label class="custom-file-label" for="Foto">Pilih foto</label>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit">update</button>

            </form>
        </div>
    </div> --}}
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
@endpush
