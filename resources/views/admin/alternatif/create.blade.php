@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Tambah Data Karyawan</h3>
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
                            <a href="{{ route('alternatif.index',[$periodes, 'id'=>null]) }}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Alternatif</a>
                            <i class="fa fa-table"></i> Tambah Data Karyawan
                        </div>
                        <div class="col-md-3" style="text-align: right;">
                            <a href="{{ route('alternatif.index',[$periodes]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
               <div class="x_content">
                    <br />
                    <form  method="post" action="{{ route('alternatif.store',[$periodes])}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" name="formPendaftaran" onsubmit="return validateForm()">
                        {{ csrf_field() }}
                        <div class="row col-md-12">

                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('namaal') ? ' has-error' : '' }}">
                                    <label class="col-md-4" for="namaal">Nama Alternatif  <span class="class="required">*</span>
                                    </label>
                                    <input type="text=" value="" minlength="5" id="namaal" name="namaal" class="col-md-6" placeholder="Nama Alternatif" required>
                                    @if ($errors->has('namaal'))
                                   <span class="help-block">{{ $errors->first('namaal') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('devisi') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-4" for="devisi">Divisi <span class="required">*</span>
                                    </label>
                                    <div>
                                        <select class="selectpicker form-control col-md-6" id="devisi" name="devisi[]" multiple data-live-search="true" required>
                                            @foreach($devisi as $row)
                                            <option value="{{$row->id}}" selected="selected">{{$row->nama}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('devisi'))
                                            <span class="help-block">{{ $errors->first('devisi') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <div class="form-group{{ $errors->has('jabatan') ? ' has-error' : '' }}">
                                    <label class="col-md-3" for="jabatan">Nama Alternatif  <span class="class="required">*</span>
                                    </label>
                                    <input type="text=" value="" id="jabatan" name="jabatan" class="col-md-6" placeholder="Nama Alternatif" required>
                                    @if ($errors->has('jabatan'))
                                   <span class="help-block">{{ $errors->first('jabatan') }}</span>
                                    @endif
                                </div>
                            </div>  -->

                        </div>
                        <div class="row mb-3">
                        </div>
                        <div class="row mb-12" style="justify-content: center;">
                            <div class="ln_solid"></div>
                            <div class="form-group" style="text-align: center;">
                                <div class="col-md-12" >
                                    <input type="hidden" name="_token" value="{{ Session::token() }}">

                                    <button type="submit" class="btn btn-sm btn-success"><i class="ri-add-line"></i>Simpan</button>

                                <!-- <a href="{{ route('alternatif.index',[$periodes]) }}">
                                    <button class="btn btn-sm btn-secondary"><i class="ri-arrow-left-fill"></i>Kembali</button>
                                </a> -->
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
