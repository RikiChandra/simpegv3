@extends('career.main')
@section('title', 'Daftar Lowongan Pekerjaan')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @foreach ($lowongans as $item)
                <a href="/career/{{ $item->id }}/detail" class="text-decoration-none">
                    <div class="card" id="card">
                        <div class="card-body d-flex">
                            <img src="https://plus.unsplash.com/premium_photo-1673709635732-c83149ac689d?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8ZWxlY3Ryb25pY3xlbnwwfHwwfHx8MA%3D%3D"
                                alt="" class="rounded float-start me-3 mr-2" width="100px" height="100px">
                            <div>
                                <h5 class="card-title"><strong>{{ $item->nama_lowongan }}</strong></h5>
                                <p class="card-text">
                                    {{ $item->excerpt }}
                                </p>
                                <a href="#" class="">{{ $item->jenis_pekerjaan }}</a>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
