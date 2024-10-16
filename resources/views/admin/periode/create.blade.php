@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Tambah Data Periode</h3>
        <br>
        
        <hr/>
        @if(session('status'))
        <div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>{{session('status')}}</strong>
        </div>
        @endif
        <div class="clearfix"></div>
        <div class="card mb-3">
            <div class="card-header">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-9" style="text-align: left;"> 
                            <a href="{{route('rasaadmin')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</a>
                            <a href="{{route('periode.index')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Periode</a>
                            <i class="fa fa-table"></i> Tambah Data Periode

                        </div> 
                        <div class="col-md-3" style="text-align: right;"> 
                            <a href="{{route('periode.index')}}" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
               <div class="x_content">
                    <br />
                    <form  method="POST" action="{{ route('periode.store') }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" name="formPendaftaran" onsubmit="return validateForm()">
                        {{ csrf_field() }}
                        <h3>Tambah Data Periode</h3>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('tahun') ? ' has-error' : '' }}">
                                    <label class="col-md-3" for="tahun">Tahun 
                                    </label>
                                    <input type="number=" value="" id="tahun" name="tahun" class="col-md-6" placeholder="Tahun ">
                                    @if ($errors->has('tahun_masuk'))
                                    <span class="help-block">{{ $errors->first('tahun') }}</span>
                                    @endif                 
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="divs form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                    <label class="col-md-3" for="nama">Nama Periode  <span class="class="required">*</span>
                                    </label>
                                    <input type="text=" value="" id="nama" name="nama" class="col-md-6" placeholder="Nama Periode" required>
                                    @if ($errors->has('nama'))
                                   <span class="help-block">{{ $errors->first('nama') }}</span>
                                    @endif             
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="divs form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
                                    <label class="col-md-3" for="keterangan">Keterangan <span class="required">*</span>
                                    </label>
                                    <input type="text=" value="" id="keterangan" name="keterangan" class="col-md-6" placeholder="Keterangan" required>
                                    @if ($errors->has('keterangan'))
                                   <span class="help-block">{{ $errors->first('keterangan') }}</span>
                                    @endif             
                                </div>
                            </div>  
                        </div>
                        <div class="row mb-3"> 
                        </div>
                        <div class="row mb-12" style="justify-content: center;">
                            <div class="ln_solid"></div>
                            <div class="form-group" style="text-align: center;">
                                <div class="col-md-12 col-md-offset-3" >
                                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="ri-add-line"></i>Simpan</button>
                                    <!-- <hr> -->
                                    <a href="{{ route('periode.index') }}">
                                        <button class="btn btn-sm btn-secondary"><i class="ri-arrow-left-fill"></i>Kembali</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
@stop  
 