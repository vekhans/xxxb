@extends('layouts.admin.phome')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <div class="inliner">
            <h3>Ubah Data Nilai Bobot Kriteria</h3>
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

        </div>
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
                            <a href="{{route('periodes.index')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Periode</a>
                            <a href="{{ route('kriterianbp.index',[$periodes->id]) }}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Nilai Bobot Kriteria</a>
                            <i class="fa fa-table"></i> Ubah Data Nilai Bobot Kriteria
                        </div>
                        <div class="col-md-3" style="text-align: right;">
                            <a href="{{ route('kriterianbp.index',[$periodes->id, $devisis->id]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a>
                            <a href="{{ route('devisis.index',[$periodes->id]) }}" class="btn btn-sm btn-success"><i class="fa fa-fw fa-eye"></i> Data Devisi</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
               <div class="x_content">
                    <br />
                    <form method="POST" action="{{ route('kriterianbp.update', [$periodes->id, $devisis->id, $key]) }}" data-parsley-validate class="forms form-horizontal form-label-left" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row col-md-12">
                            <div class="col-md-4 form-group{{ $errors->has('id1') ? ' has-error' : '' }}"  >
                                <label for="id1" class="control-label">Kriteria 1</label>
                                <div>
                                    <select class="form-control" name="id1" id="id1">
                                        @foreach($id1 as $k => $v)
                                        <option value="{{ $v }}" {{ (old('id1')) && old('id1') == $v ? 'selected' : '' }}>{{$v}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('id1'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('id1') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 form-group{{ $errors->has('nilai') ? ' has-error' : '' }}"  >
                                <label for="nilai" class="control-label">Bobot </label>
                                <div>
                                    <select class="form-control" name="nilai" id="nilai">
                                        @foreach($nilai as $k => $v)
                                        <option value="{{ $v }}" {{ (old('nilai')) && old('nilai') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('nilai'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nilai') }}</strong>
                                        </span>
                                    @endif
                                    @if ($errors->has('nilai'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nilai') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 form-group{{ $errors->has('id2') ? ' has-error' : '' }}">
                                <label class="control-label" for="id2">Kriteria 2<span class="required">*</span>
                                </label>
                                <div>
                                    <select class="form-control" id="id2" name="id2">
                                        @foreach($id2s as $row)
                                        <option value="{{$row->kode}}" {{$row->id  ? 'selected="selected"' : ''}}>{{$row->kode}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('id2'))
                                    <span class="help-block">{{ $errors->first('id2') }}</span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <hr>
                        </div>
                        <div class="row mb-12" style="justify-content: center;">
                             <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-8 col-sm-8">
                                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                                    <input name="_method" type="hidden" value="PUT">
                                    <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>Ubah</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
