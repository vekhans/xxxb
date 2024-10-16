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
            <tr>
                <td>
                    <strong>Kriteria </strong>
                </td>
                <td>
                    <strong> : </strong>
                </td>
                <td>
                    <strong> {{ $kriterias->nama}} </strong>
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

                            <a href="{{ route('kriteria.index',[$periodes, $devisis, $kriterias]) }}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Kriteria</a>
                            <i class="fa fa-table"></i> Ubah Data Nilai Kriteria

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
                    <form method="POST" action="{{ route('nilai.update',[$periodes, $devisis, $kriterias,$nilais]) }}" data-parsley-validate class="forms form-horizontal form-label-left" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('nilai1') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nilai1">Nilai 1 Kriteria<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" value="{{$nilais->nilai1}}" id="nilai1" name="nilai1" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('nilai1'))
                                <span class="help-block">{{ $errors->first('nilai1') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('nilai2') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nilai2">Nilai 2 Kriteria<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" value="{{$nilais->nilai2}}" id="nilai2" name="nilai2" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('nilai2'))
                                <span class="help-block">{{ $errors->first('nilai2') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('bobot') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bobot">Bobot Kriteria<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" value="{{$nilais->bobot}}" id="bobot" name="bobot" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('bobot'))
                                <span class="help-block">{{ $errors->first('bobot') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                <input name="_method" type="hidden" value="PUT">
                                <button type="submit" class="btn btn-sm btn-warning"> <i class="fa fa-plus"></i> Ubah</button>
                                <a href="{{ route('nilai.index',[$periodes->id, $devisis, $kriterias]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-arrow-left"></i> Batal</a>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
