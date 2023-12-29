@extends('career.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <img src="https://plus.unsplash.com/premium_photo-1673709635732-c83149ac689d?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8ZWxlY3Ryb25pY3xlbnwwfHwwfHx8MA%3D%3D"
                        alt="" class="rounded float-start me-3 mr-2" width="100px" height="100px">
                    <div>
                        <h4 class="font-weight-bold">{{ $lowongans->nama_lowongan }}</h4>
                    </div>
                    <div class="ml-auto">
                        <a href="/career/{{ $lowongans->id }}/kirim-lamaran" class="btn btn-primary">Kirim Lamaran</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <p>{!! $lowongans->deskripsi !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
