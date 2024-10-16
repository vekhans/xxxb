@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Tambah Data Kriteria</h3>
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
                            <a href="{{ route('nilai.index',[$periodes, $devisis, $kriterias, 'id'=>null]) }}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Nilai Kriteria</a>
                            <i class="fa fa-table"></i> Tambah Data Nilai Kriteria

                        </div>
                        <div class="col-md-3" style="text-align: right;">
                            <a href="{{ route('nilai.index',[$periodes, $devisis,$kriterias]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="x_content">
                    <br />
                    <form  method="post" action="{{ route('nilai.store',[$periodes, $devisis,$kriterias]) }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" name="formPendaftaran" onsubmit="return validateForm()">
                        {{ csrf_field() }}
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <div class="divs form-group{{ $errors->has('nilai1') ? ' has-error' : '' }}">
                                    <label class="col-md-3" for="nilai1">Nilai 1 Kriteria <span class="required">*</span>
                                    </label>
                                    <input type="number" value="" id="nilai1" name="nilai1" class="masuk" placeholder="Nilai 1 Kriteria" required>
                                    @if ($errors->has('nilai1'))
                                    <span class="help-block">{{ $errors->first('nilai1') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="divs form-group{{ $errors->has('nilai2') ? ' has-error' : '' }}">
                                    <label class="col-md-3" for="nilai2">Nilai 2 Kriteria <span class="required">*</span>
                                    </label>
                                    <input type="number" value="" id="nilai2" name="nilai2" class="masuk" placeholder="Nilai 2 Kriteria" required>
                                    @if ($errors->has('nilai2'))
                                    <span class="help-block">{{ $errors->first('nilai2') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="divs form-group{{ $errors->has('bobot') ? ' has-error' : '' }}">
                                    <label class="col-md-3" for="bobot">Bobot Kriteria  <span class="required">*</span>
                                    </label>
                                    <input type="number" value="" id="bobot" name="bobot" class="masuk" placeholder="bobot Kriteria" required>
                                    @if ($errors->has('bobot'))
                                   <span class="help-block">{{ $errors->first('bobot') }}</span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row col-md-12">
                        </div>
                        <div class="row col-md-12" style="justify-content: center;">
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                <button type="submit" class="btn btn-sm btn-success"><i class="ri-add-line"></i>Simpan</button>
                                <!-- <a href="{{ route('nilai.index',[$periodes, $devisis, $kriterias]) }}">
                                    <button class="btn btn-sm btn-secondary"><i class="ri-arrow-left-fill"></i>Kembali</button>
                                </a> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
