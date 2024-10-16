@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper"> 
    <div class="container-fluid">       
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>

            <div class="card-body">
                @if(session('status'))
          <div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>{{session('status')}}</strong>
          </div>
        @endif
                <br>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <h6 style="color: yellow">
                                    ADMIN
                                </h6>
                                <br> 
                                <strong> 
                                     {{ ucwords (Auth::user()->name) }}
                                </strong>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="
                                <?php if (Auth::user()->kategori === 'Admin'): ?>
                                        {{ route('admin.show',Auth::user()->id)}}
                                <?php endif ?>
                                <?php if (Auth::user()->kategori === 'Pimpinan'): ?>
                                  {{ route('admins.show',Auth::user()->id)}}
                                <?php endif ?>">View Details</a>
                                <div class="small text-white">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                JUMLAH PERIODE
                                <br>
                                <strong>
                                     {{$jumlahperiode}}
                                </strong>
                                 
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{ route('periode.index') }}">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">
                                JUMLAH KRITERIA
                                <br>
                                <strong>
                                     {{$jumlahkriteria}}
                                </strong>
                                 
                            </div>
                             
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-secondary text-white mb-4">
                            <div class="card-body">
                                JUMLAH ALTERNATIF
                                <br>
                                <strong>
                                     {{$jumlahalternatif}}
                                </strong>
                            </div>
                             
                        </div>
                    </div>     
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection