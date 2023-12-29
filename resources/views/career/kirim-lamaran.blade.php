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
                            <label for="">Cover Letter</label>
                            <textarea id="summernote" name="cover_letter" class=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">
                                Resume
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
                                    <input type="file" id="fileUpload" accept="application/pdf" style="display: none;"
                                        onchange="updateFileName()" name="resume">
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
@section('script')
    <script>
        function updateFileName() {
            var input = document.getElementById('fileUpload');
            if (input.files.length > 0) {
                var fileName = input.files[0].name;
                document.getElementById('fileName').textContent = fileName;
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
@endsection
