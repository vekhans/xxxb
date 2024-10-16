@extends('layouts.temp.depan')
@section('content') 
<section class="page-section bg-secondary" id="services">
    <div class="container px-4 px-lg-5">
        <h2 class="text-center text-primary mt-0">Data Periode</h2>
        <p class="text-center text-info mb-0">Cetak data ranking per periode</p>
        <hr class="divider" />
        <div class="row gx-4 gx-lg-5">                 
            @foreach($periodeobj as $periode)
            <div class="col-lg-3 col-md-6 text-center">
                <div class="mt-5">
                    <div class="mb-2"><i class="bi-gem fs-1 text-primary"></i></div>
                    <h3 class="h4 text-warning mb-2">{{$periode->tahun}}</h3>
                    <p class="text-info mb-0">{{$periode->nama}}</p>
                    <div class="text-center"> 
                        <br>
                        <a class="btn btn-success btn-sm" href=" {{ route('rekapanz',[$periode])}}">Cetak Data Ranking</a>
                        <br>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>       
@endsection