@extends('template.master')
@section('title', 'Edit Data Lowongan')
@section('content')
    <div class="card">
        <form action="{{ route('lowongan.update', ['lowongan' => $lowongan->id]) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="card-body">
                <div class="form-group col-md-6">
                    <label for="NamaLowongan">Nama Lowongan</label>
                    <input type="text" class="form-control" id="NamaLowongan" placeholder="Masukkan Nama Lowongan"
                        name="nama_lowongan" value="{{ old('nama_lowongan') ?? $lowongan->nama_lowongan }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Jenis Pekerjaan</label>
                    <select class="form-control select2" style="width: 100%;" name="jenis_pekerjaan">
                        <option value="" selected disabled>Pilih</option>
                        <option value="Full Time" {{ $lowongan->jenis_pekerjaan == 'Full Time' ? 'selected' : '' }}>Full
                            Time</option>
                        <option value="Contract" {{ $lowongan->jenis_pekerjaan == 'Contract' ? 'selected' : '' }}>Contract
                        </option>
                        <option value="Intership" {{ $lowongan->jenis_pekerjaan == 'Intership' ? 'selected' : '' }}>
                            Intership</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="WaktuMulai">Waktu Mulai</label>
                    <input type="date" class="form-control @error('batas_waktu_mulai') is-invalid @enderror"
                        id="WaktuMulai" name="batas_waktu_mulai"
                        value="{{ old('batas_waktu_mulai') ?? $lowongan->batas_waktu_mulai }}">
                    @error('batas_waktu_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="WaktuSelesai">Waktu Selesai</label>
                    <input type="date" class="form-control @error('batas_waktu_selesai') is-invalid @enderror"
                        id="WaktuSelesai" name="batas_waktu_selesai"
                        value="{{ old('batas_waktu_selesai') ?? $lowongan->batas_waktu_selesai }}">
                    @error('batas_waktu_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col">
                    <label for="">Deskripsi Pekerjaan</label>
                    <textarea id="summernote" name="deskripsi">{{ old('deskripsi') ?? $lowongan->deskripsi }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('lowongan.index') }}" class="btn btn-default mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote()
        })
    </script>
@endpush
