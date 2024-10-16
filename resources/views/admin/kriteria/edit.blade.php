@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Ubah Data Kriteria</h3> 
        <br>
        <table>
            <tr>
                <td>                    
                    <strong>Periode </strong>
                </td>
                <td>
                    <strong> : </strong>
                </td>
                <td>
                    <strong> {{ $periodes->tahun }} - {{ $periodes->nama }} </strong>
                </td>
            </tr>
            <tr>
                <td>                    
                    <strong>Divisi </strong>
                </td>
                <td>
                    <strong> : </strong>
                </td>
                <td>
                    <strong> {{ $devisis->nama}} </strong>
                </td>
            </tr>
        </table> 
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
                            <a href="{{route('devisi.index',[$periodes])}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Divisi</a>
                            <a href="{{ route('kriteria.index',[$periodes, $devisis]) }}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Kriteria</a>
                            <i class="fa fa-table"></i> Ubah Data Kriteria

                        </div> 
                        <div class="col-md-3" style="text-align: right;"> 
                            <a href="{{ route('kriteria.index',[$periodes->id, $devisis->id]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
               <div class="x_content">
                    <br />
                    <form method="POST" action="{{ route('kriteria.update',[$periodes, $devisis, $kriterias]) }}" data-parsley-validate class="forms form-horizontal form-label-left" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">Kode<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" value="{{$kriterias->kode}}" id="kode" name="kode" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('kode'))
                                <span class="help-block">{{ $errors->first('kode') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama">Nama Kriteria<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" value="{{$kriterias->nama}}" id="nama" name="nama" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('nama'))
                                <span class="help-block">{{ $errors->first('nama') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5 form-group{{ $errors->has('atribut') ? ' has-error' : '' }}"  >
                            <label for="atribut" class="control-label">Atribut</label>
                            <div>
                                <select class="form-control" name="atribut" id="atribut">
                                    @foreach($atribut as $v)
                                    <option value="{{ $v }}" {{$kriterias->atribut == $v ? 'selected="selected"' : ''}}> {{ $v}} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('atribut'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('atribut') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                <input name="_method" type="hidden" value="PUT">
                                <button type="submit" class="btn btn-sm btn-warning"> <i class="fa fa-plus"></i> Ubah</button>
                                <a href="{{ route('kriteria.index',[$periodes->id, $devisis]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-arrow-left"></i> Batal</a> 
                            </div>
                        </div>
                    </form>
                    
                </div>
                 
            </div>
        </div>
    </div>
</div> 
@endsection