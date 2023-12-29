@extends('template.master')
@section('title', 'Tambah Data Lowongan')
@section('content')
    <div class="card">
        <form action="{{ route('lowongan.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group col-md-6">
                    <label for="NamaLowongan">Nama Lowongan</label>
                    <input type="text" class="form-control @error('nama_lowongan') is-invalid @enderror" id="NamaLowongan"
                        placeholder="Masukkan Nama Lowongan" name="nama_lowongan">
                    @error('nama_lowongan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Jenis Pekerjaan</label>
                    <select class="form-control select2 @error('jenis_pekerjaan') is-invalid @enderror" style="width: 100%;"
                        name="jenis_pekerjaan">
                        <option selected="selected">Pilih</option>
                        <option value="Full Time">Full Time</option>
                        <option value="Contract">Contract</option>
                        <option value="Intership">Intership</option>
                    </select>
                    @error('jenis_pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col">
                    <label for="">Deskripsi Pekerjaan</label>
                    <textarea id="summernote" name="deskripsi" class="@error('deskripsi') is-invalid @enderror"></textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('lowongan.index') }}" class="btn btn-default mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote();
        });
    </script>
@endsection
