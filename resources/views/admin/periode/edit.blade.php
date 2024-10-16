@extends('layouts.admin.admin')
@section('content')


<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Ubah Data Periode</h3>
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
                            <i class="fa fa-table"></i> Ubah Data Periode

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
                   
                    <form method="POST" action="{{ route('periode.update',$periodes->id) }}" data-parsley-validate class="forms form-horizontal form-label-left" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        

                    <div class="form-group{{ $errors->has('tahun') ? ' has-error' : '' }}">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun">Tahun<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" value="{{$periodes->tahun}}" id="tahun" name="tahun" class="form-control col-md-7 col-xs-12">
                            @if ($errors->has('tahun'))
                            <span class="help-block">{{ $errors->first('tahun') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama">Nama Periode<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" value="{{$periodes->nama}}" id="nama" name="nama" class="form-control col-md-7 col-xs-12">
                            @if ($errors->has('nama'))
                            <span class="help-block">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="keterangan">Keterangan<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" value="{{$periodes->keterangan}}" id="keterangan" name="keterangan" class="form-control col-md-7 col-xs-12">
                            @if ($errors->has('keterangan'))
                            <span class="help-block">{{ $errors->first('keterangan') }}</span>
                            @endif
                        </div>
                    </div>                    
                    <div class="ln_solid"></div>
                         <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                <input name="_method" type="hidden" value="PUT">
                                <button type="submit" class="btn btn-sm btn-warning"> <i class="fa fa-plus"></i> Ubah</button>
                                <a href="{{ route('periode.index') }}" class="btn btn-sm btn-secondary"><i class="fa fa-arrow-left"></i> Batal</a> 
                            </div>
                        </div>
                    </form>
                </div>
                 
            </div>
        </div>
    </div>
</div>


@endsection