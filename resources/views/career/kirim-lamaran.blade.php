@extends('career.main')
@section('content')
    <style>
        .upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            padding: 2rem;
            border: 1px dashed #000;
            border-radius: 5px;
        }

        .btn-upload {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            font-size: 14px;
            margin-top: 1rem;
        }

        .btn-upload:hover {
            background-color: #e6e6e6;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <img src="https://plus.unsplash.com/premium_photo-1673709635732-c83149ac689d?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8ZWxlY3Ryb25pY3xlbnwwfHwwfHx8MA%3D%3D"
                        alt="" class="rounded float-start me-3 mr-2" width="100px" height="100px">
                    <div>
                        <h4 class="font-weight-bold">{{ $lowongans->nama_lowongan }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('career.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="lowongan_id" value="{{ $lowongans->id }}">
                        <div class="form-group">
                            <label for="Foto">Foto</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('foto') is-invalid @enderror"
                                    id="Foto" name="foto" onchange="previewImage(event)">
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
                            <label for="NamaLengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" id="NamaLengkap" placeholder="Masukkan Nama Lengkap"
                                name="nama_lengkap">
                        </div>
                        <div class="form-group">
                            <label for="NomorTelepon">Nomor Telepon (Indonesia)</label>
                            <input type="tel" class="form-control" id="NomorTelepon"
                                placeholder="Masukkan Nomor Telepon (ex: +6281234567890)" name="nomor_telepon">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Masukkan Email Anda"
                                name="email">
                        </div>
                        <div class="form-group">
                            <label for="Alamat">Alamat</label>
                            <textarea class="form-control" id="Alamat" rows="3" placeholder="Masukkan Alamat Lengkap Anda" name="alamat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="JenisKelamin">Jenis Kelamin</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="LakiLaki"
                                    value="L">
                                <label class="form-check-label" for="LakiLaki">Laki-laki</label>
                                <i class="fas fa-male ml-2"></i> <!-- Icon male dari Font Awesome -->
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="Perempuan"
                                    value="P">
                                <label class="form-check-label" for="Perempuan">Perempuan</label>
                                <i class="fas fa-female ml-2"></i> <!-- Icon female dari Font Awesome -->
                            </div>
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
                            <label for="">
                                Upload CV
                            </label>
                            <div class="upload-container"
                                style="padding: 20px; border: 1px dashed #000; border-radius: 5px; cursor: pointer;">
                                <div class="text-center" onclick="document.getElementById('fileUpload').click();">
                                    <div class="mb-4">
                                        <div style="font-size: 48px; color: #3F3F46;">&#128193;</div>
                                        <h3 class="mt-3" id="fileName"></h3>
                                        <div class="text-secondary">Unggah berkas dalam format PDF (maksimal 2MB)</div>
                                    </div>
                                    <button class="btn-upload"
                                        style="background-color: #f2f2f2; border: 1px solid #ccc; border-radius: 5px; padding: 10px 20px; cursor: pointer; font-size: 14px;"
                                        onclick="event.stopPropagation(); document.getElementById('fileUpload').click();">Ganti</button>
                                    <input type="file" id="fileUpload" accept="application/pdf"
                                        style="display: none;" onchange="updateFileName()" name="resume">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">
                                Upload Ijazah
                            </label>
                            <div class="upload-container"
                                style="padding: 20px; border: 1px dashed #000; border-radius: 5px; cursor: pointer;">
                                <div class="text-center" onclick="document.getElementById('fileUpload1').click();">
                                    <div class="mb-4">
                                        <div style="font-size: 48px; color: #3F3F46;">&#128193;</div>
                                        <h3 class="mt-3" id="fileName1"></h3>
                                        <div class="text-secondary">Unggah berkas dalam format PDF (maksimal 2MB)</div>
                                    </div>
                                    <button class="btn-upload"
                                        style="background-color: #f2f2f2; border: 1px solid #ccc; border-radius: 5px; padding: 10px 20px; cursor: pointer; font-size: 14px;"
                                        onclick="event.stopPropagation(); document.getElementById('fileUpload').click();">Ganti</button>
                                    <input type="file" id="fileUpload1" accept="application/pdf"
                                        style="display: none;" onchange="updateFileName1()" name="ijazah">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">
                                Upload Foto KTP
                            </label>
                            <div class="upload-container"
                                style="padding: 20px; border: 1px dashed #000; border-radius: 5px; cursor: pointer;">
                                <div class="text-center" onclick="document.getElementById('fileUpload2').click();">
                                    <div class="mb-4">
                                        <div style="font-size: 48px; color: #3F3F46;">&#128193;</div>
                                        <h3 class="mt-3" id="fileName2"></h3>
                                        <div class="text-secondary">Unggah berkas dalam format Jpg dll (maksimal 2MB)</div>
                                    </div>
                                    <button class="btn-upload"
                                        style="background-color: #f2f2f2; border: 1px solid #ccc; border-radius: 5px; padding: 10px 20px; cursor: pointer; font-size: 14px;"
                                        onclick="event.stopPropagation(); document.getElementById('fileUpload').click();">Ganti</button>
                                    <input type="file" id="fileUpload2" accept="application/image"
                                        style="display: none;" onchange="updateFileName2()" name="ktp">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="portofolio">Portofolio</label>
                            <input type="text" class="form-control" id="portofolio"
                                placeholder="Masukkan Link Portofolio Anda. Jika tidak ada, isi dengan '-'"
                                name="portofolio">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <a href="/career/{{ $lowongans->id }}/detail" class="btn btn-default mr-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function updateFileName() {
            var input = document.getElementById('fileUpload');
            if (input.files.length > 0) {
                var fileName = input.files[0].name;
                document.getElementById('fileName').textContent = fileName;
            }
        }

        function updateFileName1() {
            var input = document.getElementById('fileUpload1');
            if (input.files.length > 0) {
                var fileName = input.files[0].name;
                document.getElementById('fileName1').textContent = fileName;
            }
        }

        function updateFileName2() {
            var input = document.getElementById('fileUpload2');
            if (input.files.length > 0) {
                var fileName = input.files[0].name;
                document.getElementById('fileName2').textContent = fileName;
            }
        }
        document.getElementById('NomorTelepon').addEventListener('input', function(e) {
            let phoneNumber = e.target.value.trim();
            if (phoneNumber.startsWith('08')) {
                phoneNumber = '+62' + phoneNumber.slice(
                    2);
                document.getElementById('NomorTelepon').value = phoneNumber;
            }
        });
        $(function() {
            // Summernote
            $('#summernote').summernote();
        });
    </script>
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
